<?php
class Cfg_conexion {
    public static function func_conexion() {
        try {
            $conexion = new PDO('mysql:host=localhost; dbname=bdbotiquines; charset=utf8', 'root', '');
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conexion;
        } catch (Exception $e) {
            die("error: ".$e->getMessage());
            return false;
        }
    }
}