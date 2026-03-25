<?php

require_once __DIR__ . '/workorder_bootstrap.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function workorder_mail_settings(): array
{
    $configFile = __DIR__ . '/workorder_mail_config.php';
    if (!is_file($configFile)) {
        throw new RuntimeException('Mail settings are missing. Configure workorder_mail_config.php first.');
    }

    $settings = require $configFile;
    if (!is_array($settings)) {
        throw new RuntimeException('Invalid workorder mail configuration.');
    }

    return $settings;
}

function workorder_create_mailer(string $profile = 'default'): PHPMailer
{
    unset($profile);
    $profileSettings = workorder_mail_settings();

    if (empty($profileSettings['host']) || empty($profileSettings['username']) || empty($profileSettings['password']) || empty($profileSettings['from_email'])) {
        throw new RuntimeException('Mail settings are missing. Configure workorder mail first.');
    }

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = (int)($profileSettings['debug'] ?? 0);
    $mail->Debugoutput = 'error_log';
    $mail->isSMTP();
    $mail->Host = (string)$profileSettings['host'];
    $mail->SMTPAuth = (bool)($profileSettings['smtp_auth'] ?? true);
    $mail->Username = (string)$profileSettings['username'];
    $mail->Password = (string)$profileSettings['password'];
    $mail->SMTPSecure = (string)($profileSettings['secure'] ?? PHPMailer::ENCRYPTION_STARTTLS);
    $mail->Port = (int)($profileSettings['port'] ?? 587);
    $mail->setFrom((string)$profileSettings['from_email'], (string)($profileSettings['from_name'] ?? 'Medics Digital Form'));
    $mail->isHTML(true);

    return $mail;
}

function workorder_mail_is_enabled(): bool
{
    $settings = workorder_mail_settings();
    return !empty($settings['enabled']);
}

function workorder_mail_test_recipient(): ?array
{
    $settings = workorder_mail_settings();
    if (empty($settings['force_to_test_inbox']) || empty($settings['test_email'])) {
        return null;
    }

    return [
        'email' => (string)$settings['test_email'],
        'name' => (string)($settings['test_name'] ?? 'Workorder Test Inbox'),
    ];
}

function workorder_mail_add_address(PHPMailer $mail, string $email, string $name = ''): void
{
    $testRecipient = workorder_mail_test_recipient();
    if ($testRecipient) {
        $mail->clearAddresses();
        $mail->addAddress($testRecipient['email'], $testRecipient['name']);
        return;
    }

    if ($email === '') {
        throw new RuntimeException('Missing recipient email address.');
    }

    $mail->addAddress($email, $name);
}

function workorder_mail_deliver(PHPMailer $mail): bool
{
    if (!workorder_mail_is_enabled()) {
        return false;
    }

    return $mail->send();
}

function workorder_mail_route(string $key): array
{
    $settings = workorder_mail_settings();
    $route = $settings['routing'][$key] ?? null;

    if (!is_array($route) || empty($route['email'])) {
        throw new RuntimeException('Missing mail route configuration for ' . $key . '.');
    }

    return [
        'email' => (string)$route['email'],
        'name' => (string)($route['name'] ?? ''),
    ];
}
