<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

if (!workorder_can_finance_act()) {
    workorder_abort(403, 'You are not allowed to approve finance workorders.');
}

$requestId = workorder_get_request_id_from_post();
$request = workorder_fetch_request($requestId);

if (!$request) {
    workorder_flash('danger', 'Workorder request not found.');
    workorder_redirect('workorder_finance_list.php');
}

if (!workorder_request_is_finance_pending($request)) {
    workorder_flash('danger', 'This request is no longer available for finance approval.');
    workorder_redirect('workorder_finance_list.php');
}

$approverName = (string)workorder_session('fullname');
$now = workorder_now();
$financeMsg = 'Approved By ' . $approverName;
$taskStatus = 'Work in progress';
$finalStatus = 'Work In Progress';
$pending = 'Pending';
$approved = 'Approved';

$stmt = workorder_prepare(
    'UPDATE workorder_form
     SET finance_status = ?, finance_msg = ?, fc_date = ?, task_status = ?, final_status = ?
     WHERE id = ? AND finance_status = ?'
);
$stmt->bind_param('sssssis', $approved, $financeMsg, $now, $taskStatus, $finalStatus, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_finance_list.php');
}

workorder_log_action($requestId, 'finance', 'approved', $financeMsg);

try {
    $mail = workorder_create_mailer('default');
    workorder_mail_add_address($mail, (string)($request['email'] ?? ''));
    $mail->Subject = 'Workorder Notification';
    $mail->Body = "
    <p>Dear Concern,</p>
    <p>Your work order request <strong>#{$requestId}</strong> has been <strong>Approved</strong> by the <strong>Finance Department</strong>.</p>
    <p>The request status has been updated to <strong>Work in Progress</strong>.</p>
    <p>Thank you.</p>
    <p>Best regards,<br><strong>MedicsFlow</strong></p>
    ";
    workorder_mail_deliver($mail);
    workorder_flash('success', 'Workorder approved successfully.');
} catch (Throwable $e) {
    error_log('Workorder finance approve mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder approved, but the notification email could not be sent.');
}

workorder_redirect('workorder_finance_list.php');
