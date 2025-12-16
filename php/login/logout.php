<?php
session_start();

// Alle Session-Daten löschen
$_SESSION = [];

// Session-Cookie löschen (sauber)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Session zerstören
session_destroy();

// Zur Login-Seite
header("Location: login.php");
exit;
