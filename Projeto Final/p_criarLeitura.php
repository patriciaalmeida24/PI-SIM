<?php
session_start();
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));

include 'sad.php';

$condutividade = $_POST['condutividade'];
$pH = $_POST['ph'];
$temperatura = $_POST['temperatura'];
$odor = $_POST['odor'];
$visual = $_POST['visual'];
$pensoId = $_GET['pensoId'];

// Consulta SQL para obter gênero e data de nascimento do paciente associado ao penso
$sql_paciente_info = "SELECT Pacient.GENDER, Pacient.BIRTH_DATE
                      FROM Penso
                      INNER JOIN Pacient ON Penso.PACIENT_ID = Pacient.ID
                      WHERE Penso.ID = '$pensoId'";

$result_paciente_info = mysqli_query($connect, $sql_paciente_info);
if (!$result_paciente_info) {
    die('Erro ao buscar informações do paciente: ' . mysqli_error($connect));
}

$row = mysqli_fetch_assoc($result_paciente_info);
$genero = $row['GENDER'];
$dataNascimento = $row['BIRTH_DATE'];
$dataNascimentoObj = new DateTime($dataNascimento);
$dataAtualObj = new DateTime(); // Data atual
$intervalo = $dataNascimentoObj->diff($dataAtualObj);
$idade = $intervalo->y; // Obtém a idade em anos

$state_sad = determine_state_SAD($idade, $genero, $pH, $temperatura, $condutividade, $odor, $visual);

$sql = "INSERT INTO Measurement (SKIN_CONDUCTIVITY, PH, TEMPERATURE, ODOR, VISUAL, STATE_SAD, PENSO_ID) 
        VALUES ('$condutividade', '$pH', '$temperatura','$odor', '$visual', '$state_sad', '$pensoId')";
$result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));

if ($result) {
    ?>
    <script type='text/javascript'>
        alert('Nova leitura adicionada com sucesso');
        window.location.href = "penso_homePenso.php?pensoId=<?php echo $pensoId?>"
    </script>
    <?php
} else {
    echo "<script type='text/javascript'>alert('Erro');</script>";
}
?>
