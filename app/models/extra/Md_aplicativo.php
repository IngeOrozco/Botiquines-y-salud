<?php
require_once('app/config/Cfg_conexion.php');

class Md_aplicativo extends Cfg_conexion {
    function conexion() {
        $Obj_cnx = new Cfg_conexion();
        return $Obj_cnx->func_conexion();
    }
}