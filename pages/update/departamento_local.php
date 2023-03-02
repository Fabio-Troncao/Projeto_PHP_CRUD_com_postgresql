<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';
//ok
use ConexaoPHPPostgres\DepartmentLocationsModel as DepartmentLocationsModel;

$departmentLocationModel = new DepartmentLocationsModel($pdo);

$dnumber = null;
$dlocation = null;

if (!empty($_GET['dnumber'])) {
    $dnumber = $_REQUEST['dnumber'];
    $dlocation = $_REQUEST['dlocation'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dnumber = $_REQUEST['dnumber'];
    $dlocation = $_REQUEST['dlocation'];
    $dlocation_new = $_REQUEST['dlocation_new'];
    try {
        $departmentLocationModel->update($dnumber, $dlocation, $dlocation_new);
        header("Location: ../../pages/departamentos.php");
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
        <div class="col"><a href="../../pages/departamentos.php"><img src="../../assets/images/backbutton.png" height="40px"></a></div>
        <div class="col">
            <h4>Editar local </h4>
        </div>
        <div class="col"></div>
    </div>

    <form action="departamento_local.php" method="post">

        <!-- Alerta em caso de erro -->
        <?php if (!empty($error)) : ?>
            <span class="text-danger"><?php echo $error; ?></span>
        <?php endif; ?>

        <div class="form-group">
            <label for="dlocation_new">Nome do local:</label>
            <input class="form-control" value="<?php echo !empty($dlocation) ? $dlocation : ''; ?>" type="text" name="dlocation_new" id="dlocation" required>
        </div>

        <input type="hidden" id="dnumber" name="dnumber" value="<?php echo $dnumber  ?>">

        <input type="hidden" id="dlocation" name="dlocation" value="<?php echo $dlocation ?>">

        <input class="btn btn-primary" type="submit" value="Cadastrar">
    </form>
</div>
<?php
include('../../templates/footer.php');
?>