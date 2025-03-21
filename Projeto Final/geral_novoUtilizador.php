<?php
include 'geral_header.php'
?>
<div class="form-container">
    <h2><?php echo $_SESSION['user']['USER_TYPE'] == 'A' ? "Novo Utilizador" : "Novo Paciente" ?></h2>
    <form method='post' action='geral_criarUtilizador.php' enctype="multipart/form-data">
        <table class="form-table">
            <?php if ($_SESSION['user']['USER_TYPE'] == 'A') { ?>
                    <tr>
                        <td><label>Tipo:</label></td>
                        <td>
                            <select name='tipo'>
                                <option value='A'>Administrador</option>
                                <option value='M'>Médico</option>
                            </select>
                        </td>
                    </tr>
            <?php } ?>
            <tr>
                <td><label>Nome:</label></td>
                <td><input type='text' name='nome' required></td>
            </tr>
            <tr>
                <td><label>Morada:</label></td>
                <td><input type='text' name='morada' required></td>
            </tr>
            <tr>
                <td><label>Contacto:</label></td>
                <td><input type='text' name='contacto' required></td>
            </tr>
            <tr>
                <td><label>Username:</label></td>
                <td><input type='text' name='username' required></td>
            </tr>
            <tr>
                <td><label>Password:</label></td>
                <td><input type='text' name='password' required></td>
            </tr>
            <tr>
                <td><label>Fotografia:</label></td>
                <td><input type='file' name='fotografia' required></td>
            </tr>


        <?php if ($_SESSION['user']['USER_TYPE'] != 'A') { ?>
            <tr>
                <td><label>Email:</label></td>
                <td><input type='text' name='email' required></td>
            </tr>
            <tr>
                <td><label>Data de Nascimento:</label></td>
                <td><input type='date' name='data_nascimento' required></td>
            </tr>
            <tr>
                <td><label>Género:</label></td>
                <td>
                    <select name='genero'>
                        <option disabled selected value></option>
                        <option value='1'>Masculino</option>
                        <option value='0'>Feminino</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label>NIF:</label></td>
                <td><input type='number' name='nif' required></td>
            </tr>
            <tr>
                <td><label>Lista de Alergias:</label></td>
                <td><input type='text' name='alergias' required></td>
            </tr>
            <tr>
                <td><label>Histórico Clínico:</label></td>
                <td><input type='text' name='historico_clinico' required></td>
            </tr>
            <tr>
                <td><label>Distrito:</label></td>
                <td><input type='text' name='distrito' required></td>
            </tr>
            <tr>
                <td><label>Cidade:</label></td>
                <td><input type='text' name='cidade' required></td>
            </tr>
            <?php
        }
        ?>

            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" name="submit" value="Submeter">
                </td>
            </tr>
        </table>
    </form>
    
</div>

<?php include 'geral_footer.php';
?>