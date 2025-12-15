<?php
session_start();

/* ---------------------------------
   Require login (User oder Admin)
---------------------------------- */
function requireLogin()
{
    if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
        echo "
            <script>
                alert('You must be logged in to access this page.');
                window.location.href = '/index.php';
            </script>
        ";
        exit;
    }
}

/* ---------------------------------
   Require admin only
---------------------------------- */
function requireAdmin()
{
    if (!isset($_SESSION['admin'])) {
        echo "
            <script>
                alert('You do not have permission to perform this action.');
                window.history.back();
            </script>
        ";
        exit;
    }
}
