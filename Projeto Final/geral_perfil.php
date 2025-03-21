<?php
include 'geral_header.php';
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $sql = "SELECT * FROM User WHERE ID = '$userId'";
    $result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
    $row = mysqli_fetch_assoc($result);
} else {
    $row = $_SESSION['user'];
}
$mostrarBotaoAtualizar = ($_SESSION['user']['USER_TYPE'] == 'A' && ($row['USER_TYPE'] == 'A' || $row['USER_TYPE'] == 'M')) ||
    ($_SESSION['user']['USER_TYPE'] == 'M' && (($row['ID'] == $_SESSION['user']['ID']) || $row['USER_TYPE'] == 'P')) ||
    ($_SESSION['user']['USER_TYPE'] == 'P' && ($row['ID'] == $_SESSION['user']['ID']));
$idUtilizador = $row['ID'];
$mostrarBotaoDesativar = $_SESSION['user']['USER_TYPE'] == 'A' && $row['USER_STATE']


?>
<br>
<div class="perfil">
    <h2>Dados Pessoais</h2>
    <br>
    <div class="info-container">
        <div class="info">
            <img height="150" src="<?php echo $row['PHOTOGRAPH']; ?>" alt="Fotografia">
        </div>
        <div class="info">
            <p><strong>Nome:</strong> <?php echo $row['NAME']; ?></p>
            <?php if ($row['USER_TYPE'] == 'P'){
              echo '<p><strong>Tipo de Utilizador:</strong> Paciente</p>';
            } else if ($row['USER_TYPE'] == 'M'){
                echo '<p><strong>Tipo de Utilizador:</strong> Médico</p>';
            } else {
                echo '<p><strong>Tipo de Utilizador:</strong> Administrador </p>';
            }
            ?>
            <p><strong>Morada:</strong> <?php echo $row['ADDRESS']; ?></p>
            <p><strong>Contacto:</strong> <?php echo $row['CONTACT']; ?></p>
            <p><strong>Username:</strong> <?php echo $row['USERNAME']; ?></p>
            <?php
            if ($_SESSION['user']['USER_TYPE'] != 'A' &&
                ($row['USER_TYPE'] == 'P' &&
                    ($_SESSION['user']['USER_TYPE'] == 'M' || $row['ID'] == $_SESSION['user']['ID']))) {
                $userId = isset($_GET['userId']) ? $_GET['userId'] : $_SESSION['user']['ID'];
                $sql = "SELECT * FROM Pacient WHERE ID = '$userId'";
                $result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
                $row = mysqli_fetch_assoc($result);
                echo '<p><strong>Email:</strong> ' . $row['EMAIL'] . '</p>';
                echo '<p><strong>Data de Nascimento:</strong> ' . $row['BIRTH_DATE'] . '</p>';
                if($row['GENDER'] == '0'){
                    echo '<p><strong>Género:</strong> ' . 'Feminino' . '</p>';
                } else {
                    echo '<p><strong>Género:</strong> ' . 'Masculino' . '</p>';
                }
                echo '<p><strong>NIF:</strong> ' . $row['NIF'] . '</p>';
                echo '<p><strong>Lista de Alergias:</strong> ' . $row['ALLERGIES_LIST'] . '</p>';
                echo '<p><strong>Histórico Clínico:</strong> ' . $row['CLINICAL_HISTORY'] . '</p>';
                echo '<p><strong>Distrito:</strong> ' . $row['DISTRICT'] . '</p>';
                echo '<p><strong>Cidade:</strong> ' . $row['CITY'] . '</p>';
                $pacienteId = $row['ID'];
                if ($_SESSION['user']['USER_TYPE'] == 'M') {
                    echo '<div class="pensos-perfil">';
                    echo '<hr>';
                    echo '<h4>PENSOS:</h4>';
                    echo '<a href="m_novoPenso.php?pacienteId=' . $pacienteId . '">Criar Novo Penso</a><br><br>';
                    $medicoId = $_SESSION['user']['ID'];
                    $sql = "SELECT ID, DISCHARGE_DATE FROM Penso WHERE DOCTOR_ID = '$medicoId' AND PACIENT_ID = '$pacienteId'";
                    $result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
                    $pensosAtivos = [];
                    $pensosDesativos = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $temAlta = isset($row['DISCHARGE_DATE']) && $row['DISCHARGE_DATE'] != NULL;
                        if ($temAlta) {
                            array_push($pensosDesativos, $row['ID']);
                        } else {
                            array_push($pensosAtivos, $row['ID']);
                        }
                    }
                    echo 'Pensos Ativos: ';
                    echo '<ul>';
                    foreach ($pensosAtivos as $penso) {
                        echo '<li><a href="penso_homePenso.php?pensoId=' . $penso . '&temAlta=0' . '">Penso ' . $penso . '</a></li>';
                    }
                    echo '</ul>';
                    echo 'Pensos Desativos: ';
                    echo '<ul>';
                    foreach ($pensosDesativos as $penso) {
                        echo '<li><a href="penso_homePenso.php?pensoId=' . $penso . '&temAlta=1' . '">Penso ' . $penso . '</a></li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
    <div class="update-button">
        <?php
        if ($mostrarBotaoAtualizar) {
            echo "<a href='geral_atualizarDados.php?userId=" . $idUtilizador . "'>Atualizar</a>";
        }
        if ($mostrarBotaoDesativar) {
            echo "<a class='deactivate-button' href='geral_desativarUtilizador.php?userId=" . $idUtilizador . "'>Desativar</a>";
        }
        ?>
    </div>
</div>
<?php
include 'geral_footer.php';
?>
