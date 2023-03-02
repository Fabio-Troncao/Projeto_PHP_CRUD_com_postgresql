<?php
include '../../database/models.php';
include_once '../../database/database.ini.php';

use ConexaoPHPPostgres\DepartmentModel as DepartmentModel;
use ConexaoPHPPostgres\EmployerModel as EmployerModel;
//ok
$departmentModel = new DepartmentModel($pdo);
$departments = $departmentModel->all();

$fname = null;
$lname = null;
$cpf = null;
$bdate = null;
$address = null;
$sex = null;
$salary = null;
$cnh = null;
$dno = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fname = $_REQUEST['fname'];
    $lname = $_REQUEST['lname'];
    $cpf = $_REQUEST['cpf'];
    $bdate = $_REQUEST['bdate'];
    $address = $_REQUEST['address'];
    $sex = $_REQUEST['sex'];
    $salary = $_REQUEST['salary'];
    $cnh = $_REQUEST['cnh'];
    $dno = $_REQUEST['dno'];

    try {
        $employerModel = new EmployerModel($pdo);
        $employerModel->insert($_REQUEST['fname'], $_REQUEST['lname'], $_REQUEST['cpf'], $_REQUEST['bdate'], $_REQUEST['address'], $_REQUEST['sex'], $_REQUEST['salary'], $_REQUEST['cnh'], $_REQUEST['dno']);
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
        <div class="col"><a href="../../pages/funcionarios.php"><img src="../../assets/images/backbutton.png" height="40px"></a></div>
        <div class="col">
            <h4>Cadastrar novo funcionário</h4>
        </div>
        <div class="col"></div>
    </div>

    <form action="funcionario.php" method="post">
        <!-- Alerta em caso de erro -->
        <?php if (!empty($error)) : ?>
            <span class="text-danger"><?php echo $error; ?></span>
        <?php endif; ?>

        <div class="form-group">
            <label for="Nome">Primeiro Nome:</label>
            <input class="form-control" value="<?php echo !empty($fname) ? $fname : ''; ?>" type="text" name="fname" id="primeironome" required>
        </div>

        <div class="form-group">
            <label for="Sobrenome">Sobrenome:</label>
            <input class="form-control" type="text" value="<?php echo !empty($lname) ? $lname : ''; ?>" name="lname" id="sobrenome" required>
        </div>

        <div class="form-group">
            <label for="cpf">cpf:</label>
            <input class="form-control" type="text" value="<?php echo !empty($cpf) ? $cpf : ''; ?>" name="cpf" id="cpf" required>
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
            <label for="dno">Departamento:</label>
            <select class="form-control" id="dno" name="dno" value="<?php echo !empty($dno) ? $dno : ''; ?>" required>
                <?php foreach ($departments as $department) : ?>
                    <tr>
                        <option value="<?php echo htmlspecialchars($department['dnumber']); ?>" <?php echo $department['dnumber'] == $dno ? "selected" : '' ?>><?php echo htmlspecialchars($department['dname']); ?></option>
                    </tr>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Salary">Salario:</label>
            <input class="form-control" type="number" value="<?php echo !empty($salary) ? $salary : ''; ?>" name="salary" id="salary" required>
        </div>

        <div class="form-group">
            <label for="cnh">CNH:</label>
            <br>
            <input type="radio" id="sim" name="cnh" value="S" <?php echo $cnh === 'S' ? "checked" : '' ?> required>
            <label for="sim">Sim</label><br>
            <input type="radio" id="nao" name="cnh" value="N" <?php echo $cnh == 'N' ? "checked" : '' ?>>
            <label for="nao">Nao</label>
        </div>

        <div class="form-group">
            <label for="Address">Endereço:</label>
            <input class="form-control" type="text" value="<?php echo !empty($address) ? $address : ''; ?>" name="address" id="address" required>
        </div>

        <div class="form-group">
            <label for="Data">Data Nascimento:</label>
            <input class="form-control" type="date" value="<?php echo !empty($bdate) ? $bdate : ''; ?>" name="bdate" id="datanascimento" required>
        </div>

        <input class="btn btn-primary" type="submit" value="Cadastrar">

    </form>
</div>

<?php
include('../../templates/footer.php');
?>