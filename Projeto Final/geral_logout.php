<?php
session_start();
session_unset();
header('Location: geral_home.php');
?>