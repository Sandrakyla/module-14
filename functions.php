<?php
session_start();

// Подключение данных пользователей
function getUsersList() {
    return include 'users.php';
}

// Проверка существования пользователя
function existsUser($login) {
    $users = getUsersList();
    return isset($users[$login]);
}

// Проверка пароля
function checkPassword($login, $password) {
    $users = getUsersList();
    if (!existsUser($login)) {
        error_log("Пользователь $login не найден");
        return false;
    }
    $hash = $users[$login]['password'];
    $isValid = password_verify($password, $hash);
    error_log("Проверка пароля: login=$login, hash=$hash, valid=" . ($isValid ? 'Да' : 'Нет'));
    return $isValid;
}

// Текущий пользователь
function getCurrentUser() {
    return $_SESSION['user'] ?? null;
}

// Вход пользователя
function login($login) {
    $users = getUsersList();
    $_SESSION['user'] = [
        'login' => $login,
        'name' => $users[$login]['name'],
        'birthday' => $users[$login]['birthday'],
        'login_time' => time()
    ];
}

// Выход
function logout() {
    session_destroy();
}

// Проверка дня рождения
function checkBirthday($birthday) {
    $today = date('m-d');
    $userDate = date('m-d', strtotime($birthday));
    
    if ($today === $userDate) {
        return 0; // Сегодня ДР
    }
    
    $nextBirthday = date('Y') . '-' . $userDate;
    if (strtotime($nextBirthday) < time()) {
        $nextBirthday = (date('Y') + 1) . '-' . $userDate;
    }
    
    return round((strtotime($nextBirthday) - time()) / 86400);
}