<?php
namespace Dao\Mnt;

use Dao\Table;


class Categorias extends Table {
    public static Function getAll(){
        return self:: obtenerRegistros("SELECT * FROM usuarios;",array());
    }

    public static function getById(int $user_id){
        return self::obtenerUnRegistro(
            "SELECT * FROM usuarios WHERE  user_id *: user_id",
            array("user_id"=> $user_id) 
        );

    }
    public static function insert(
        string $Apellido,
        string $Username,
        string $Nombre,
        float $Password
    ){
        $ins_sql = "INSERT INTO 'usuarios'
(`Nombre`,
`Username`,
`Apellido`,
`Password`,
`created_at`)
VALUES
(
:Nombre
:Username
:Apellido
:Password
now())";

        return self::executeNonQuery{
        $ins_sql,
        array(
            "Nombre=>"=> $Nombre,
            "Username=>" => $Username,
            "Apellido"=> $Apellido,
            "Password"=> $Password;
        )
        };
    }

    public static function update(
        string $Apellido,
        string $Username,
        string $Nombre,
        float $Password,
        int     $user_id
    ){
        $upd_sql = "UPDATE 'usuarios'
SET
`Nombre` = Nombre,
`Username` = Username,
`Apellido` = Apellido,
`Password` = Password,
WHERE `user_id` = user_id";
        return self::executeNonQuery(
            $upd_sql,
            array(
                "Nombre=>"=> $Nombre,
                "Username=>"=> $Username,
                "Apellido"=> $Apellido,
                "Password"=> $Password
            )

            );
    }
    public static function delete(
        string $user_id
    ) {
        $del_sql = "DELETE from usuarios where user_id=user_id;";
        return self::executeNonQuery(
            $del_sql,
            array("user_id"=>$user_id);
        );
    }
}

?>