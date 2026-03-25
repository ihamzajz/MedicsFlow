<?php

require_once __DIR__ . '/workorder_bootstrap.php';
require_once __DIR__ . '/workorder_mail.php';

workorder_require_login();
workorder_require_post_csrf();

if (!workorder_can_ceo_act()) {
    workorder_abort(403, 'You are not allowed to reject CEO workorders.');
}

$requestId = workorder_get_request_id_from_post();
$reason = trim((string)($_POST['reason'] ?? ''));

if ($reason === '') {
    workorder_flash('danger', 'Rejection reason is required.');
    workorder_redirect('workorder_ceo_list.php');
}

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
$rejected = 'Rejected';
$ceoMsg = 'Rejected By ' . $approverName;
$taskStatus = workorder_task_status_rejected_by($approverName);

$stmt = workorder_prepare('UPDATE workorder_form SET ceo_status = ?, ceo_msg = ?, task_status = ?, reason = ? WHERE id = ? AND ceo_status = ?');
$pending = 'Pending';
$stmt->bind_param('ssssis', $rejected, $ceoMsg, $taskStatus, $reason, $requestId, $pending);
$stmt->execute();
$updated = $stmt->affected_rows > 0;
$stmt->close();

if (!$updated) {
    workorder_flash('danger', 'This request was already updated by someone else.');
    workorder_redirect('workorder_ceo_list.php');
}

workorder_log_action($requestId, 'ceo', 'rejected', $reason);

try {
    $mail = workorder_create_mailer('ceo');
    workorder_mail_add_address($mail, (string)($request['email'] ?? ''));
    $reasonHtml = nl2br(workorder_h($reason));
    $mail->Subject = 'WorkOrder Request Update';
    $mail->Body = "
    <p>Your WorkOrder request has been Rejected by " . workorder_h($approverName) . ".</p>
    <p><strong>Reason:</strong> {$reasonHtml}</p>
    ";
    $mail->AltBody = 'Your WorkOrder request has been Rejected by ' . $approverName . '. Reason: ' . $reason;
    workorder_mail_deliver($mail);
    workorder_flash('success', 'Workorder rejected successfully.');
} catch (Throwable $e) {
    error_log('Workorder CEO reject mail failed: ' . $e->getMessage());
    workorder_flash('warning', 'Workorder rejected, but the notification email could not be sent.');
}

workorder_redirect('workorder_ceo_list.php');
