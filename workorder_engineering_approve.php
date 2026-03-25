<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

if (!workorder_can_engineering_act()) {
    workorder_abort(403, 'You are not allowed to approve engineering workorders.');
}

$requestId = workorder_get_request_id_from_post();
$request = workorder_fetch_request($requestId);

if (!$request) {
    workorder_flash('danger', 'Workorder request not found.');
    workorder_redirect('workorder_engineering_list.php');
}

if (strcasecmp((string)($request['depart_type'] ?? ''), 'Engineering') !== 0 || !workorder_request_is_engineering_pending($request)) {
    workorder_flash('danger', 'This request is no longer available for engineering approval.');
    workorder_redirect('workorder_engineering_list.php');
}

$approverName = (string)workorder_session('fullname');
$now = workorder_now();
$engineeringMsg = 'Approved By ' . $approverName;
$taskStatus = 'Work in progress';
$finalStatus = 'Work In Progress';
$approved = 'Approved';
$pending = 'Pending';

$stmt = workorder_prepare(
    'UPDATE workorder_form
     SET engineering_status = ?, engineering_msg = ?, eng_date = ?, task_status = ?, final_status = ?
     WHERE id = ? AND engineering_status = ?'
);
$stmt->bind_param('sssssis', $approved, $engineeringMsg, $now, $taskStatus, $finalStatus, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_engineering_list.php');
}

workorder_log_action($requestId, 'engineering', 'approved', $engineeringMsg);

try {
    $mail = workorder_create_mailer('default');
    $mail->addAddress((string)($request['email'] ?? ''));
    $mail->Subject = 'Workorder Notification';
    $mail->Body = "
    <p>Dear Concern,</p>
    <p>Your work order request <strong>#{$requestId}</strong> has been <strong>Approved</strong> by <strong>{$approverName}</strong>.</p>
    <p>If you have any questions or require further assistance, please feel free to contact us.</p>
    <p>Thank you.</p>
    <p>Best regards,<br><strong>MedicsFlow</strong></p>
    ";
    $mail->send();
    workorder_flash('success', 'Workorder approved successfully.');
} catch (Throwable $e) {
    error_log('Workorder engineering approve mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder approved, but the notification email could not be sent.');
}

workorder_redirect('workorder_engineering_list.php');
