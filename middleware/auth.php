<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: /jprpro_jwp/admin/login.php');
        exit();
    }
}

function logout() {
    session_destroy();
    header('Location: /jprpro_jwp/admin/login.php');
    exit();
}