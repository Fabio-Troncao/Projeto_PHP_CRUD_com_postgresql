<?php

include '../database/models.php';
include_once '../database/database.ini.php';
//ok
use ConexaoPHPPostgres\EmployerModel as EmployerModel;
use ConexaoPHPPostgres\DepartmentModel as DepartmentModel;
use ConexaoPHPPostgres\DependentModel as DependentModel;
use ConexaoPHPPostgres\WorksOnModel as WorksOnModel;
use ConexaoPHPPostgres\ProjectModel as ProjectModel;

try {

    $departmentModel = new DepartmentModel($pdo);
    $employerModel = new EmployerModel($pdo);
    $dependentModel = new DependentModel($pdo);
    $worksOnMOdel = new WorksOnModel($pdo);
    $projectModel = new ProjectModel($pdo);

    $employers = $employerModel->all();
} catch (\PDOException $e) {
    echo $e->getMessage();
}

?>

<?php
include('../templates/header.php');
?>
<div class="container">

    <div class="row">
        <div class="col-auto mr-auto">
            <h1 style="padding-top: 10px; padding-bottom:10px">Funcionários</h1>
        </div>
        <div class="col-auto">
            <div class="text-right mb-4">
                <a class="btn" style="background-color:#00897c; color:white" href="../../pages/create/funcionario.php">Cadastrar novo</a>
            </div>
        </div>
    </div>

    <?php foreach ($employers as $employe) : ?>

        <div>
            <div class="alert">
                <div class="card-body" style="background-color: #F4F6FC;">
                    <div class="row" style="padding-bottom: 5px;">
                        <div class="col-sm-1">
                            <img src="../assets/images/user.png" height="70">
                        </div>
                        <div class="col-sm-8">
                            <h5 class="card-title"><?php echo htmlspecialchars($employe['fname']); ?> <?php echo htmlspecialchars($employe['lname']); ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($employe['cpf']); ?></h6>
                        </div>
                    </div>
                    <p class="card-text mb-2"><img src="../assets/icons/map-pin-line.png"> Endereço: <?php echo htmlspecialchars($employe['address']); ?></p>
                    <p class="card-text mb-2"><img src="../assets/icons/profile-fill.png"> Departamento: <?php
                                                                                                            $department = $departmentModel->select_by_id($employe['dno']);
                                                                                                            echo htmlspecialchars($department['dname']);
                                                                                                            ?></p>


                    <?php
                    $dependents = $dependentModel->get_by_id($employe['cpf']);
                    $worksons = $worksOnMOdel->select_by_ecpf($employe['cpf']);
                    ?>

                    <!-- Lista de Projeto -->
                    <button type="button" class="btn-light collapsibleProjetos">
                        <div class="row">
                            <div class="col">                               
                                <p class="card-text mb-2"><img src="../assets/icons/file-user-fill.png"> Projetos: </p>
                            </div>
                            <div class="col col-lg-1">
                                <a href="../../pages/create/workson.php?id=<?php echo $employe['cpf']; ?>">Adicionar</a>
                            </div>
                            <div class="col col-lg-1">

                            </div>
                        </div>
                    </button>

                    <div class="content-expanded">
                        <?php if (!empty($worksons)) : ?>
                            <br>
                            <?php foreach ($worksons as $workson) : ?>

                                <div class="alert alert-light" role="alert">

                                    <div class="row">
                                        <div class="col-md-8 mr-auto">
                                            <dl class="row">
                                                <dt class="col-sm-3">
                                                    <p>
                                                        <?php
                                                        $pworkon = $projectModel->get_by_id($workson['pno']);
                                                        echo htmlspecialchars($pworkon['pname']);
                                                        ?>
                                                    </p>
                                                </dt>
                                                <dd class="col-sm-9">
                                                    <p>Local: <?php echo htmlspecialchars($pworkon['plocation'])  ?></p>
                                                    <p>Horas trabalhadas: <?php echo htmlspecialchars($workson['hours'])  ?></p>
                                                </dd>
                                            </dl>
                                        </div>
                                        <div class="col-auto">
                                            <a href="../../pages/update/workson.php?id=<?php echo $workson['ecpf']; ?>&pno=<?php echo $workson['pno']; ?>">Editar</a>
                                        </div>
                                    </div>


                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Lista de Dependentes -->

                    <button type="button" class="btn-light collapsible">
                        <div class="row">
                            <div class="col">
                                <p class="card-text mb-2"><img src="../assets/icons/file-user-fill.png"> Dependentes: </p>
                            </div>
                            <div class="col col-lg-1">
                                <a href="../../pages/create/dependente.php?id=<?php echo $employe['cpf']; ?>">Adicionar</a>
                            </div>
                            <div class="col col-lg-1">

                            </div>
                        </div>
                    </button>

                    <div class="content-expanded">
                        <?php if (!empty($dependents)) : ?>
                            <br>
                            <?php foreach ($dependents as $dependent) : ?>
                                <div class="alert alert-light" role="alert">
                                    <div class="row">
                                        <div class="col-md-8 mr-auto">
                                            <dl class="row">
                                                <dt class="col-sm-3"><?php echo htmlspecialchars($dependent['dependent_name'])  ?></p>
                                                </dt>
                                                <dd class="col-sm-9">
                                                    <p>Relação: <?php echo htmlspecialchars($dependent['relationship'])  ?></p>
                                                </dd>
                                            </dl>
                                        </div>
                                        <div class="col-auto"> <a href="../../pages/delete/dependente.php?id=<?php echo $dependent['ecpf']; ?>&dependent_name=<?php echo $dependent['dependent_name']; ?>"><img src="../assets/icons/delete-bin-2-fill.png"></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <hr>
                    <a href="../../pages/update/funcionario.php?id=<?php echo $employe['cpf']; ?>" class="card-link">Editar</a>
                    <a href="../../pages/delete/funcionario.php?id=<?php echo $employe['cpf']; ?>" class="card-link">Remover</a>

                </div>
            </div>

        </div>
    <?php endforeach; ?>
</div>


<?php
include('../templates/footer.php');
?>

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