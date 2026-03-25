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
