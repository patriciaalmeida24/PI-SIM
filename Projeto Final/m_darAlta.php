<?php
$pensoId = $_GET['pensoId'];

$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
$sql = "UPDATE Penso SET DISCHARGE_DATE = CURRENT_TIMESTAMP
    WHERE ID = '$pensoId'";
$resultPaciente = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
?>
<script type='text/javascript'>
    alert('Penso desativado com sucesso');
    window.location.href = "penso_homePenso.php?pensoId=<?php echo $pensoId?>&temAlta=1"
</script>

