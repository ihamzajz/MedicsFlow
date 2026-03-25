<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/dbconfig.php';
require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Asia/Karachi');

function workorder_require_login(): void
{
    if (empty($_SESSION['loggedin'])) {
        header('Location: login.php');
        exit;
    }
}

function workorder_h($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function workorder_now(): string
{
    return date('Y-m-d H:i:s');
}

function workorder_task_status_approval_pending(): string
{
    return 'Approval Pending';
}

function workorder_final_status_approval_pending(): string
{
    return 'Approval Pending';
}

function workorder_task_status_work_in_progress(): string
{
    return 'Work In Progress';
}

function workorder_final_status_work_in_progress(): string
{
    return 'Work In Progress';
}

function workorder_task_status_completed(): string
{
    return 'Task Completed';
}

function workorder_final_status_completed(): string
{
    return 'Completed';
}

function workorder_task_status_rejected_by(string $actorName): string
{
    return 'Rejected By ' . trim($actorName);
}

function workorder_db(): mysqli
{
    global $conn;
    return $conn;
}

function workorder_session(string $key, $default = '')
{
    return $_SESSION[$key] ?? $default;
}

function workorder_flash(string $type, string $message): void
{
    $_SESSION['workorder_flash'] = ['type' => $type, 'message' => $message];
}

function workorder_take_flash(): ?array
{
    if (!isset($_SESSION['workorder_flash'])) {
        return null;
    }

    $flash = $_SESSION['workorder_flash'];
    unset($_SESSION['workorder_flash']);
    return is_array($flash) ? $flash : null;
}

function workorder_redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function workorder_abort(int $statusCode, string $message = 'Unable to process this request.'): void
{
    http_response_code($statusCode);
    exit($message);
}

function workorder_ensure_csrf_token(): string
{
    if (empty($_SESSION['workorder_csrf'])) {
        $_SESSION['workorder_csrf'] = bin2hex(random_bytes(32));
    }

    return (string)$_SESSION['workorder_csrf'];
}

function workorder_csrf_input(): string
{
    return '<input type="hidden" name="workorder_csrf" value="' . workorder_h(workorder_ensure_csrf_token()) . '">';
}

function workorder_require_post_csrf(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        workorder_abort(405, 'Invalid request method.');
    }

    $token = $_POST['workorder_csrf'] ?? '';
    $sessionToken = $_SESSION['workorder_csrf'] ?? '';

    if (!is_string($token) || !is_string($sessionToken) || $sessionToken === '' || !hash_equals($sessionToken, $token)) {
        workorder_abort(419, 'Security token mismatch. Please try again.');
    }
}

function workorder_prepare(string $sql): mysqli_stmt
{
    $stmt = workorder_db()->prepare($sql);
    if (!$stmt) {
        throw new RuntimeException('Query preparation failed: ' . workorder_db()->error);
    }

    return $stmt;
}

function workorder_fetch_request(int $requestId): ?array
{
    $stmt = workorder_prepare('SELECT * FROM workorder_form WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $requestId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result ? $result->fetch_assoc() : null;
    $stmt->close();
    return $row ?: null;
}

function workorder_get_request_id_from_post(): int
{
    $requestId = filter_input(INPUT_POST, 'request_id', FILTER_VALIDATE_INT);
    if (!$requestId || $requestId < 1) {
        workorder_abort(422, 'Invalid request id.');
    }

    return (int)$requestId;
}

function workorder_is_super_user(): bool
{
    $beDepart = strtolower(trim((string)workorder_session('be_depart')));
    return $beDepart === 'super' || $beDepart === 'it';
}

function workorder_can_head_act(array $request): bool
{
    if (workorder_is_super_user()) {
        return true;
    }

    $beRole = strtolower(trim((string)workorder_session('be_role')));
    $actorDepart = strtolower(trim((string)workorder_session('be_depart')));
    $requestDepart = strtolower(trim((string)($request['be_depart'] ?? '')));

    return $beRole === 'approver' && $actorDepart !== '' && $actorDepart === $requestDepart;
}

function workorder_can_engineering_act(bool $closeout = false): bool
{
    if (workorder_is_super_user()) {
        return true;
    }

    $department = strtolower(trim((string)workorder_session('department')));
    $role = strtolower(trim((string)workorder_session('role')));
    $beDepart = strtolower(trim((string)workorder_session('be_depart')));
    $beRole = strtolower(trim((string)workorder_session('be_role')));

    if ($department === 'engineering' && $role === 'head of department') {
        return true;
    }

    if ($closeout && $beDepart === 'eng' && $beRole === 'user') {
        return true;
    }

    return false;
}

function workorder_can_admin_act(): bool
{
    if (workorder_is_super_user()) {
        return true;
    }

    $department = strtolower(trim((string)workorder_session('department')));
    $role = strtolower(trim((string)workorder_session('role')));
    return $department === 'administration' && $role === 'manager administration';
}

function workorder_can_finance_act(): bool
{
    if (workorder_is_super_user()) {
        return true;
    }

    $role = strtolower(trim((string)workorder_session('role')));
    $beDepart = strtolower(trim((string)workorder_session('be_depart')));
    $beRole = strtolower(trim((string)workorder_session('be_role')));

    return $role === 'manager financial planning and analysis' || ($beDepart === 'finance' && $beRole === 'approver');
}

function workorder_can_ceo_act(): bool
{
    if (workorder_is_super_user()) {
        return true;
    }

    $role = strtolower(trim((string)workorder_session('role')));
    $username = strtolower(trim((string)workorder_session('username')));
    $beDepart = strtolower(trim((string)workorder_session('be_depart')));
    $beRole = strtolower(trim((string)workorder_session('be_role')));

    return $role === 'ceo' || $username === 'super' || $beDepart === 'dir' || $beRole === 'ceo';
}

function workorder_request_is_head_pending(array $request): bool
{
    return strcasecmp((string)($request['head_status'] ?? ''), 'Pending') === 0;
}

function workorder_request_is_admin_pending(array $request): bool
{
    return strcasecmp((string)($request['admin_status'] ?? ''), 'Pending') === 0;
}

function workorder_request_is_engineering_pending(array $request): bool
{
    return strcasecmp((string)($request['engineering_status'] ?? ''), 'Pending') === 0;
}

function workorder_request_is_finance_pending(array $request): bool
{
    return strcasecmp((string)($request['finance_status'] ?? ''), 'Pending') === 0;
}

function workorder_request_is_ceo_pending(array $request): bool
{
    return strcasecmp((string)($request['ceo_status'] ?? ''), 'Pending') === 0;
}

function workorder_ensure_action_log_table(): void
{
    static $ready = false;
    if ($ready) {
        return;
    }

    $sql = "CREATE TABLE IF NOT EXISTS workorder_action_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        request_id INT NOT NULL,
        action_stage VARCHAR(50) NOT NULL,
        action_name VARCHAR(50) NOT NULL,
        actor_name VARCHAR(255) DEFAULT '',
        actor_username VARCHAR(255) DEFAULT '',
        actor_role VARCHAR(255) DEFAULT '',
        note TEXT NULL,
        created_at DATETIME NOT NULL,
        INDEX idx_workorder_action_log_request (request_id),
        INDEX idx_workorder_action_log_stage (action_stage)
    )";

    workorder_db()->query($sql);
    $ready = true;
}

function workorder_ensure_mail_log_table(): void
{
    static $ready = false;
    if ($ready) {
        return;
    }

    $sql = "CREATE TABLE IF NOT EXISTS workorder_mail_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        request_id INT DEFAULT NULL,
        mail_to TEXT NULL,
        subject VARCHAR(255) DEFAULT '',
        delivery_status VARCHAR(50) NOT NULL,
        note TEXT NULL,
        created_at DATETIME NOT NULL,
        INDEX idx_workorder_mail_log_request (request_id),
        INDEX idx_workorder_mail_log_status (delivery_status)
    )";

    workorder_db()->query($sql);
    $ready = true;
}

function workorder_log_action(int $requestId, string $stage, string $action, string $note = ''): void
{
    workorder_ensure_action_log_table();

    $stmt = workorder_prepare(
        'INSERT INTO workorder_action_log (request_id, action_stage, action_name, actor_name, actor_username, actor_role, note, created_at)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $actorName = (string)workorder_session('fullname');
    $actorUsername = (string)workorder_session('username');
    $actorRole = (string)workorder_session('role');
    $createdAt = workorder_now();

    $stmt->bind_param('isssssss', $requestId, $stage, $action, $actorName, $actorUsername, $actorRole, $note, $createdAt);
    $stmt->execute();
    $stmt->close();
}

function workorder_latest_action_note(int $requestId, string $stage, string $action = 'rejected'): string
{
    workorder_ensure_action_log_table();

    $stmt = workorder_prepare(
        'SELECT note
         FROM workorder_action_log
         WHERE request_id = ? AND action_stage = ? AND action_name = ?
         ORDER BY id DESC
         LIMIT 1'
    );
    $stmt->bind_param('iss', $requestId, $stage, $action);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result ? $result->fetch_assoc() : null;
    $stmt->close();

    return trim((string)($row['note'] ?? ''));
}

function workorder_log_mail(?int $requestId, string $mailTo, string $subject, string $deliveryStatus, string $note = ''): void
{
    workorder_ensure_mail_log_table();

    $createdAt = workorder_now();
    $stmt = workorder_prepare(
        'INSERT INTO workorder_mail_log (request_id, mail_to, subject, delivery_status, note, created_at)
         VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->bind_param('isssss', $requestId, $mailTo, $subject, $deliveryStatus, $note, $createdAt);
    $stmt->execute();
    $stmt->close();
}

function workorder_render_action_forms_js(): string
{
    return <<<HTML
<script>
function workorderSubmitReason(formId, promptText) {
    var form = document.getElementById(formId);
    if (!form) return false;
    var reason = window.prompt(promptText || "Enter reason for rejection:");
    if (reason === null) return false;
    reason = reason.trim();
    if (!reason) {
        alert("Reason is required.");
        return false;
    }
    var input = form.querySelector('input[name="reason"]');
    if (input) {
        input.value = reason;
    }
    form.submit();
    return false;
}
</script>
HTML;
}
