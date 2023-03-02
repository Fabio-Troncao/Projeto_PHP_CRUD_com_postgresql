<?php

namespace ConexaoPHPPostgres;
//ok
class DepartmentLocationsModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT dnumber, dlocation FROM public.dept_locations');
        $stocks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $stocks[] = [
                'dnumber' => $row['dnumber'],
                'dlocation' => $row['dlocation'],
            ];
        }
        return $stocks;
    }

    public function select_by_id($dnumber)
    {
        $stmt = $this->pdo->query("SELECT dnumber, dlocation FROM public.dept_locations WHERE dnumber='$dnumber'");
        $departmentlocation = $stmt->fetch(\PDO::FETCH_ASSOC);
        return [
            'dnumber' => $departmentlocation['dnumber'],
            'dlocation' => $departmentlocation['dlocation'],
        ];
    }

    public function select_by_dnumber($dnumber)
    {
        $stmt = $this->pdo->query("SELECT dnumber, dlocation FROM public.dept_locations WHERE dnumber='$dnumber'");
        $stocks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $stocks[] = [
                'dnumber' => $row['dnumber'],
                'dlocation' => $row['dlocation'],
            ];
        }
        return $stocks;
    }

    public function insert($dnumber, $dlocation)
    {
        // Preparar pra inserir novo exemplo
        $sql = "INSERT INTO public.dept_locations (dnumber, dlocation) VALUES (:dnumber, :dlocation)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':dnumber', $dnumber);
        $stmt->bindValue(':dlocation', $dlocation);
        $stmt->execute();
    }


    
    public function update($dnumber, $dlocation_old, $dlocation_new)
    {
        $sql = "UPDATE public.dept_locations SET dnumber='$dnumber', dlocation='$dlocation_new' WHERE dnumber='$dnumber' and dlocation='$dlocation_old'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }
}
