<?php

namespace Dao\Mnt;

use Dao\Table;

class Rolesusuarios extends Table
{

    public static function getAll()
    {
        $sqlstr = "Select * from rolesusuario;";
        return self::obtenerRegistros($sqlstr, array());
    }
   
    public static function getById(int $rol_id ,int $usuario_id)
    {
        $sqlstr = "SELECT * from rolesusuario where usuario_id=:usuario_id and rol_id = :rol_id;";
        $sqlParams = array("usuario_id" => $usuario_id, "rol_id" => $rol_id);
        return self::obtenerUnRegistro($sqlstr, $sqlParams);
    }


}
