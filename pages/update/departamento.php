<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';
//ok
use ConexaoPHPPostgres\DepartmentModel as DepartmentModel;
use ConexaoPHPPostgres\EmployerModel as EmployerModel;


$employerModel = new EmployerModel($pdo);
$departmentModel = new DepartmentModel($pdo);
$employers = $employerModel->all();

$id = null;
$dname = null;
$mgr_cpf = null;

if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
    $department = $departmentModel->select_by_id($id);

    $dname = $department['dname'];
    $mgr_cpf = $department['mgr_cpf'];
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dname = $_REQUEST['dname'];
    $mgr_cpf = $_REQUEST['mgr_cpf'];

    try {
        $departmentModel->update($_REQUEST['dnumber'], $dname, $mgr_cpf);
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
            <h4>Editar Departamento</h4>
        </div>
        <div class="col"></div>
    </div>

    <form action="departamento.php" method="post">

        <!-- Alerta em caso de erro -->
        <?php if (!empty($error)) : ?>
            <span class="text-danger"><?php echo $error; ?></span>
        <?php endif; ?>

        <input type="hidden" id="dnumber" name="dnumber" value="<?php echo !empty($id) ? $id : ''; ?>">

        <div class="form-group">
            <label for="dname">Nome do departamento:</label>
            <input class="form-control" value="<?php echo !empty($dname) ? $dname : ''; ?>" type="text" name="dname" id="dname" required>
        </div>

        <div class="form-group">
            <label for="mgr_cpf">Empregado responsavel:</label>
            <select class="form-control" id="mgr_cpf" name="mgr_cpf" value="<?php echo !empty($mgr_cpf) ? $mgr_cpf : ''; ?>" required>
                <?php foreach ($employers as $employer) : ?>
                    <tr>
                        <option value="<?php echo htmlspecialchars($employer['cpf']); ?>" <?php echo $employer['cpf'] == $mgr_cpf ? "selected" : '' ?>><?php echo htmlspecialchars($employer['fname']), ' ', htmlspecialchars($employer['lname']); ?></option>
                    </tr>
                <?php endforeach; ?>
            </select>
        </div>

        <input class="btn btn-primary" type="submit" value="Salvar">

    </form>
</div>

<?php
include('../../templates/footer.php');
?>