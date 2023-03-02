<?php

include '../database/models.php';
include_once '../database/database.ini.php';
// ok
use ConexaoPHPPostgres\DepartmentModel as DepartmentModel;
use ConexaoPHPPostgres\EmployerModel as EmployerModel;
use ConexaoPHPPostgres\DepartmentLocationsModel as DepartmentLocationsModel;
try {
    $departmentLocationModel = new DepartmentLocationsModel($pdo);
    $employerModel = new EmployerModel($pdo);
    $departmentModel = new DepartmentModel($pdo);
    $departments = $departmentModel->all();

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
            <h1 style="padding-top: 10px; padding-bottom:10px">Departamentos</h1>
        </div>
        <div class="col-auto">
            <div class="text-right mb-4">
                <a class="btn" style="background-color: #00897c; color:white" href="../../pages/create/departamento.php">Cadastrar novo</a>
            </div>
        </div>
    </div>

    <?php foreach ($departments as $department) : ?>

        <div class="alert">
            <div class="card-body" style="background-color: #F4F6FC;">
                <h4 class="alert-heading"><?php echo htmlspecialchars($department['dname']); ?></h4>
                <p><img src="../assets/icons/user-star-fill.png"> Adminstrado por
                    <?php
                    $employer = $employerModel->select_by_id($department['mgr_cpf']);
                    if ($employer) {
                        echo htmlspecialchars($employer['fname']), " ", htmlspecialchars($employer['lname']);
                    }
                    ?>
                </p>

                
                <!-- Lista de Locais -->
                <button type="button" class="btn-light collapsibleProjetos">
                    <div class="row">
                        <div class="col">
                            <p class="card-text mb-2"><img src="../assets/icons/map-pin-line.png"> Locais: </p>
                        </div>
                        <div class="col col-lg-1">
                            <a href="../../pages/create/departamento_local.php?dnumber=<?php echo $department['dnumber'] ?>">Adicionar</a>
                        </div>
                        <div class="col col-lg-1">

                        </div>
                    </div>
                </button>
                <?php
                        $departmentLocations = $departmentLocationModel->select_by_dnumber($department['dnumber']);
                ?>
                <div class="content-expanded">
                    <?php if (!empty($departmentLocations)) : ?>
                        <br>
                        <?php foreach ($departmentLocations as $departmentLocation) : ?>

                            <div class="alert alert-light" role="alert">

                                <div class="row">
                                    <div class="col-md-8 mr-auto">
                                        <dl class="row">
                                            <dt class="col-sm-3">
                                                <p>
                                                    <?php
                                                    echo htmlspecialchars($departmentLocation['dlocation']);
                                                    ?>
                                                </p>
                                            </dt>
                                        </dl>
                                    </div>
                                    <div class="col-auto">
                                        <a href="../../pages/update/departamento_local.php?dnumber=<?php echo $departmentLocation['dnumber'] ?>&dlocation=<?php echo $departmentLocation['dlocation'] ?>">Editar</a>
                                    </div>
                                </div>


                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <a href="../../pages/update/departamento.php?id=<?php echo $department['dnumber']; ?>" class="card-link">Editar</a>
            </div>
        </div>

    <?php endforeach; ?>


</div>


<script>
    var coll = document.getElementsByClassName("collapsible");
    var collP = document.getElementsByClassName("collapsibleProjetos");
    colunmAply(coll)
    colunmAply(collP)

    function colunmAply(coll) {
        var i;
        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    }
</script>

<?php
include('../templates/footer.php');
?>