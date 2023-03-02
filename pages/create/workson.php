<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';
//ok
use ConexaoPHPPostgres\EmployerModel as EmployerModel;
use ConexaoPHPPostgres\ProjectModel as ProjectModel;
use ConexaoPHPPostgres\WorksOnModel as WorksOnModel;

$employerModel = new EmployerModel($pdo);
$projectModel = new ProjectModel($pdo);
$projects = $projectModel->all();

$id = 0;
$pno = null;
$hours = null;

if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
    $employer = $employerModel->select_by_id($id);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employer = $employerModel->select_by_id($_REQUEST['id']);
    $ecpf =  $_REQUEST['id'];
    $pno =  $_REQUEST['pno'];
    $hours =  $_REQUEST['hours'];

    try {
        $worksOnModel = new WorksOnModel($pdo);
        $worksOnModel->insert($ecpf, $pno, $hours);
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
        <div class="col-6">
            <h4>Adicionar <?php echo htmlspecialchars($employer['fname']), ' ' , htmlspecialchars($employer['lname'])?> a projeto</h4>
        </div>
        <div class="col"></div>
    </div>

    <form action="workson.php?id=<?php echo $id ?>" method="post">
        <!-- Alerta em caso de erro -->
        <?php if (!empty($error)) : ?>
            <span class="text-danger"><?php echo $error; ?></span>
        <?php endif; ?>

        <input type="hidden" name="id" value="<?php echo $id; ?>" />

        <div class="form-group">
            <label for="pno">Projeto:</label>
            <select class="form-control" id="pno" name="pno" value="<?php echo !empty($pno) ? $pno : ''; ?>" required>
                <?php foreach ($projects as $project) : ?>
                    <tr>
                        <option value="<?php echo htmlspecialchars($project['pnumber']); ?>" <?php echo $project['pnumber'] == $pno ? "selected" : '' ?>><?php echo htmlspecialchars($project['pname']), ' - ', htmlspecialchars($project['plocation']); ?></option>
                    </tr>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="hours">Quantidade de horas trabalhadas:</label>
            <input class="form-control" value="<?php echo !empty($relationship) ? $relationship : ''; ?>" type="number" name="hours" id="hours" required>
        </div>

        <input class="btn btn-primary" type="submit" value="Salvar">

    </form>
</div>

<?php
include('../../templates/footer.php');
?>