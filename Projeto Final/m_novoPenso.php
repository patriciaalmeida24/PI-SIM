<?php
include 'geral_header.php';
$pacienteId = $_GET['pacienteId'];
?>
<div class="form-container">
    <h2>Novo Penso</h2>
    <form method='post' action='m_criarPenso.php?pacienteId=<?php echo $pacienteId ?>'>
        <label class="search-container">
                Observações:
                <input type='text' name='observacoes' required>
        </label>
        <input type='submit' name='submit' value='Submeter'>
        <br>
        <br>
        <br>
    </form>
</div>


<?php include 'geral_footer.php';
?>

