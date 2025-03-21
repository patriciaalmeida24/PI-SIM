<?php
session_start()
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>PI-SIM - Penso inteligente para monitorização de pacientes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel='stylesheet' href='styles.css'>
</head>

<body>
    <div class="header">
        <button class="toggle-menu">&#9776;</button> <!-- Botão para ativar o menu -->
        <h1>PI-SIM</h1>
        <img src="fotografias/icon3.png" alt="Descrição da Imagem">
    </div>
    <div class="menu-container" id="menu">
        <ul class='menu'>
            <li><a class='menuItem' href='geral_home.php'>Home</a></li>
            <?php if (isset($_SESSION['authUser']) && $_SESSION['authUser']) { ?>
                <li><a class='menuItem' href='geral_perfil.php'> Perfil </a></li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['USER_TYPE'] == 'A') { ?>
                    <li><a class='menuItem' href='geral_novoUtilizador.php'> Novo Utilizador </a></li>
                    <li><a href='a_consultarUtilizador.php'>Consultar Utilizadores</a></li>
                <?php } elseif (isset($_SESSION['user']) && $_SESSION['user']['USER_TYPE'] == 'M') { ?>
                    <li><a class='menuItem' href='geral_novoUtilizador.php'> Novo Paciente </a></li>
                    <li><a href='a_consultarUtilizador.php?tipo=P'>Consultar Pacientes</a></li>
                <?php } ?>
                <li><a class='menuItem' href='geral_logout.php'> Logout </a></li>
            <?php } else { ?>
                <li><a class='menuItem' href='geral_sobreNos.php'>Sobre nós</a></li>
                <li><a class='menuItem' href='geral_contacts.php'>Contactos</a></li>
                <li><a class='menuItem' href='geral_login.php'>Login</a></li>
            <?php } ?>
        </ul>
    </div>

    <script>
        document.querySelector('.toggle-menu').addEventListener('click', function() {
            var menu = document.getElementById('menu');
            menu.classList.toggle('active'); // Alterna a classe "active" do menu
            var menuWidth = menu.offsetWidth;
            var button = document.querySelector('.toggle-menu');
            if (menu.classList.contains('active')) {
                button.style.left = menuWidth + 'px'; // Movimenta o botão para a direita, a largura do menu
            } else {
                button.style.left = 0; // Restaura a posição original do botão quando o menu é fechado
            }
        });
    </script>
</body>