<?php
require_once('app/models/extra/Md_aplicativo.php');

class Md_producto extends Md_aplicativo
{
    public $pk_id_prd;
    //////////////////
    public $dCrt_prd;
    public $nom_prd;
    public $img_prd;
    public $des_prd;
    ////////////////////
    public $fk_ctg_prd;
    public $fk_etd_prd;
    ////////////////////
    public $extra;

    function __construct($array = NULL)
    {
        $this->pk_id_prd = $array['pk_id_prd'] ?? NULL;
        ///////////////////////////////////////////////
        $this->dCrt_prd = $array['dCrt_prd'] ?? NULL;
        $this->nom_prd = $array['nom_prd'] ?? NULL;
        $this->img_prd = $array['img_prd'] ?? NULL;
        $this->des_prd = $array['des_prd'] ?? NULL;
        ///////////////////////////////////////////////////
        $this->fk_ctg_prd = $array['fk_ctg_prd'] ?? NULL;
        $this->fk_etd_prd = $array['fk_etd_prd'] ?? NULL;
        ///////////////////////////////////////////////////
        $this->extra = $array['extra'] ?? NULL;
    }

    function search()
    {
        $funcCnx = $this->conexion();

        $cns_prd = "SELECT * FROM producto prd
        WHERE fk_etd_prd IN(1,2) AND
        pk_id_prd = :pk_id_prd";

        $select = $funcCnx->prepare($cns_prd);
        $select->bindParam(':pk_id_prd', $this->pk_id_prd, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function list()
    {
        $funcCnx = $this->conexion();

        $cns_prd = "SELECT * FROM producto prd
        INNER JOIN categoria ctg ON ctg.pk_id_ctg = prd.fk_ctg_prd
        WHERE fk_etd_prd IN(1,2)
        ORDER BY ctg.pk_id_ctg";

        $select = $funcCnx->prepare($cns_prd);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function category()
    {
        $funcCnx = $this->conexion();

        if (!empty($this->extra)) {
            $cns = '1,2';
        } else {
            $cns = '1';
        }

        $cnsCtg = "SELECT prd.* FROM producto prd
        INNER JOIN categoria ctg ON ctg.pk_id_ctg = prd.fk_ctg_prd
        WHERE fk_etd_ctg IN ($cns) AND
        prd.fk_etd_prd IN ($cns) AND
        prd.fk_ctg_prd IN (" . $this->fk_ctg_prd . ")
        ORDER BY prd.fk_etd_prd";

        $select = $funcCnx->prepare($cnsCtg);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function paper()
    {
        $funcCnx = $this->conexion();

        $cnsPrd = "SELECT prd.*, ctg.nom_ctg FROM producto prd
        INNER JOIN categoria ctg ON ctg.pk_id_ctg = prd.fk_ctg_prd
        WHERE ctg.fk_etd_ctg AND
        prd.fk_etd_prd = 3
        ORDER BY ctg.pk_id_ctg";

        $select = $funcCnx->prepare($cnsPrd);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function insert()
    {
        $funcCnx = $this->conexion();

        $cns_prd = "INSERT INTO producto
        (
            dCrt_prd, nom_prd, img_prd,
            des_prd, fk_ctg_prd, fk_etd_prd
        ) VALUES(
            :dCrt_prd, :nom_prd, :img_prd,
            :des_prd, :fk_ctg_prd, :fk_etd_prd
        )";

        $select = $funcCnx->prepare($cns_prd);
        $select->bindParam(':dCrt_prd', $this->dCrt_prd, PDO::PARAM_STR);
        $select->bindParam(':nom_prd', $this->nom_prd, PDO::PARAM_STR);
        $select->bindParam(':img_prd', $this->img_prd, PDO::PARAM_STR);
        $select->bindParam(':des_prd', $this->des_prd, PDO::PARAM_STR);
        $select->bindParam(':fk_ctg_prd', $this->fk_ctg_prd, PDO::PARAM_INT);
        $select->bindParam(':fk_etd_prd', $this->fk_etd_prd, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function update()
    {
        $funcCnx = $this->conexion();

        $cns_prd = "UPDATE producto SET
        nom_prd = :nom_prd, img_prd = :img_prd, des_prd = :des_prd,
        fk_ctg_prd = :fk_ctg_prd, fk_etd_prd = :fk_etd_prd
        WHERE pk_id_prd = :pk_id_prd";

        $select = $funcCnx->prepare($cns_prd);
        $select->bindParam(':nom_prd', $this->nom_prd, PDO::PARAM_STR);
        $select->bindParam(':img_prd', $this->img_prd, PDO::PARAM_STR);
        $select->bindParam(':des_prd', $this->des_prd, PDO::PARAM_STR);
        $select->bindParam(':fk_ctg_prd', $this->fk_ctg_prd, PDO::PARAM_INT);
        $select->bindParam(':fk_etd_prd', $this->fk_etd_prd, PDO::PARAM_INT);
        $select->bindParam(':pk_id_prd', $this->pk_id_prd, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function trash()
    {
        $funcCnx = $this->conexion();

        $trhPrd = "UPDATE producto SET
        fk_etd_prd = 3
        WHERE pk_id_prd = :pk_id_prd";

        $select = $funcCnx->prepare($trhPrd);
        $select->bindParam(':pk_id_prd', $this->pk_id_prd, PDO::PARAM_INT);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function restore()
    {
        $funcCnx = $this->conexion();

        $rtsPrd = "UPDATE producto SET fk_etd_prd = 2 WHERE pk_id_prd IN ($this->pk_id_prd)";

        $select = $funcCnx->prepare($rtsPrd);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }

    function delete()
    {
        $funcCnx = $this->conexion();

        if (!empty($this->pk_id_prd)) {
            $cns = "pk_id_prd IN ($this->pk_id_prd)";
        } else {
            $cns = "fk_ctg_prd IN ($this->fk_ctg_prd)";
        }

        $cnsPrd = "DELETE FROM producto WHERE $cns";

        $select = $funcCnx->prepare($cnsPrd);

        if (!$select->execute()) {
            throw new Exception('¡Lo sentimos, intenta de nuevo, si sigue el problema, contacta a los desarrolladores LectStudios, posible problema pasivo!');
        }

        return $select;
    }
}
