<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

$requestId = workorder_get_request_id_from_post();
$request = workorder_fetch_request($requestId);

if (!$request) {
    workorder_flash('danger', 'Workorder request not found.');
    workorder_redirect('workorder_head_list.php');
}

if (!workorder_can_head_act($request)) {
    workorder_abort(403, 'You are not allowed to approve this workorder.');
}

if (!workorder_request_is_head_pending($request)) {
    workorder_flash('danger', 'This request is no longer pending head approval.');
    workorder_redirect('workorder_head_list.php');
}

$approverName = (string)workorder_session('fullname');
$now = workorder_now();
$headMsg = 'Approved By ' . $approverName;
$taskStatus = workorder_task_status_approval_pending();
$finalStatus = workorder_final_status_approval_pending();
$pending = 'Pending';
$approved = 'Approved';

$stmt = workorder_prepare(
    'UPDATE workorder_form
     SET head_status = ?, head_msg = ?, head_date = ?, task_status = ?, final_status = ?
     WHERE id = ? AND head_status = ?'
);
$stmt->bind_param('sssssis', $approved, $headMsg, $now, $taskStatus, $finalStatus, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_head_list.php');
}

workorder_log_action($requestId, 'head', 'approved', $headMsg);

$requesterName = (string)($request['name'] ?? 'Concern');
$requesterEmail = (string)($request['email'] ?? '');
$requestDepartType = strtolower(trim((string)($request['depart_type'] ?? '')));

try {
    $mail = workorder_create_mailer('default');
    workorder_mail_add_address($mail, $requesterEmail);
    $mail->Subject = 'Workorder Notification';
    $mail->Body = "
    <p>Dear {$requesterName},</p>
    <p>Your work order request <strong>#{$requestId}</strong> has been <strong>approved</strong> by <strong>{$approverName}</strong>.</p>
    <p>Your request is now moving forward for further processing.</p>
    <p>Thank you.</p>
    <p>Best regards,<br><strong>MedicsFlow</strong></p>
    ";
    workorder_mail_deliver($mail);

    $mail->clearAddresses();
    if ($requestDepartType === 'engineering') {
        $route = workorder_mail_route('engineering_department');
        workorder_mail_add_address($mail, $route['email'], $route['name']);
        $mail->Body = "
        <p>Dear Engineering Department,</p>
        <p>A new work order request <strong>#{$requestId}</strong> has been submitted by <strong>{$requesterName}</strong> and approved at the initial level.</p>
        <p>Kindly review and proceed with the necessary action in <strong>MedicsFlow</strong>.</p>
        <p>Best regards,<br><strong>MedicsFlow</strong></p>
        ";
    } else {
        $route = workorder_mail_route('admin_department');
        workorder_mail_add_address($mail, $route['email'], $route['name']);
        $mail->Body = "
        <p>Dear Admin Department,</p>
        <p>A new work order request <strong>#{$requestId}</strong> has been submitted by <strong>{$requesterName}</strong> and approved at the initial level.</p>
        <p>Kindly review and proceed with the necessary action in <strong>MedicsFlow</strong>.</p>
        <p>Best regards,<br><strong>MedicsFlow</strong></p>
        ";
    }

    $mail->Subject = 'Workorder Notification';
    workorder_mail_deliver($mail);
    workorder_flash('success', 'Workorder approved successfully.');
} catch (Throwable $e) {
    error_log('Workorder head approve mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder approved, but one or more notification emails could not be sent.');
}

workorder_redirect('workorder_head_list.php');
