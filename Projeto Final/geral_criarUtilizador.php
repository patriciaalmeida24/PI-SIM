<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
$tipo = $_SESSION['user']['USER_TYPE'] == 'M' ? 'P' : $_POST['tipo'];
$nome = $_POST['nome'];
$morada = $_POST['morada'];
$contacto = $_POST['contacto'];
$username = $_POST['username'];
$password = $_POST['password'];
$nomeFotografia = basename($_FILES["fotografia"]["name"]);
$localizacaoFotografia = "fotografias/" . $nomeFotografia;
move_uploaded_file($_FILES["fotografia"]["tmp_name"], $localizacaoFotografia);
$sql = "INSERT INTO User (NAME, ADDRESS, CONTACT, USERNAME, PASSWORD, CREATION_DATE, PHOTOGRAPH, USER_TYPE) 
        VALUES ('$nome', '$morada', '$contacto', '$username', '" . hash('sha256', $password) . "', CURRENT_TIMESTAMP, '$localizacaoFotografia', '$tipo')";
$resultUser = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));

if ($_SESSION['user']['USER_TYPE'] == 'M') {
    $sql = "SELECT ID from User WHERE USERNAME = '$username'";
    $resultId = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
    $id = mysqli_fetch_assoc($resultId)['ID'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $genero = $_POST['genero'];
    $nif = $_POST['nif'];
    $alergias = $_POST['alergias'];
    $historico_clinico = $_POST['historico_clinico'];
    $distrito = $_POST['distrito'];
    $cidade = $_POST['cidade'];
    $sql = "INSERT INTO Pacient (ID, EMAIL, BIRTH_DATE, GENDER, NIF, ALLERGIES_LIST, CLINICAL_HISTORY, DISTRICT, CITY)
        VALUES ('$id', '$email', '$data_nascimento', '$genero', '$nif', '$alergias', '$historico_clinico', '$distrito', '$cidade' )";
    $resultPaciente = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
}

if ($resultUser && (!isset($resultPaciente) || $resultPaciente)) {
    if (isset($resultPaciente)) {
        echo "<script type='text/javascript'>alert('Novo paciente adicionado com sucesso'); window.location.href='geral_home.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Novo utilizador adicionado com sucesso'); window.location.href='geral_home.php';</script>";
    }
} else {
    echo "<script type='text/javascript'>alert('Erro');</script>";
}
?>
