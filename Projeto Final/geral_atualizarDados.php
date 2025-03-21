<?php
include 'geral_header.php';
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
$userId = $_GET['userId'];
$sql = "SELECT * FROM User WHERE ID = '$userId'";
$result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
$row = mysqli_fetch_assoc($result);
?>
    <div class="form-container">
        <h2>Atualizar Dados: </h2>
        <form method='post' action='geral_atualizarUtilizador.php?userId=<?php echo $userId ?>'
              enctype="multipart/form-data">
            <table class="form-table">
                <tr>
                    <td><label>Nome:</label></td>
                    <td><input type='text' name='nome' value="<?php echo $row['NAME'] ?>" required></td>
                </tr>
                <tr>
                    <td><label>Morada:</label></td>
                    <td><input type='text' name='morada' value="<?php echo $row['ADDRESS'] ?>" required></td>
                </tr>
                <tr>
                    <td><label>Contacto:</label></td>
                    <td><input type='text' name='contacto' value="<?php echo $row['CONTACT'] ?>" required></td>
                </tr>
                <tr>
                    <td><label>Username:</label></td>
                    <td><input type='text' name='username' value="<?php echo $row['USERNAME'] ?>" required></td>
                </tr>
                <tr>
                    <td><label>Password:</label></td>
                    <td><input type='text' name='password'></td>
                </tr>
                <tr>
                    <td><label>Fotografia:</label></td>
                    <td><input type='file' name='fotografia'></td>
                </tr>


                <?php
                if ($row['USER_TYPE'] == 'P') {
                $sql = "SELECT * FROM Pacient WHERE ID = '$userId'";
                $result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
                $row = mysqli_fetch_assoc($result);
                ?>

                <tr>
                    <td><label>Email:</label></td>
                    <td><input type='text' name='email' value="<?php echo $row['EMAIL'] ?>" required></td>
                </tr>
                <tr>
                    <td><label>Data de Nascimento:</label></td>
                    <td><input type='date' name='data_nascimento' value="<?php echo $row['BIRTH_DATE'] ?>" required>
                    </td>
                </tr>
                <tr>
                    <td><label>Lista de Alergias:</label></td>
                    <td><input type='text' name='alergias' value="<?php echo $row['ALLERGIES_LIST'] ?>" required></td>
                </tr>
                <tr>
                    <td><label>Histórico Clínico:</label></td>
                    <td><input type='text' name='historico_clinico' value="<?php echo $row['CLINICAL_HISTORY'] ?>"
                               required></td>
                </tr>
                <tr>
                    <td><label>Distrito:</label></td>
                    <td><input type='text' name='distrito' value="<?php echo $row['DISTRICT'] ?>" required></td>
                </tr>
                <tr>
                    <td><label>Cidade:</label></td>
                    <td><input type='text' name='cidade' value="<?php echo $row['CITY'] ?>" required></td>
                </tr>

            <?php
            }
            ?>
            </table>

            <input type='submit' name='submit' value='Atualizar'>
        </form>
    </div>

<?php include 'geral_footer.php';
?>