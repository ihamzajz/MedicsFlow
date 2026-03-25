<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

if (!workorder_can_finance_act()) {
    workorder_abort(403, 'You are not allowed to reject finance workorders.');
}

$requestId = workorder_get_request_id_from_post();
$reason = trim((string)($_POST['reason'] ?? ''));

if ($reason === '') {
    workorder_flash('danger', 'Rejection reason is required.');
    workorder_redirect('workorder_finance_list.php');
}

$request = workorder_fetch_request($requestId);

if (!$request) {
    workorder_flash('danger', 'Workorder request not found.');
    workorder_redirect('workorder_finance_list.php');
}

if (!workorder_request_is_finance_pending($request)) {
    workorder_flash('danger', 'This request is no longer available for finance rejection.');
    workorder_redirect('workorder_finance_list.php');
}

$approverName = (string)workorder_session('fullname');
$now = workorder_now();
$financeMsg = 'Rejected By ' . $approverName;
$taskStatus = 'Rejected By ' . $approverName;
$finalStatus = 'Rejected';
$pending = 'Pending';
$rejected = 'Rejected';

$stmt = workorder_prepare(
    'UPDATE workorder_form
     SET finance_status = ?, finance_msg = ?, fc_date = ?, task_status = ?, final_status = ?, reason = ?
     WHERE id = ? AND finance_status = ?'
);
$stmt->bind_param('ssssssis', $rejected, $financeMsg, $now, $taskStatus, $finalStatus, $reason, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_finance_list.php');
}

workorder_log_action($requestId, 'finance', 'rejected', $reason);

try {
    $mail = workorder_create_mailer('default');
    $mail->addAddress((string)($request['email'] ?? ''));
    $reasonHtml = nl2br(workorder_h($reason));
    $mail->Subject = 'Workorder Notification';
    $mail->Body = "
    <p>Dear Concern,</p>
    <p>Your work order request <strong>#{$requestId}</strong> has been <strong>Rejected</strong> by the <strong>Finance Department</strong>.</p>
    <p><strong>Reason:</strong> {$reasonHtml}</p>
    <p>Thank you.</p>
    <p>Best regards,<br><strong>MedicsFlow</strong></p>
    ";
    $mail->send();
    workorder_flash('success', 'Workorder rejected successfully.');
} catch (Throwable $e) {
    error_log('Workorder finance reject mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder rejected, but the notification email could not be sent.');
}

workorder_redirect('workorder_finance_list.php');
