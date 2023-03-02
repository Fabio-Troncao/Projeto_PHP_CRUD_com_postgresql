<?php

namespace ConexaoPHPPostgres;
//ok
class ProjectModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT pname, pnumber, plocation, dnum FROM public.project');
        $stocks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $stocks[] = [
                'pname' => $row['pname'],
                'pnumber' => $row['pnumber'],
                'plocation' => $row['plocation'],
                'dnum' => $row['dnum'],
            ];
        }
        return $stocks;
    }

    public function get_by_id($id)
    {
        $stmt = $this->pdo->query("SELECT pname, pnumber, plocation, dnum FROM public.project WHERE pnumber='$id'");
        $department = $stmt->fetch(\PDO::FETCH_ASSOC);
        return [
            'pname' => $department['pname'],
            'pnumber' => $department['pnumber'],
            'plocation' => $department['plocation'],
            'dnum' => $department['dnum'],
        ];
    }

    public function insert($pname, $plocation, $dnum)
    {
        // Preparar pra inserir novo exemplo
        $sql = "INSERT INTO public.project (pname, pnumber, plocation, dnum) VALUES (:pname, DEFAULT, :plocation, :dnum)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':pname', $pname);
        $stmt->bindValue(':plocation', $plocation);
        $stmt->bindValue(':dnum', $dnum);
        // Executar
        $stmt->execute();
    }

    public function update($pnumber, $pname, $plocation, $dnum)
    {
        $sql = "UPDATE public.project SET pname='$pname', plocation='$plocation', dnum='$dnum' WHERE pnumber='$pnumber' ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }
}
