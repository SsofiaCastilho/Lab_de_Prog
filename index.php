<?php
session_start();

if (isset($_SESSION['token'])) {
    header("Location: home.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
 /*página de redirecionamento inicial - para home.php se o token
 existir e para login.php se não existir*\