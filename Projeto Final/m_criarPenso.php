<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
$medicoId = $_SESSION['user']['ID'];
$pacienteId = $_GET['pacienteId'];
$observacoes = $_POST['observacoes'];

$sql = "INSERT INTO Penso (DOCTOR_ID, PACIENT_ID, OBSERVATIONS) 
        VALUES ('$medicoId', '$pacienteId', '$observacoes')";
$result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));

?>

<script type='text/javascript'>
    alert('Novo penso adicionado com sucesso');
    window.location.href = "geral_perfil.php?userId=<?php echo $pacienteId?>"
</script>
