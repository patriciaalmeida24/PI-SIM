<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
$userId = $_GET['userId'];
$sql = "UPDATE User SET USER_STATE = '0' WHERE ID = '$userId'";
$resultUser = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));


if ($resultUser) {
    echo "<script type='text/javascript'>alert('Utilizador desativado com sucesso'); window.location.href='geral_perfil.php?userId=" . $userId ."';</script>";
} else {
    echo "<script type='text/javascript'>alert('Erro');</script>";
}
?>
