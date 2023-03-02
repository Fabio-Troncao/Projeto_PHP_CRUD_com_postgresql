<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';
//ok
use ConexaoPHPPostgres\DepartmentModel as DepartmentModel;
use ConexaoPHPPostgres\EmployerModel as EmployerModel;
use ConexaoPHPPostgres\ProjectModel as ProjectModel;
use ConexaoPHPPostgres\DepartmentLocationsModel as DepartmentLocationsModel;

$departmentLocationModel = new DepartmentLocationsModel($pdo);
$departmentLocations = $departmentLocationModel->all($pdo);

$departmentModel = new DepartmentModel($pdo);
$departments = $departmentModel->all();

$pname = null;
$plocation = null;
$dnumber = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departmentReference = json_decode($_REQUEST['plocation'], true);
    $pname = $_REQUEST['pname'];
    $dnumber = $departmentReference['dnumber'];
    $plocation = $departmentReference['plocation'];


    try {
        $projectModel = new ProjectModel($pdo);
        $projectModel->insert($pname, $plocation, $dnumber);
        header("Location: ../../pages/projetos.php");
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
        <div class="col"><a href="../../pages/projetos.php"><img src="../../assets/images/backbutton.png" height="40px"></a></div>
        <div class="col">
            <h4>Adicionar novo Projeto</h4>
        </div>
        <div class="col"></div>
    </div>

    <form action="projeto.php" method="post">

        <!-- Alerta em caso de erro -->
        <?php if (!empty($error)) : ?>
            <span class="text-danger"><?php echo $error; ?></span>
        <?php endif; ?>

        <div class="form-group">
            <label for="pname">Nome do projeto:</label>
            <input class="form-control" value="<?php echo !empty($pname) ? $pname : ''; ?>" type="text" name="pname" id="pname" required>
        </div>

        <div class="form-group">
            <label for="plocation">Departamento - Local:</label>
            <select class="form-control" id="plocation" name="plocation" value="<?php echo !empty($plocation) ? $plocation : ''; ?>" required>
                <?php foreach ($departmentLocations as $departmentLocation) : ?>
                    <tr>
                        <?php $department = $departmentModel->select_by_id($departmentLocation['dnumber']);  ?>
                        <option value='{"dnumber":"  <?php echo htmlspecialchars($department['dnumber']); ?>","plocation":"<?php echo htmlspecialchars($departmentLocation['dlocation']); ?>"}' <?php echo $departmentLocation['dlocation'] ? "selected" : '' ?>>
                            <?php echo htmlspecialchars($department['dname']), ' - ', htmlspecialchars($departmentLocation['dlocation']); ?>
                        </option>
                    </tr>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" id="dnumber" name="dnumber" value="<?php $dnumber  ?>">

        <input class="btn btn-primary" type="submit" value="Cadastrar">
    </form>
</div>
<?php
include('../../templates/footer.php');
?>