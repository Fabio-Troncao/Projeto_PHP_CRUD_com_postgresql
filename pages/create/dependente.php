<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';
//ok
use ConexaoPHPPostgres\DependentModel as DependentModel;

$id = 0;
$dependent_name = null;
$sex = null;
$bdate = null;
$relationship = null;

if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ecpf =  $_REQUEST['id'];
    $dependent_name =  $_REQUEST['dependent_name'];
    $sex =  $_REQUEST['sex'];
    $bdate =  $_REQUEST['bdate'];
    $relationship =  $_REQUEST['relationship'];
    try {
        $dependentModel = new DependentModel($pdo);
        $dependentModel->insert($_REQUEST['id'], $_REQUEST['dependent_name'], $_REQUEST['sex'], $_REQUEST['bdate'], $_REQUEST['relationship']);
        header("Location: ../../pages/funcionarios.php");
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

?>
<?php
include('../../templates/header.php');
?>

<div class="container">

    <div class="row py-5">
        <div class="col"><a href="../../pages/funcionarios.php"><img src="../../assets/images/backbutton.png" height="30px"></a></div>
        <div class="col">
            <h4>Cadastrar novo dependente</h4>
        </div>
        <div class="col"></div>
    </div>

    <form action="dependente.php?id=<?php echo $id ?>" method="post">
        <!-- Alerta em caso de erro -->
        <?php if (!empty($error)) : ?>
            <span class="text-danger"><?php echo $error; ?></span>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo $id; ?>" />

        <div class="form-group">
            <label for="dependent_name">Nome:</label>
            <input class="form-control" value="<?php echo !empty($dependent_name) ? $dependent_name : ''; ?>" type="text" name="dependent_name" id="dependent_name" required>
        </div>

        <div class="form-group">
            <label for="Sex">Sexo:</label>
            <br>
            <input type="radio" id="male" name="sex" value="M" <?php echo $sex === 'M' ? "checked" : '' ?> required>
            <label for="male">Masculino</label><br>
            <input type="radio" id="female" name="sex" value="F" <?php echo $sex === 'F' ? "checked" : '' ?>>
            <label for="female">Feminino</label><br>
            <input type="radio" id="other" name="sex" value="O" <?php echo $sex == 'O' ? "checked" : '' ?>>
            <label for="other">Outro</label>
        </div>


        <div class="form-group">
            <label for="Data">Data Nascimento:</label>
            <input class="form-control" type="date" value="<?php echo !empty($bdate) ? $bdate : ''; ?>" name="bdate" id="datanascimento" required>
        </div>

        <div class="form-group">
            <label for="Nome">Relação (Parentesco):</label>
            <input class="form-control" value="<?php echo !empty($relationship) ? $relationship : ''; ?>" type="text" name="relationship" id="relationship" required>
        </div>

        <input class="btn btn-primary" type="submit" value="Cadastrar">

    </form>
</div>

<?php
include('../../templates/footer.php');
?>