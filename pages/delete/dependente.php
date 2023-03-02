<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';
//ok
use ConexaoPHPPostgres\DependentModel as DependentModel;
use ConexaoPHPPostgres\EmployerModel as EmployerModel;

$dependentModel = new DependentModel($pdo);
$employerModel = new EmployerModel($pdo);

$id = 0;
$dependent_name = "";

if (!empty($_GET['id']) && !empty($_GET['dependent_name'])) {
    $id = $_REQUEST['id'];
    $dependent_name = $_REQUEST['dependent_name'];
    $dependent = $dependentModel->get_by_id_name($id, $dependent_name);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $dependent_name = $_POST['dependent_name'];
    try {
        $dependentModel->delete_by_id_name($id, $dependent_name);
        header("Location: ../../pages/funcionarios.php");
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

?>

<?php
include('../../templates/header.php');
?>

<?php if (!empty($dependent)) : ?>
    <div class="container">

        <div class="row py-5">
            <div class="col"><a href="../../pages/funcionarios.php"><img src="../../assets/images/backbutton.png" height="30px"></a></div>
            <div class="col">
                <h4>Remover dependente</h4>
            </div>
            <div class="col"></div>
        </div>

        <div class="span10">
            <div style="padding-top: 10px;">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nome: <?php echo htmlspecialchars($dependent['dependent_name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted">Parente relacionado: <?php
                                                                                        $employer = $employerModel->select_by_id($dependent['ecpf']);
                                                                                        echo htmlspecialchars($employer['fname']), " ", htmlspecialchars($employer['lname']);
                                                                                        ?></h6>
                        <form class="form-horizontal" action="dependente.php?id=<?php echo $dependent['ecpf']; ?>&dependent_name=<?php echo $dependent['dependent_name']; ?>" method="post">
                            <!-- Alerta em caso de erro -->
                            <?php if (!empty($error)) : ?>
                                <span class="text-danger"><?php echo $error; ?></span>
                            <?php endif; ?>

                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" name="dependent_name" value="<?php echo $dependent_name; ?>" />

                            <div class="alert  alert-danger" role="alert">
                                <h5> Deseja excluir o Funcionário? </h5>
                                <div class="form actions">
                                    <button type="submit" class="btn btn-danger"> Sim </button>
                                    <a href="../../pages/funcionarios.php" type="btn" class="btn btn-default"> Não </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
include('../../templates/footer.php');
?>