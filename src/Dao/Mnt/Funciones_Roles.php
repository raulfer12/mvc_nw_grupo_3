<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class Funciones_Roles extends Table{
        public static function getAll(){
            return self::obtenerRegistros("SELECT * FROM FUNCIONESROLES;",array());
        }

        public static function getById(int $rol_id){
            return self::obtenerUnRegistro(
                "SELECT * FROM FUNCIONESROLES WHERE rol_id=:rol_id;",
                array("rol_id"=>$rol_id)
            );
        }

        public static function insert(
            string $funcion_id,
            string $funcion_rol_est,
            string $funcion_exp,
        ){
            $ins_sql="INSERT INTO `funcionesroles`
            (
            `funcion_exp`,
            `funcion_rol_est`,
            `funcion_id`,
            `created_at`)
            VALUES
            (
            :funcion_exp,
            :funcion_rol_est,
            :funcion_id,
            now());";

            return self::executeNonQuery(
                $ins_sql,
                array(
                    ":funcion_exp"=>$funcion_exp,
                    ":funcion_rol_est"=>$funcion_rol_est,
                    ":funcion_id"=>$funcion_id
                )
            );
        }

        public static function update(
            string $funcion_id,
            string $funcion_rol_est,
            string $funcion_exp,
            int $rol_id
        ){
            $ins_sql= "UPDATE `funcionesroles`
            SET
            `funcion_exp` = :funcion_exp,
            `funcion_rol_est` = :funcion_rol_est,
            `funcion_id` = :funcion_id,
            WHERE `rol_id` = :rol_id;"
            return self::executeNonQuery(
                $ins_sql,
                array(
                    ":funcion_exp"=>$funcion_exp,
                    ":funcion_rol_est"=>$funcion_rol_est,
                    ":funcion_id"=>$funcion_id
                    ":rol_id"=>$rol_id
                )
            );
        }

        public static function delete(
            int $rol_id
        ){
            $ins_sql = "DELETE from funcionesroles where rol_id=:rol_id;";
            return self::executeNonQuery(
                $ins_sql,
                array("rol_id"=>$rol_id)
            );
        }
    }
?>