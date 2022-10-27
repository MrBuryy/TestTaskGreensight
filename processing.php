<?php

$is_new_user = true;
$is_correct_input = true;
$error_fields = [];
$users = [
    [
        "id" => 1,
        "name" => 'Ivan',
        "email" => 'ivan@mail.ru',
    ],
    [
        "id" => 2,
        "name" => 'Alex',
        "email" => 'alex@mail.ru',
    ],
    [
        "id" => 3,
        "name" => 'Serge',
        "email" => 'serge@mail.ru',
    ],
    [
        "id" => 4,
        "name" => 'Andrew',
        "email" => 'andrew@mail.ru',
    ],
    [
        "id" => 5,
        "name" => 'Eugen',
        "email" => 'eugen@mail.ru',
    ]
];

if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $error_fields['email'] = 'Please enter a valid email';
    $is_correct_input = false;
}

if (empty($_POST['password']) || empty($_POST['confirm_password']) || ($_POST['password'] !== $_POST['confirm_password'])) {
    $error_fields['password'] = 'Passwords are not the same';
    $error_fields['confirm_password'] = 'Passwords are not the same';
    $is_correct_input = false;
}

if ($is_correct_input) {
    $user_sing_up = [
        "email" => $_POST['email'],
    ];
    foreach ($users as $user) {
        if ($user['email'] === $user_sing_up['email']) {
            $is_new_user = false;
        }
    }
    if ($is_new_user) {
        $logMessage = '[' . date('Y-m-d H:i:s') . '] - new user: ' . $user_sing_up['email'] . PHP_EOL;
    } else {
        $logMessage = '[' . date('Y-m-d H:i:s') . '] - repeat user: ' . $user_sing_up['email'] . PHP_EOL;
    }
} else {
    $errors_log = array_unique($error_fields);

    $logMessage = '[' . date('Y-m-d H:i:s') . '] - ' . implode(', ', $errors_log) . PHP_EOL;
}

$response = [
    "fields" => $error_fields,
    "is_correct_input" => $is_correct_input,
    "is_new_user" => $is_new_user,
];

echo json_encode($response);

file_put_contents('logs.log', $logMessage, FILE_APPEND);
