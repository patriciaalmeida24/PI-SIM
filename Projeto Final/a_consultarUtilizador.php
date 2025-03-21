<?php
include 'geral_header.php';
?>

<?php
$connect = mysqli_connect('localhost', 'root', '', 'PI-SIM')
or die('Error connecting to the server: ' . mysqli_error($connect));
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $sql = "SELECT * FROM User WHERE USER_TYPE = '$tipo'";
} else {
    $sql = "SELECT * FROM User";
}
$result = mysqli_query($connect, $sql) or die('The query failed: ' . mysqli_error($connect));
?>

    <div class="consult-table">
        <h2>Consultar <?php echo $_SESSION['user']['USER_TYPE'] == 'M' ? "Pacientes" : "Utilizadores" ?></h2>
        <br>
        <div class="search-container">
            <script>
                function myFunction() {
                    // Declare variables
                    const input = document.getElementById("myInput");
                    const filter = input.value.toUpperCase();
                    const table = document.getElementById("myTable");
                    const trs = Array.from(table.getElementsByTagName("tr"));

                    trs.forEach((tr,  index) => {
                        if (index > 0) { // salta a primeira linha (header))
                            let filterOut = true;
                            const tds = Array.from(tr.getElementsByTagName("td"));
                            tds.forEach((td) => {
                                if (td) {
                                    txtValue = td.textContent || td.innerText;
                                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                        filterOut = false;
                                    }
                                }
                            });
                            if (filterOut) {
                                tr.style.display = "none";
                            } else {
                                tr.style.display = "";
                            }
                        }
                    })
                }
            </script>
            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Pesquisar...">

        </div>
        <br><br>
        <table id="myTable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
<?php if ($_SESSION['user']['USER_TYPE'] == 'A') echo '<th>Tipo</th>' ?>
                <th>Data de Criação</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td><a href='geral_perfil.php?userId=" . $row['ID'] . "'>" . $row['ID'] . "</a></td>";
                echo "<td>" . $row['NAME'] . "</td>";
                if ($_SESSION['user']['USER_TYPE'] == 'A') echo "<td>" . $row['USER_TYPE'] . "</td>";
                echo "<td>" . $row['CREATION_DATE'] . "</td>";
                echo "</tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
<?php include 'geral_footer.php';
?>