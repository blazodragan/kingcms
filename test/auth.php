<?php
require 'config.php';

function isAuthenticated($token) {
    global $pdo;

    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    return $user ? true : false;
}
?>