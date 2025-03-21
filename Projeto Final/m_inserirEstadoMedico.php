<?php
$pensoId = $_GET['pensoId'];
$temAlta = $_GET['temAlta'];
if (isset($_POST['estadoMedico'])) {
    $estadoMedico = $_POST['estadoMedico'];
    $medicaoId = $_GET['medicaoId'];

    $connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
    or die('Error connecting to the server: ' . mysqli_error($connect));
    $sql = "UPDATE Measurement SET STATE_DOCTOR = '$estadoMedico'
        WHERE ID = '$medicaoId'";
    $resultPaciente = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
}
?>
<script type='text/javascript'>
    alert('Novo estado adicionado com sucesso');
    window.location.href = "penso_homePenso.php?pensoId=<?php echo $pensoId?>&temAlta=<?php echo $temAlta?>"
</script>

