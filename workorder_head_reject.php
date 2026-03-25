<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

$requestId = workorder_get_request_id_from_post();
$reason = trim((string)($_POST['reason'] ?? ''));

if ($reason === '') {
    workorder_flash('danger', 'Rejection reason is required.');
    workorder_redirect('workorder_head_list.php');
}

$request = workorder_fetch_request($requestId);

if (!$request) {
    workorder_flash('danger', 'Workorder request not found.');
    workorder_redirect('workorder_head_list.php');
}

if (!workorder_can_head_act($request)) {
    workorder_abort(403, 'You are not allowed to reject this workorder.');
}

if (!workorder_request_is_head_pending($request)) {
    workorder_flash('danger', 'This request is no longer pending head approval.');
    workorder_redirect('workorder_head_list.php');
}

$approverName = (string)workorder_session('fullname');
$now = workorder_now();
$headMsg = 'Rejected By ' . $approverName;
$taskStatus = 'Rejected By ' . $approverName;
$finalStatus = 'Rejected';
$pending = 'Pending';
$rejected = 'Rejected';

$stmt = workorder_prepare(
    'UPDATE workorder_form
     SET head_status = ?, head_msg = ?, head_date = ?, task_status = ?, final_status = ?, reason = ?
     WHERE id = ? AND head_status = ?'
);
$stmt->bind_param('ssssssis', $rejected, $headMsg, $now, $taskStatus, $finalStatus, $reason, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_head_list.php');
}

workorder_log_action($requestId, 'head', 'rejected', $reason);

$requesterName = (string)($request['name'] ?? 'Concern');
$requesterEmail = (string)($request['email'] ?? '');
$reasonHtml = nl2br(workorder_h($reason));

try {
    $mail = workorder_create_mailer('default');
    workorder_mail_add_address($mail, $requesterEmail);
    $mail->Subject = 'Workorder Notification';
    $mail->Body = "
    <p>Dear {$requesterName},</p>
    <p>We regret to inform you that your work order request <strong>#{$requestId}</strong> has been <strong>rejected</strong> by <strong>{$approverName}</strong>.</p>
    <p><strong>Reason:</strong> {$reasonHtml}</p>
    <p>If you require further clarification or wish to discuss this decision, please feel free to reach out.</p>
    <p>Thank you for your understanding.</p>
    <p>Best regards,<br><strong>MedicsFlow</strong></p>
    ";
    workorder_mail_deliver($mail);
    workorder_flash('success', 'Workorder rejected successfully.');
} catch (Throwable $e) {
    error_log('Workorder head reject mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder rejected, but the notification email could not be sent.');
}

workorder_redirect('workorder_head_list.php');
