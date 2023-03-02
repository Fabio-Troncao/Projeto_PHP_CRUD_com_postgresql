<?php

namespace ConexaoPHPPostgres;
//Ok
class DepartmentModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT dnumber, dname, mgr_cpf FROM public.department');
        $stocks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $stocks[] = [
                'dnumber' => $row['dnumber'],
                'dname' => $row['dname'],
                'mgr_cpf' => $row['mgr_cpf']
            ];
        }
        return $stocks;
    }

    public function select_by_id($dnoid)
    {
        $stmt = $this->pdo->query("SELECT dnumber, dname, mgr_cpf FROM public.department WHERE dnumber='$dnoid'");
        $department = $stmt->fetch(\PDO::FETCH_ASSOC);
        return [
            'dnumber' => $department['dnumber'],
            'dname' => $department['dname'],
            'mgr_cpf' => $department['mgr_cpf']
            
        ];
    }

    public function delete($dnumber)
    {
        $sql = "DELETE from department WHERE dnumber='$dnumber'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function insert($dname, $mgr_cpf, $mgr_start_date)
    {
        // Preparar pra inserir novo exemplo
        $sql = "INSERT INTO public.department (dnumber, dname, mgr_cpf, mgr_start_date) VALUES (DEFAULT, :dname, :mgr_cpf, :mgr_start_date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':dname', $dname);
        $stmt->bindValue(':mgr_cpf', $mgr_cpf);
        $stmt->bindValue(':mgr_start_date', $mgr_start_date);
        // Executar
        $stmt->execute();
    }

    public function update($dnumber, $dname, $mgr_cpf){
        $sql = "UPDATE public.department SET dname='$dname', mgr_cpf='$mgr_cpf' WHERE dnumber='$dnumber' ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

}
