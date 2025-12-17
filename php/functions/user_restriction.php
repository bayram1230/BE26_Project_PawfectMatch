<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* Login nötig (user, admin, shelter) */
function requireLogin() {
    if (!isset($_SESSION['role'])) {
        echo "
        <script>
            alert('You must be logged in to access this page.');
            window.location.href = '/php/login/login.php';
        </script>";
        exit;
    }
}

/* Nur Admin */
function requireAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        echo "
        <script>
            alert('Admin access only.');
            window.history.back();
        </script>";
        exit;
    }
}

/* Nur Shelter */
function requireShelter() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'shelter') {
        echo "
        <script>
            alert('Shelter access only.');
            window.history.back();
        </script>";
        exit;
    }
}

/* Nur User */
function requireUser() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
        echo "
        <script>
            alert('User access only.');
            window.history.back();
        </script>";
        exit;
    }
}
