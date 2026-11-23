<?php session_start();$r=$_SESSION['u']['role']??'';header('Location: '.($r?"$r/dashboard.php":'login.php'));
