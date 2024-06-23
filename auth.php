<?php
session_start();

function isAuthenticated() {
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

function authenticate($username, $password) {
    if ($username === $_ENV['ADMIN_USERNAME'] && password_verify($password, $_ENV['ADMIN_PASSWORD'])) {
        $_SESSION['logged_in'] = true;
        return true;
    }
    return false;
}

function logout() {
    session_destroy();
}
?>
