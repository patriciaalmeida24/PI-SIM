<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
$userId = $_GET['userId'];
$tipo = $_SESSION['user']['USER_TYPE'] == 'M' ? 'P' : $_POST['tipo'];
$nome = $_POST['nome'];
$morada = $_POST['morada'];
$contacto = $_POST['contacto'];
$username = $_POST['username'];
$password = $_POST['password'];
$nomeFotografia = basename($_FILES["fotografia"]["name"]);
$sql = "UPDATE User SET NAME = '$nome', ADDRESS = '$morada', CONTACT = '$contacto', USERNAME = '$username' WHERE ID = '$userId'";
$resultUser = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));

if ($nomeFotografia){
    $localizacaoFotografia = "fotografias/" . $nomeFotografia;
    move_uploaded_file($_FILES["fotografia"]["tmp_name"], $localizacaoFotografia);
    $sql = "UPDATE USER SET PHOTOGRAPH = '$localizacaoFotografia' WHERE ID = '$userId'";
    $resultUser = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
}

if ($password){
    $sql = "UPDATE USER SET PASSWORD = '" . hash('sha256', $password) . "' WHERE ID = '$userId'";
    $resultUser = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
}

if ($_SESSION['user']['USER_TYPE'] != 'A') {
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $nif = $_POST['nif'];
    $alergias = $_POST['alergias'];
    $historico_clinico = $_POST['historico_clinico'];
    $distrito = $_POST['distrito'];
    $cidade = $_POST['cidade'];
    $sql = "UPDATE Pacient 
            SET EMAIL = '$email', BIRTH_DATE = '$data_nascimento', ALLERGIES_LIST = '$alergias', CLINICAL_HISTORY = '$historico_clinico', DISTRICT = '$distrito', CITY = '$cidade'
            WHERE ID = '$userId'";
    $resultPaciente = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
}

if ($resultUser && (!isset($resultPaciente) || $resultPaciente)) {
        echo "<script type='text/javascript'>alert('Dados atualizados com sucesso'); window.location.href='geral_perfil.php?userId=" . $userId ."';</script>";
} else {
    echo "<script type='text/javascript'>alert('Erro');</script>";
}
?>
