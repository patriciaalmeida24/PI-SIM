<?php include 'geral_header.php';
?>

<div class='contents'>
    <?php
    if (isset($_SESSION['loginIncorreto']) && $_SESSION['loginIncorreto']) {
        echo "<script type='text/javascript'>alert('Login Incorreto');</script>";
    }
    ?>
    <br>
    <div class="form-container login">
        <form method='post' action='geral_checkLogin.php'>
            <table class="form-table">
                <tr>
                    <td><label>Utilizador:</label></td>
                    <td><input type='text' name='user'></td>
                </tr>
                <tr>
                    <td><label>Password:</label></td>
                    <td><input type='password' name='pass'></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" name="submit" value="Submeter">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include 'geral_footer.php';
?>
