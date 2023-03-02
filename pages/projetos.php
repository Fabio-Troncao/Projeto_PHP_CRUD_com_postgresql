<?php
include '../database/models.php';
include_once '../database/database.ini.php';
//ok
use ConexaoPHPPostgres\DepartmentModel as DepartmentModel;
use ConexaoPHPPostgres\ProjectModel as ProjectModel;

try {
    $projectModel = new ProjectModel($pdo);
    $departmentModel = new DepartmentModel($pdo);

    $projects = $projectModel->all();
} catch (\PDOException $e) {
    echo $e->getMessage();
}
?>
<?php
include('../templates/header.php');
?>

<br>
<div class="container">
    <div class="row">
        <div class="col-auto mr-auto">
            <h1 style="padding-top: 10px; padding-bottom:10px">Projetos</h1>
        </div>
        <div class="col-auto">
            <div class="text-right mb-4">
                <a class="btn" style="background-color: #00897c; color:white" href="../../pages/create/projeto.php">Cadastrar novo</a>
            </div>
        </div>
    </div>

    <?php foreach ($projects as $projet) : ?>
        <div class="alert">
            <div class="card-body" style="background-color: #F4F6FC;">
                <h4 class="alert-heading"><?php echo htmlspecialchars($projet['pname']); ?></h4>
                <p> <img src="../assets/icons/map-pin-line.png">
                    Local: <?php echo htmlspecialchars($projet['plocation']); ?>
                </p>
                <p> <img src="../assets/icons/profile-fill.png">
                    Departamento: <?php
                                    $department = $departmentModel->select_by_id($projet['dnum']);
                                    echo htmlspecialchars($department['dname']);
                                    ?>
                </p>
                <hr>
                <a href="../../pages/update/projeto.php?id=<?php echo $projet['pnumber']; ?>" class="card-link">Editar</a>

            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
include('../templates/footer.php');
?>