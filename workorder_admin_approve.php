<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

if (!workorder_can_admin_act()) {
    workorder_abort(403, 'You are not allowed to approve admin workorders.');
}

$requestId = workorder_get_request_id_from_post();
$request = workorder_fetch_request($requestId);

if (!$request) {
    workorder_flash('danger', 'Workorder request not found.');
    workorder_redirect('workorder_admin_list.php');
}

if (strcasecmp((string)($request['depart_type'] ?? ''), 'Admin') !== 0 || !workorder_request_is_admin_pending($request)) {
    workorder_flash('danger', 'This request is no longer available for admin approval.');
    workorder_redirect('workorder_admin_list.php');
}

$approverName = (string)workorder_session('fullname');
$now = workorder_now();
$taskStatus = 'Work in progress';
$finalStatus = 'Work In Progress';
$adminMsg = 'Approved By ' . $approverName;

$stmt = workorder_prepare(
    'UPDATE workorder_form
     SET admin_status = ?, admin_msg = ?, admin_date = ?, task_status = ?, final_status = ?
     WHERE id = ? AND admin_status = ?'
);
$pending = 'Pending';
$approved = 'Approved';
$stmt->bind_param('sssssis', $approved, $adminMsg, $now, $taskStatus, $finalStatus, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_admin_list.php');
}

workorder_log_action($requestId, 'admin', 'approved', $adminMsg);

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
    error_log('Workorder admin approve mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder approved, but the notification email could not be sent.');
}

workorder_redirect('workorder_admin_list.php');
