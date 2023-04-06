<?php
    namespace Dao\Mnt;

    use Dao\Table;

    class comics extends Table{
        public static function getAll(){
            return self::obtenerRegistros("SELECT * FROM comics;",array());
        }

        public static function getById(int $rol_id){
            return self::obtenerUnRegistro(
                "SELECT * FROM comics  WHERE comic_id =: comic_id ;",
                array("comic_id"=>$comic_id)
            );
        }

        public static function insert(
            string $comic_est,
            string $comic_nombre,
            string $comic_descripcion,
            float  $comic_precio_venta,
            float  $comic_precio_compra,
            int  $comic_stock

           
        ){
            $ins_sql="INSERT INTO `comics`
            (
            `comic_nombre`,
            `comic_est`,
            `comic_descripcion`,
            `comic_precio_venta`,
            `comic_precio_compra`,
            `comic_stock`,
            `created_at`)
            VALUES
            (
             :comic_nombre,
            :comic_est,
            :comic_descripcion,
            :comic_precio_venta,
            :comic_precio_compra,
            :comic_stock,
            now());";

            return self::executeNonQuery(
                $ins_sql,
                array(
                    "comic_nombre"=> $comic_nombre,
                    "comic_est"=> $comic_est,
                    "comic_descripcion" => $comic_descripcion,
                    "comic_precio_venta"=> $comic_precio_venta,
                    "comic_precio_compra"=> $comic_precio_compra,
                    "comic_stock"=> $comic_stock
                )
            );
        }
        public static function update(
            string $comic_est,
            string $comic_nombre,
            string $comic_descripcion,
            float  $comic_precio_venta,
            float  $comic_precio_compra,
            int  $comic_stock,
            int  $comic_id

        ){
            $upd_sql= "UPDATE `comics`
            SET
            `comic_nombre` = :comic_nombre,
            `comic_est` = :comic_est,
            `comic_descripcion` = :comic_descripcion,
            `comic_precio_venta`=:comic_precio_venta,
            `comic_precio_compra`=:comic_precio_compra,
            `comic_stock`=:comic_stock
            
            WHERE `comic_id` = comic_id;"
            return self::executeNonQuery(
                $upd_sql,
                array(
                    ":funcion_exp"=>$funcion_exp,
                    ":funcion_rol_est"=>$funcion_rol_est,
                    ":funcion_id"=>$funcion_id
                    ":rol_id"=>$rol_id
                )
            );
        }

        public static function delete(
            int $comic_id
        ){
            $ins_sql = "DELETE from comics where comic_id=:comic_id;";
            return self::executeNonQuery(
                $del_sql,
                array("rol_id"=>$comic_id)
            );
        }
    }
?>