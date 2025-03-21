<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
$user = $_POST['user'];
$sql = "SELECT * FROM User WHERE USERNAME='$user' AND PASSWORD = '" . hash('sha256', $_POST['pass']) . "'";
$result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
$result_row = mysqli_fetch_assoc($result);

if ($result_row !== NULL && $result_row['USER_STATE']) {
    $_SESSION['authUser'] = true;
    $_SESSION['user'] = $result_row;
    header('Location: geral_home.php');
} else {
    $_SESSION['authUser'] = false;
    $_SESSION['loginIncorreto'] = true;
    header('Location: geral_login.php');
}

?>