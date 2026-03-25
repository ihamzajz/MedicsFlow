<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

if (!workorder_can_engineering_act()) {
    workorder_abort(403, 'You are not allowed to reject engineering workorders.');
}

$requestId = workorder_get_request_id_from_post();
$reason = trim((string)($_POST['reason'] ?? ''));

if ($reason === '') {
    workorder_flash('danger', 'Rejection reason is required.');
    workorder_redirect('workorder_engineering_list.php');
}

$request = workorder_fetch_request($requestId);

if (!$request) {
    workorder_flash('danger', 'Workorder request not found.');
    workorder_redirect('workorder_engineering_list.php');
}

if (strcasecmp((string)($request['depart_type'] ?? ''), 'Engineering') !== 0 || !workorder_request_is_engineering_pending($request)) {
    workorder_flash('danger', 'This request is no longer available for engineering rejection.');
    workorder_redirect('workorder_engineering_list.php');
}

$approverName = (string)workorder_session('fullname');
$now = workorder_now();
$engineeringMsg = 'Rejected By ' . $approverName;
$taskStatus = workorder_task_status_rejected_by($approverName);
$finalStatus = 'Rejected';
$pending = 'Pending';
$rejected = 'Rejected';

$stmt = workorder_prepare(
    'UPDATE workorder_form
     SET engineering_status = ?, engineering_msg = ?, eng_date = ?, task_status = ?, final_status = ?, reason = ?
     WHERE id = ? AND engineering_status = ?'
);
$stmt->bind_param('ssssssis', $rejected, $engineeringMsg, $now, $taskStatus, $finalStatus, $reason, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_engineering_list.php');
}

workorder_log_action($requestId, 'engineering', 'rejected', $reason);

try {
    $mail = workorder_create_mailer('default');
    workorder_mail_add_address($mail, (string)($request['email'] ?? ''));
    $reasonHtml = nl2br(workorder_h($reason));
    $mail->Subject = 'Workorder Notification';
    $mail->Body = "
    <p>Dear Concern,</p>
    <p>Your work order request <strong>#{$requestId}</strong> has been <strong>Rejected</strong> by <strong>{$approverName}</strong>.</p>
    <p><strong>Reason:</strong> {$reasonHtml}</p>
    <p>Thank you.</p>
    <p>Best regards,<br><strong>MedicsFlow</strong></p>
    ";
    workorder_mail_deliver($mail);
    workorder_flash('success', 'Workorder rejected successfully.');
} catch (Throwable $e) {
    error_log('Workorder engineering reject mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder rejected, but the notification email could not be sent.');
}

workorder_redirect('workorder_engineering_list.php');
