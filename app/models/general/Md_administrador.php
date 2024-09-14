<?php
require_once('app/models/extra/Md_aplicativo.php');

class Md_administrador extends Md_aplicativo
{
    public $pk_id_adm;
    //////////////////
    public $nom_adm;
    public $ape_adm;
    public $usu_adm;
    public $ema_adm;
    public $pass_adm;
    ////////////////////
    public $fk_etd_adm;
    ////////////////////
    public $extra;

    function __construct($array = NULL)
    {
        $this->pk_id_adm = $array['pk_id_adm'] ?? NULL;
        ///////////////////////////////////////////////
        $this->nom_adm = $array['nom_adm'] ?? NULL;
        $this->ape_adm = $array['ape_adm'] ?? NULL;
        $this->usu_adm = $array['usu_adm'] ?? NULL;
        $this->ema_adm = $array['ema_adm'] ?? NULL;
        $this->pass_adm = $array['pass_adm'] ?? NULL;
        ///////////////////////////////////////////////////
        $this->fk_etd_adm = $array['fk_etd_adm'] ?? NULL;
        ///////////////////////////////////////////////////
        $this->extra = $array['extra'] ?? NULL;
    }

    function search()
    {
        $func_cnx = $this->conexion();

        $cnsAdm = "SELECT * FROM administrador adm
        WHERE fk_etd_adm IN (1,2) AND
        pk_id_adm NOT IN (1,2) AND
        pk_id_adm = :pk_id_adm";

        $select = $func_cnx->prepare($cnsAdm);
        $select->bindParam(':pk_id_adm', $this->pk_id_adm, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function view()
    {
        $funcCnx = $this->conexion();

        $cnsAdm = "SELECT pk_id_adm, usu_adm, nom_adm,
        ape_adm, ema_adm, fk_etd_adm
        FROM administrador
        WHERE fk_etd_adm IN (1,2) AND
        pk_id_adm NOT IN(1)";

        $select = $funcCnx->prepare($cnsAdm);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function id()
    {
        $funcCnx = $this->conexion();

        $cnsAdm = "SELECT pk_id_adm FROM administrador
            WHERE fk_etd_adm = 1 AND
            pk_id_adm = :pk_id_adm";

        $select = $funcCnx->prepare($cnsAdm);
        $select->bindParam(':pk_id_adm', $this->pk_id_adm, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function exist()
    {
        $funcCnx = $this->conexion();

        if ($this->pk_id_adm) {
            $cns = " AND pk_id_adm != :pk_id_adm";
        } else {
            $cns = '';
        }

        $cnsAdm = "SELECT 
            usu_adm, ema_adm,
            CASE 
                WHEN usu_adm = :usu_adm AND ema_adm = :ema_adm THEN 'both'
                WHEN usu_adm = :usu_adm THEN 'usu_adm'
                WHEN ema_adm = :ema_adm THEN 'ema_adm'
                ELSE NULL 
            END AS coincidence
            FROM administrador
            WHERE fk_etd_adm IN (1,2) AND
                (usu_adm = :usu_adm OR ema_adm = :ema_adm)$cns";

        $select = $funcCnx->prepare($cnsAdm);

        if ($this->pk_id_adm) {
            $select->bindParam(':pk_id_adm', $this->pk_id_adm, PDO::PARAM_STR);
        }

        $select->bindParam(':usu_adm', $this->usu_adm, PDO::PARAM_STR);
        $select->bindParam(':ema_adm', $this->ema_adm, PDO::PARAM_STR);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function func_cns_singIn()
    {
        $func_cnx = $this->conexion();

        if (!filter_var($this->usu_adm, FILTER_VALIDATE_EMAIL)) {
            $cns = 'usu_adm = :add';
            $add = $this->usu_adm;
        } else {
            $cns = 'ema_adm = :add';
            $add = $this->usu_adm;
        }

        $cns_adm = "SELECT pk_id_adm, pass_adm, usu_adm, ema_adm
        FROM administrador
        WHERE fk_etd_adm = 1 AND
        $cns";

        $select = $func_cnx->prepare($cns_adm);
        $select->bindParam(':add', $add, PDO::PARAM_STR);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function paper()
    {
        $funcCnx = $this->conexion();

        $cnsAdm = "SELECT * FROM administrador
        WHERE fk_etd_adm = 3";

        $select = $funcCnx->prepare($cnsAdm);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function insert()
    {
        $func_cnx = $this->conexion();

        $insAdm = "INSERT INTO administrador (
            nom_adm, ape_adm, usu_adm,
            ema_adm, pass_adm
        ) VALUES (
            :nom_adm, :ape_adm, :usu_adm,
            :ema_adm, :pass_adm
        )";

        $insert = $func_cnx->prepare($insAdm);
        $insert->bindParam(':nom_adm', $this->nom_adm, PDO::PARAM_STR);
        $insert->bindParam(':ape_adm', $this->ape_adm, PDO::PARAM_STR);
        $insert->bindParam(':usu_adm', $this->usu_adm, PDO::PARAM_STR);
        $insert->bindParam(':ema_adm', $this->ema_adm, PDO::PARAM_STR);
        $insert->bindParam(':pass_adm', $this->pass_adm, PDO::PARAM_STR);

        if (!$insert->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $insert;
    }

    function update()
    {
        $func_cnx = $this->conexion();

        $updAdm = "UPDATE administrador
        SET nom_adm = :nom_adm, ape_adm = :ape_adm, usu_adm = :usu_adm,
        ema_adm = :ema_adm, fk_etd_adm = :fk_etd_adm
        WHERE pk_id_adm = :pk_id_adm";

        $update = $func_cnx->prepare($updAdm);
        $update->bindParam(':pk_id_adm', $this->pk_id_adm, PDO::PARAM_INT);
        $update->bindParam(':nom_adm', $this->nom_adm, PDO::PARAM_STR);
        $update->bindParam(':ape_adm', $this->ape_adm, PDO::PARAM_STR);
        $update->bindParam(':usu_adm', $this->usu_adm, PDO::PARAM_STR);
        $update->bindParam(':ema_adm', $this->ema_adm, PDO::PARAM_STR);
        $update->bindParam(':fk_etd_adm', $this->fk_etd_adm, PDO::PARAM_INT);

        if (!$update->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $update;
    }

    function trash()
    {
        $funcCnx = $this->conexion();

        $trhAdm = "UPDATE administrador SET
            fk_etd_adm = 3
            WHERE pk_id_adm = :pk_id_adm";

        $select = $funcCnx->prepare($trhAdm);
        $select->bindParam(':pk_id_adm', $this->pk_id_adm, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function restore()
    {
        $funcCnx = $this->conexion();

        $rtsAdm = "UPDATE administrador SET
            fk_etd_adm = 2
            WHERE pk_id_adm IN ($this->pk_id_adm)";

        $select = $funcCnx->prepare($rtsAdm);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function delete()
    {
        $funcCnx = $this->conexion();

        $delAdm = "DELETE FROM administrador WHERE pk_id_adm IN ($this->pk_id_adm)";

        $select = $funcCnx->prepare($delAdm);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }
}
