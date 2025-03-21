<?php
include 'geral_header.php';
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));

$pensoId = $_GET['pensoId'];
$temAlta = isset($_GET['temAlta']) && $_GET['temAlta'];
echo '<div class=title>';
echo '<h2>Penso ' . $pensoId . '</h2>';
echo'</div>';

$eMedico = $_SESSION['user']['USER_TYPE'] == 'M';
$ePaciente = $_SESSION['user']['USER_TYPE'] == 'P';

if ($_SESSION['user']['USER_TYPE'] != 'A') {
    $sql = "SELECT * FROM Measurement WHERE PENSO_ID = '$pensoId' ORDER BY Measurement.DATE";
    $result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
    $novasMedicoes = [];
    $historicoMedicoes = [];

    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['STATE_DOCTOR'] == NULL) {
            array_push($novasMedicoes, $row);
        } else {
            array_push($historicoMedicoes, $row);
        }
    }
}

$sql_penso = "SELECT * FROM Penso WHERE ID = '$pensoId'";
$result_penso = mysqli_query($connect, $sql_penso) or die('The query failed: ' . mysqli_error($connect));

$row_penso = mysqli_fetch_assoc($result_penso);

echo '<div class="subtitle">';
echo '<strong>Observações: </strong>';
echo $row_penso['OBSERVATIONS'] . "</div><br>";

echo '<div class=button>';
echo $ePaciente && !$temAlta ? '<a href="p_novaLeitura.php?pensoId=' . $pensoId . '">Criar Nova Leitura</a>' : '';
echo '</div><br>';

if (count($novasMedicoes) != 0) {
?>
    <div class="consult-table">
    <h3>Medições Novas:</h3>
    <table>
        <tr>
            <th>Condutividade da Pele</th>
            <th>pH</th>
            <th>Temperatura</th>
            <th>Odor</th>
            <th>Visual</th>
            <th>Estado SAD</th>
            <th>Data de Criação</th>
            <?php
            echo $eMedico ? '<th>Estado Médico</th><th></th>' : '';
            echo "</tr>";

            foreach ($novasMedicoes as $medicao) {
                echo "<tr>";
                echo "<td>" . $medicao['SKIN_CONDUCTIVITY'] . "</td>";
                echo "<td>" . $medicao['PH'] . "</td>";
                echo "<td>" . $medicao['TEMPERATURE'] . "</td>";
                echo "<td>" . ($medicao['ODOR'] == 0 ? 'Normal' : 'Alterado'). "</td>";
                echo "<td>" . ($medicao['VISUAL'] == 0 ? 'Normal' : 'Alterado') . "</td>";
                if ( $medicao['STATE_SAD'] == '1'){
                    echo "<td>" . 'Normal' . "</td>";
                } else if ( $medicao['STATE_SAD'] == '2'){
                    echo "<td>" . 'Alerta' . "</td>";
                } else if ( $medicao['STATE_SAD'] == '3'){
                    echo "<td>" . 'Alerta Urgente' . "</td>";
                } else {
                    echo "<td>" . $medicao['STATE_SAD'] . "</td>";
                }
                echo "<td>" . $medicao['DATE'] . "</td>";
                echo $eMedico ?
                    "<form method='post' action='m_inserirEstadoMedico.php?medicaoId=" . $medicao['ID'] . "&pensoId=" . $pensoId . "&temAlta=" . $temAlta . "'>
                <td>
                    <select name='estadoMedico'>
                        <option disabled selected value></option>
                        <option value='U'>Alerta Urgente</option>
                        <option value='A'>Alerta</option>
                        <option value='N'>Normal</option>
                    </select>
                </td>
                <td><input type='submit' name='submit' value='Submeter' class='submit-button'></td>
            </form>" : '';
                echo "</tr>";
            }
            echo "</table>";
            }
            ?>

            <div class="consult-table">
            <h3>Histórico de Medições:</h3>
            <table>
                <tr>
                    <th>Condutividade da Pele</th>
                    <th>pH</th>
                    <th>Temperatura</th>
                    <th>Odor</th>
                    <th>Visual</th>
                    <th>Estado SAD</th>
                    <th>Estado Médico</th>
                    <th>Data de Criação</th>
                </tr>
                <?php
                foreach ($historicoMedicoes as $medicao) {
                    echo "<tr>";
                    echo "<td>" . $medicao['SKIN_CONDUCTIVITY'] . "</td>";
                    echo "<td>" . $medicao['PH'] . "</td>";
                    echo "<td>" . $medicao['TEMPERATURE'] . "</td>";
                    echo "<td>" . ($medicao['ODOR'] == 0 ? 'Normal' : 'Alterado') . "</td>";
                    echo "<td>" . ($medicao['VISUAL'] == 0 ? 'Normal' : 'Alterado') . "</td>";
                    if ( $medicao['STATE_SAD'] == '1'){
                        echo "<td>" . 'Normal' . "</td>";
                    } else if ( $medicao['STATE_SAD'] == '2'){
                        echo "<td>" . 'Alerta' . "</td>";
                    } else if ( $medicao['STATE_SAD'] == '3'){
                        echo "<td>" . 'Alerta Urgente' . "</td>";
                    } else {
                        echo "<td>" . $medicao['STATE_SAD'] . "</td>";
                    }
                    if ( $medicao['STATE_DOCTOR'] == 'N'){
                        echo "<td>" . 'Normal' . "</td>";
                    } else if ( $medicao['STATE_DOCTOR'] == 'A'){
                        echo "<td>" . 'Alerta' . "</td>";
                    } else if ( $medicao['STATE_DOCTOR'] == 'U'){
                        echo "<td>" . 'Alerta Urgente' . "</td>";
                    }
                    echo "<td>" . $medicao['DATE'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            </div>
            <br>
            <br>
            <div class="update-button">
                <?php
                if ($_SESSION['user']['USER_TYPE'] == 'M' && !$temAlta) {
                    echo '<a href="m_darAlta.php?pensoId=' . $pensoId . '">ALTA</a>';
                }
                ?>
            </div>
        </div>
            <?php
include 'geral_footer.php';
?>



