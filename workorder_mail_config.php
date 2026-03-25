<?php

use PHPMailer\PHPMailer\PHPMailer;

return [
    'host' => 'smtp.gmail.com',
    'port' => 465,
    'secure' => PHPMailer::ENCRYPTION_SMTPS,
    'username' => 'hamza.mediclabs@gmail.com',
    'password' => 'hwxxkrrezfslrjil',
    'from_email' => 'hamza.mediclabs@gmail.com',
    'from_name' => 'Medics Digital Form',
    'smtp_auth' => true,
    'debug' => 0,
];
