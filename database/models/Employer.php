<?php

namespace ConexaoPHPPostgres;
//ok
class EmployerModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT cpf, fname, lname, bdate, address, sex, salary, cnh, dno FROM public.employee '
            . 'ORDER BY cpf ASC ');
        $stocks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $stocks[] = [
                'cpf' => $row['cpf'],
                'fname' => $row['fname'],
                'lname' => $row['lname'],
                'bdate' => $row['bdate'],
                'address' => $row['address'],
                'sex' => $row['sex'],
                'salary' => $row['salary'],
                'cnh' => $row['cnh'],
                'dno' => $row['dno'],
            ];
        }
        return $stocks;
    }

    public function insert($fname, $lname, $cpf, $bdate, $address, $sex, $salary, $cnh, $dno)
    {
        // Preparar pra inserir novo exemplo
        $sql = "INSERT INTO employee (fname, lname, cpf, bdate, address, sex, salary, cnh, dno) VALUES (:fname, :lname, :cpf, :bdate, :address, :sex, :salary, :cnh, :dno)";
        $stmt = $this->pdo->prepare($sql);

        // Passar os valores
        $stmt->bindValue(':fname', $fname);
        $stmt->bindValue(':lname', $lname);
        $stmt->bindValue(':cpf', $cpf);
        $stmt->bindValue(':bdate', $bdate);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':sex', $sex);
        $stmt->bindValue(':salary', $salary);
        $stmt->bindValue(':cnh', $cnh);
        $stmt->bindValue(':dno', $dno);

        // Executar
        $stmt->execute();
    }

    public function update($fname, $lname, $cpf, $bdate, $address, $sex, $salary, $cnh, $dno)
    {
        // Preparar pra atualizar novo exemplo
        $sql = "UPDATE public.employee SET fname='$fname', lname='$lname', bdate='$bdate', address='$address', sex='$sex', salary='$salary', cnh='$cnh', dno='$dno' WHERE cpf='$cpf' ";
        $stmt = $this->pdo->prepare($sql);
        // Executar
        $stmt->execute();
    }

    public function delete_by_id($id)
    {
        // Preparar pra remover 
        $sql = "DELETE from employee WHERE cpf='$id'";
        $stmt = $this->pdo->prepare($sql);
        // Executar o SQL
        $stmt->execute();
    }

    public function select_by_id($id)
    {
        $stmt = $this->pdo->query("SELECT cpf, fname, lname, bdate, address, sex, salary, cnh, dno FROM public.employee WHERE cpf='$id' ");
        $employer = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($employer) {
            return [
                'cpf' => $employer['cpf'],
                'fname' => $employer['fname'],
                'lname' => $employer['lname'],
                'bdate' => $employer['bdate'],
                'address' => $employer['address'],
                'sex' => $employer['sex'],
                'salary' => $employer['salary'],
                'cnh' => $employer['cnh'],
                'dno' => $employer['dno'],
            ];
        } else {
            return null;
        }
    }
}
