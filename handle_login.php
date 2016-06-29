<!-- HANDLES LOGIN IN EACH PAGE -->
<?php
require 'models/login.php';
require 'models/media.php';
require 'db/credentials.php';
require 'search.php';

$connection = new mysqli($MYSQL_CREDENTIALS["host"], $MYSQL_CREDENTIALS["username"], $MYSQL_CREDENTIALS["password"], $MYSQL_CREDENTIALS["database"]);
$login = Login::current($connection);

function get_target() {
    if (isset($_POST['redirect_target']) && $_POST['redirect_target'] != "") {
        return $_POST['redirect_target'];
    }
    if (isset($_SERVER['HTTP_REFERER'])) {
        return $_SERVER['HTTP_REFERER'];
    }
    return "";
}

function redirect() {
    $target = get_target();
    if ($target == "") {
        $target = '.';
    }
    // NOTE: this must happen before any HTML or echo output to redirect
    header("Location: " . $target); /* Redirect browser */
    exit();
}

if ($login == null) {
    if (isset($_POST['submit']) && $_POST['submit'] == 'login') {
        $username = $_POST["user_username"];
        $password = $_POST["user_password"];
        $login = Login::authenticate($connection, $username, $password);

        if ($login == null) {
            header("Location: login_required.php?failed=1&redirect=" . urlencode(get_target()));
        } else {
            redirect();
        }
    }
} else {
    $login->logout();
    header("Location: index.php");
    exit();
}
?>
