<?php
include 'geral_header.php';
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));

include 'a_home_admin_stats.php';

if (isset($_SESSION['user']) && $_SESSION['user']['USER_TYPE'] == 'P') {
    echo '<div class="pensos-paciente">';
    echo '<h2>PENSOS:</h2>';
    $pacienteId = $_SESSION['user']['ID'];
    $sql = "SELECT ID, DISCHARGE_DATE FROM Penso WHERE PACIENT_ID = '$pacienteId'";
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

if (isset($_SESSION['user']) && $_SESSION['user']['USER_TYPE'] == 'M') {
    $medicoId = $_SESSION['user']['ID'];
    $sql = "SELECT DISTINCT User.NAME, Penso.PACIENT_ID, Measurement.PENSO_ID, Penso.DISCHARGE_DATE, Measurement.STATE_SAD  
            FROM Penso
                INNER JOIN Measurement ON Measurement.PENSO_ID = Penso.ID
                INNER JOIN User ON Penso.PACIENT_ID = User.ID 
            WHERE Penso.DOCTOR_ID = '$medicoId' AND Measurement.STATE_DOCTOR IS NULL AND Penso.DISCHARGE_DATE IS NULL ";
    $result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));


        echo '<div class="consult-table"><br>';
        echo "<h2>Alertas - Medições Novas: </h2><br>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Nome Paciente</th>";
        echo "<th>Penso ID</th>";
        echo "<th>Estado SAD</th>";
        echo "</tr>";
    if ($result->num_rows == 0){
        echo "<tr>";
        echo "<td colspan='3' style='text-align: center; '>Sem Medições Novas</td>";
        echo "</tr>";
    }
        while ($row = mysqli_fetch_assoc($result)) {
            $temAlta = isset($row['DISCHARGE_DATE']) && $row['DISCHARGE_DATE'] != NULL;
            echo "<tr>";
            echo "<td><a href='geral_perfil.php?userId=" . $row['PACIENT_ID'] . "'>" . $row['NAME'] . "</a></td>";
            echo "<td><a href='penso_homePenso.php?pensoId=" . $row['PENSO_ID'] . "&temAlta=" . $temAlta . "'>" . $row['PENSO_ID'] . "</a></td>";
            if ( $row['STATE_SAD'] == '1'){
                echo "<td>" . 'Normal' . "</td>";
            } else if ( $row['STATE_SAD'] == '2'){
                echo "<td>" . 'Alerta' . "</td>";
            } else if ( $row['STATE_SAD'] == '3'){
                echo "<td>" . 'Alerta Urgente' . "</td>";
            } else {
                echo "<td>" . $row['STATE_SAD'] . "</td>";
            }
            echo "</tr>";
        }
        echo '</table>';
        echo '</div>';

}


if (isset($_SESSION['user']) && $_SESSION['user']['USER_TYPE'] == 'A'){
    $adminId = $_SESSION['user']['NAME'];
    echo '<div class="home_admin">';
    echo "<h1>Bem vindo ".$adminId."</h1>";

    getStatistics($connect);
}


if (!isset($_SESSION['user']) ) {
    ?>

    <div class="background">
        <h1>Bem-vindo ao PI-SIM</h1>
        <p>Cuidados de saúde de qualidade ao seu alcance.</p>
    </div>

    <div class="main-content">
        <section class="section">
            <h2>Sobre Nós</h2>
            <p>PI-SIM é um penso ativo, capaz de monitorizar feridas pós-operatórias fazendo a medição de parâmetros como condutividade da pele, temperatura, pH, entre outros.</p>
        </section>

        <section id="services" class="section services">
            <h2>Características do PI-SIM</h2>
            <div class="service">
                <h3>Monitorização de Feridas</h3>
                <p>O PI-SIM é capaz de monitorizar feridas pós-operatórias, fornecendo dados importantes para a recuperação.</p>
            </div>
            <div class="service">
                <h3>Medição de Parâmetros</h3>
                <p>Mede condutividade da pele, temperatura, pH, e outros parâmetros essenciais para a saúde da ferida.</p>
            </div>
            <div class="service">
                <h3>Feedback em Tempo Real</h3>
                <p>Oferece feedback em tempo real sobre o estado da ferida, permitindo ajustes imediatos no tratamento.</p>
            </div>
        </section>

        <section id="testimonials" class="section testimonials">
            <h2>O que nossos utilizadores dizem</h2>
            <div class="testimonial">
                <p>"O PI-SIM revolucionou o tratamento da minha ferida pós-operatória, fornecendo dados precisos e úteis."</p>
                <footer>- João Silva</footer>
            </div>
            <div class="testimonial">
                <p>"Com o PI-SIM, senti-me mais seguro sabendo que a recuperação da minha ferida estava em monitorização constante."</p>
                <footer>- Maria Oliveira</footer>
            </div>
            <div class="testimonial">
                <p>"Recomendo o PI-SIM a todos que precisam de um acompanhamento cuidadoso e detalhado das suas feridas."</p>
                <footer>- Pedro Santos</footer>
            </div>
        </section>

        <div class="cta">
            <a href="geral_contacts.php">Entre em Contato</a>
        </div>
    </div>

    <?php
}

include 'geral_footer.php';
?>