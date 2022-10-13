<?php

return [
    "email" => (string)env("EMAIL_SENDER_EMAIL", "notreply@sputnik-ttit.bizml.ru"),
    "name" => (string)env("EMAIL_SENDER_NAME", "test"),
    "password" => (string)env("EMAIL_SENDER_PASSWORD", "bkmz[htyj,ec"),
    "host" => (string)env("EMAIL_SENDER_HOST", "smtp.mail.ru")
];
