<?php
require_once('app/models/extra/Md_aplicativo.php');

class Md_categoria extends Md_aplicativo
{
    public $pk_id_ctg;
    //////////////////
    public $nom_ctg;
    public $img_ctg;
    public $des_ctg;
    ////////////////////
    public $fk_etd_ctg;
    ////////////////////
    public $extra;

    function __construct($array = NULL)
    {
        $this->pk_id_ctg = $array['pk_id_ctg'] ?? NULL;
        ///////////////////////////////////////////////
        $this->nom_ctg = $array['nom_ctg'] ?? NULL;
        $this->img_ctg = $array['img_ctg'] ?? NULL;
        $this->des_ctg = $array['des_ctg'] ?? NULL;
        /////////////////////////////////////////////////
        $this->fk_etd_ctg = $array['fk_etd_ctg'] ?? NULL;
        /////////////////////////////////////////////////
        $this->extra = $array['extra'] ?? NULL;
    }

    function search()
    {
        $funcCnx = $this->conexion();

        $cnsCtg = "SELECT * FROM categoria
        WHERE pk_id_ctg IN ($this->pk_id_ctg)";

        $select = $funcCnx->prepare($cnsCtg);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function view()
    {
        $funcCnx = $this->conexion();

        if (!empty($this->extra)) {
            $cns = '1,2';
        } else {
            $cns = '1';
        }

        $cnsCtg = "SELECT * FROM categoria
        WHERE fk_etd_ctg IN($cns) ORDER BY fk_etd_ctg";

        $select = $funcCnx->prepare($cnsCtg);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function list()
    {
        $funcCnx = $this->conexion();

        $cnsCtg = "SELECT pk_id_ctg, nom_ctg FROM categoria
        WHERE pk_id_ctg != 1 AND
        fk_etd_ctg IN(1,2)";

        $select = $funcCnx->prepare($cnsCtg);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function exist()
    {
        $funcCnx = $this->conexion();

        $cnsCtg = "SELECT pk_id_ctg FROM categoria
        WHERE pk_id_ctg != 1 AND
        pk_id_ctg = :pk_id_ctg AND
        fk_etd_ctg IN(1,2)";

        $select = $funcCnx->prepare($cnsCtg);
        $select->bindParam(':pk_id_ctg', $this->pk_id_ctg, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function paper()
    {
        $funcCnx = $this->conexion();

        $cnsCtg = "SELECT ctg.*,
        COUNT(prd.pk_id_prd) AS count_prd FROM categoria ctg
        LEFT JOIN producto prd ON prd.fk_ctg_prd = ctg.pk_id_ctg
        WHERE ctg.fk_etd_ctg = 3
        GROUP BY ctg.pk_id_ctg";

        $select = $funcCnx->prepare($cnsCtg);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function remove()
    {
        $funcCnx = $this->conexion();

        $cnsCtg = "SELECT * FROM categoria ctg
        WHERE ctg.fk_etd_ctg = 3 AND
        pk_id_ctg IN (" . $this->pk_id_ctg . ")";

        $select = $funcCnx->prepare($cnsCtg);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function insert()
    {
        $funcCnx = $this->conexion();

        $insCtg = "INSERT INTO categoria
        (
            nom_ctg, img_ctg, des_ctg,
            fk_etd_ctg
        ) VALUES(
            :nom_ctg, :img_ctg, :des_ctg,
            :fk_etd_ctg
        )";

        $select = $funcCnx->prepare($insCtg);
        $select->bindParam(':nom_ctg', $this->nom_ctg, PDO::PARAM_STR);
        $select->bindParam(':img_ctg', $this->img_ctg, PDO::PARAM_STR);
        $select->bindParam(':des_ctg', $this->des_ctg, PDO::PARAM_STR);
        $select->bindParam(':fk_etd_ctg', $this->fk_etd_ctg, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function update()
    {
        $funcCnx = $this->conexion();

        $updCtg = "UPDATE categoria SET
            nom_ctg = :nom_ctg, img_ctg = :img_ctg, des_ctg = :des_ctg,
            fk_etd_ctg = :fk_etd_ctg
            WHERE pk_id_ctg = :pk_id_ctg";

        $select = $funcCnx->prepare($updCtg);
        $select->bindParam(':nom_ctg', $this->nom_ctg, PDO::PARAM_STR);
        $select->bindParam(':img_ctg', $this->img_ctg, PDO::PARAM_STR);
        $select->bindParam(':des_ctg', $this->des_ctg, PDO::PARAM_STR);
        $select->bindParam(':fk_etd_ctg', $this->fk_etd_ctg, PDO::PARAM_INT);
        $select->bindParam(':pk_id_ctg', $this->pk_id_ctg, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function trash()
    {
        $funcCnx = $this->conexion();

        $trhCtg = "UPDATE categoria SET
            fk_etd_ctg = 3
            WHERE pk_id_ctg = :pk_id_ctg";

        $select = $funcCnx->prepare($trhCtg);
        $select->bindParam(':pk_id_ctg', $this->pk_id_ctg, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function restore()
    {
        $funcCnx = $this->conexion();

        $rtsCtg = "UPDATE categoria SET
            fk_etd_ctg = 2
            WHERE pk_id_ctg IN ($this->pk_id_ctg)";

        $select = $funcCnx->prepare($rtsCtg);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function delete()
    {
        $funcCnx = $this->conexion();

        $delCtg = "DELETE FROM categoria WHERE pk_id_ctg IN ($this->pk_id_ctg)";

        $select = $funcCnx->prepare($delCtg);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }
}
