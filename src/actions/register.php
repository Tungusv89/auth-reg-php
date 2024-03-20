<?php

require_once __DIR__ . '/../helpers.php';

$avatarPath = null;
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$passwordConfirmation = $_POST['password_confirmation'] ?? null;
$avatar = $_FILES['avatar'] ?? null;

if (empty($name)) {
    setValidationError('name', 'Неверное имя');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    setValidationError('email', 'Неправильная почта');
}

if (empty($password)) {
    setValidationError('password', 'Пустой пароль');
}

if ($password !== $passwordConfirmation) {
    setValidationError('password', 'Пароли не совпадают');
}

if (!empty($avatar)) {
    $types = ['image/jpeg', 'image/png'];

    if (!in_array($avatar['type'], $types)) {
        setValidationError('avatar', 'Изображение профиля имеет неверный формат');
    }

    if (($avatar['size'] / 1000000) >= 1) {
        setValidationError('avatar', 'Изображение должно быть меньше 1 мб');
    }
}

if (!empty($_SESSION['validation'])) {
    setOldValue('name', $name);
    setOldValue('email', $email);
    redirect('/register.php');
}

if (!empty($avatar)) {
    $avatarPath = uploadFile($avatar, 'avatar');
}

$pdo = getPDO();

$query = "INSERT INTO users(name, email, avatar, password) VALUES (:name, :email, :avatar, :password)";
$params = [
    'name' => $name,
    'email' => $email,
    'avatar' => $avatarPath,
    'password' => password_hash($password, PASSWORD_DEFAULT)
];

$stmt = $pdo->prepare($query);

try {
    $stmt->execute($params);
} catch (Exception $e) {
    die("Connection error: {$e->getMessage()}");
}

redirect('/');
