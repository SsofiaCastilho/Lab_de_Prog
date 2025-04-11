<?php
session_start();

if (isset($_SESSION['token'])) {
    header("Location: home.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
