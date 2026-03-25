<?php

use PHPMailer\PHPMailer\PHPMailer;

return [
    // Master switch for all workorder emails.
    // true  = emails can send
    // false = no workorder email will be sent
    'enabled' => true,

    // Testing mode:
    // false = send to real recipients
    // true  = send every workorder email only to test_email below
    'force_to_test_inbox' => false,

    // Dummy/test inbox used only when force_to_test_inbox is true.
    // Example: 'hamza.test@yourcompany.com'
    'test_email' => 'ihamzajz@gmail.com',

    // Display name for the dummy/test inbox.
    'test_name' => 'Hamza Workorder Test',

    // Main sender account used for all workorder emails.
    'host' => 'smtp.office365.com',
    'port' => 587,
    'secure' => PHPMailer::ENCRYPTION_STARTTLS,
    'username' => 'info@medicslab.com',
    'password' => 'kcmzrskfgmwzzshz',
    'from_email' => 'info@medicslab.com',
    'from_name' => 'Medics Digital Form',
    'smtp_auth' => true,
    'debug' => 0,

    // Fixed department routing emails.
    // Change these here if the position holder changes later.
    'routing' => [
        'admin_department' => ['email' => 'jawwad.ali@medicslab.com', 'name' => 'Admin Department'],
        'engineering_department' => ['email' => 'taha.khan@medicslab.com', 'name' => 'Engineering Department'],
        'finance_department' => ['email' => 'danish.tanveer@medicslab.com', 'name' => 'Finance Department'],
    ],
];
