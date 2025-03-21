<?php
include 'geral_header.php';
$pensoId = $_GET['pensoId'];
?>

    <div class="form-container">
<h2>Nova Leitura</h2> <br>
<h3>Inserir Dados:</h3>
<form method='post' action='p_criarLeitura.php?pensoId=<?php echo $pensoId ?>'>
    <table class="form-table">
        <tr>
            <td><label>Condutividade da pele:</label></td>
            <td><input type='number' name='condutividade' required></td>
        </tr>
        <tr>
            <td><label>pH:</label></td>
            <td><input type='number' name='ph' required></td>
        </tr>
        <tr>
            <td><label>Temperatura:</label></td>
            <td><input type='number' name='temperatura' required></td>
        </tr>
        <tr>
            <td><label>Odor:</label></td>
            <td>
                <select name='odor'>
                    <option value='1'>Alterado</option>
                    <option value='0'>Normal</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><label>Visual:</label></td>
            <td>
                <select name='visual'>
                    <option value='1'>Alterado</option>
                    <option value='0'>Normal</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input type="submit" name="submit" value="Inserir">
            </td>
        </tr>
    </table>
</form>

</div>
<?php include 'geral_footer.php';
?>