<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

if (!workorder_can_ceo_act()) {
    workorder_abort(403, 'You are not allowed to approve CEO workorders.');
}

$requestId = workorder_get_request_id_from_post();
$request = workorder_fetch_request($requestId);

if (!$request) {
    workorder_flash('danger', 'Workorder request not found.');
    workorder_redirect('workorder_ceo_list.php');
}

if (!workorder_request_is_ceo_pending($request)) {
    workorder_flash('danger', 'This request is no longer pending CEO approval.');
    workorder_redirect('workorder_ceo_list.php');
}

$approverName = (string)workorder_session('fullname');
$approved = 'Approved';
$ceoMsg = 'Approved By ' . $approverName;
$taskStatus = 'WIP';

$stmt = workorder_prepare('UPDATE workorder_form SET ceo_status = ?, ceo_msg = ?, task_status = ? WHERE id = ? AND ceo_status = ?');
$pending = 'Pending';
$stmt->bind_param('sssis', $approved, $ceoMsg, $taskStatus, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_ceo_list.php');
}

workorder_log_action($requestId, 'ceo', 'approved', $ceoMsg);

try {
    $mail = workorder_create_mailer('ceo');
    $mail->addAddress((string)($request['email'] ?? ''));
    $mail->Subject = 'WorkOrder Request Update';
    $mail->Body = 'Your WorkOrder request has been Approved by ' . workorder_h($approverName);
    $mail->AltBody = 'Your WorkOrder request has been Approved by ' . $approverName;
    $mail->send();
    workorder_flash('success', 'Workorder approved successfully.');
} catch (Throwable $e) {
    error_log('Workorder CEO approve mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder approved, but the notification email could not be sent.');
}

workorder_redirect('workorder_ceo_list.php');
