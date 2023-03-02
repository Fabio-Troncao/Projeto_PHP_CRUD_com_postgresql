<?php

namespace ConexaoPHPPostgres;
//ok
class DependentModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function get_by_id($id)
    {
        $stmt = $this->pdo->query("SELECT ecpf, dependent_name, sex, bdate, relationship FROM public.dependent WHERE ecpf='$id'");
        $stocks = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {

            $stocks[] = [
                'ecpf' => $row['ecpf'],
                'dependent_name' => $row['dependent_name'],
                'sex' => $row['sex'],
                'bdate' => $row['bdate'],
                'relationship' => $row['relationship'],
            ];
        }
        return $stocks;
    }

    public function get_by_id_name($id, $dependent_name)
    {
        $stmt = $this->pdo->query("SELECT ecpf, dependent_name, sex, bdate, relationship FROM public.dependent WHERE ecpf='$id' and dependent_name='$dependent_name'");
        $dependent = $stmt->fetch(\PDO::FETCH_ASSOC);
        return [
            'ecpf' => $dependent['ecpf'],
            'dependent_name' => $dependent['dependent_name'],
            'sex' => $dependent['sex'],
            'bdate' => $dependent['bdate'],
            'relationship' => $dependent['relationship'],
        ];
    }

    public function delete_by_id_name($id, $dependent_name)
    {
        // Preparar pra remover 
        $sql = "DELETE from public.dependent WHERE ecpf='$id' and dependent_name='$dependent_name'";
        $stmt = $this->pdo->prepare($sql);
        // Executar o SQL
        $stmt->execute();
    }

    public function insert($ecpf, $dependent_name, $sex, $bdate, $relationship)
    {
        // Preparar pra inserir novo exemplo
        $sql = "INSERT INTO dependent (ecpf, dependent_name, sex, bdate, relationship) VALUES (:ecpf, :dependent_name, :sex, :bdate, :relationship)";
        $stmt = $this->pdo->prepare($sql);

        // Passar os valores
        $stmt->bindValue(':ecpf', $ecpf);
        $stmt->bindValue(':dependent_name', $dependent_name);
        $stmt->bindValue(':sex', $sex);
        $stmt->bindValue(':bdate', $bdate);
        $stmt->bindValue(':relationship', $relationship);

        // Executar
        $stmt->execute();
    }

    public function update($ecpf, $dependent_name, $sex, $bdate, $relationship)
    {
        // Preparar para atualizar
        $sql = "UPDATE public.dependent SET fname='$ecpf', lname='$dependent_name',sex='$sex',  bdate='$bdate', relationship='$relationship' ";
        $stmt = $this->pdo->prepare($sql);
        // Executar
        $stmt->execute();
    }
}
