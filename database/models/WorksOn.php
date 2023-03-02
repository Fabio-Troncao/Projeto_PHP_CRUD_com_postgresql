<?php

namespace ConexaoPHPPostgres;
//ok
class WorksOnModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function all()
    {
        $stmt = $this->pdo->query('SELECT ecpf, pno, hours FROM public.works_on');
        $stocks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $stocks[] = [
                'ecpf' => $row['ecpf'],
                'pno' => $row['pno'],
                'hours' => $row['hours'],
            ];
        }
        return $stocks;
    }

    public function insert($ecpf, $pno, $hours)
    {
        // Preparar pra inserir novo exemplo
        $sql = "INSERT INTO public.works_on (ecpf, pno, hours) VALUES (:ecpf, :pno, :hours)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':ecpf', $ecpf);
        $stmt->bindValue(':pno', $pno);
        $stmt->bindValue(':hours', $hours);
        // Executar
        $stmt->execute();
    }

    public function select_by_ecpf($ecpf)
    {
        $stmt = $this->pdo->query("SELECT ecpf, pno, hours FROM public.works_on WHERE ecpf='$ecpf'");
        $stocks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $stocks[] = [
                'ecpf' => $row['ecpf'],
                'pno' => $row['pno'],
                'hours' => $row['hours'],
            ];
        }
        return $stocks;
    }

    public function select_by_ecpf_pdo($ecpf, $pdo)
    {

        $stmt = $this->pdo->query("SELECT ecpf, pno, hours FROM public.works_on WHERE ecpf='$ecpf' and pno='$pdo'");
        $workson = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($workson) {
            return [
                'ecpf' => $workson['ecpf'],
                'pno' => $workson['pno'],
                'hours' => $workson['hours'],
            ];
        } else {
            return null;
        }
    }


    public function update($ecpf, $pno, $hours)
    {   
        echo(" $ecpf , $pno , $hours");
        $stmt = $this->pdo->prepare("UPDATE public.works_on SET hours=:hours WHERE ecpf='$ecpf' and pno='$pno'");
        $stmt->bindParam(':hours', $hours);
        $stmt->execute();
    }
}
