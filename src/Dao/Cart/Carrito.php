<?php

namespace Dao\Client;

class CarritoUsuario extends \Dao\Table
{
    public static function comprobarProductoEnCarritoUsuario($usuario_id, $comic_id)
    {
        $sqlstr = "SELECT * FROM carritocompraclienteregistrado WHERE usuario_id = :usuario_id AND comic_id = :comic_id;";
        return self::obtenerUnRegistro($sqlstr, array("usuario_id"=>intval($usuario_id), "comic_id"=>$comic_id));
    }

    public static function insertarProductoCarritoUsuario($usuario_id, $comic_id, $prod_cantidad, $prod_precio_venta)
    {
        $insstr = "INSERT INTO carritocompraclienteregistrado VALUES (:usuario_id, :comic_id, :prod_cantidad, :prod_precio_venta, NOW())";
        return self::executeNonQuery($insstr, array("usuario_id"=>intval($usuario_id), "comic_id"=>$comic_id, "prod_cantidad"=>$prod_cantidad, "prod_precio_venta"=>$prod_precio_venta));
    }

    public static function sumarProductoInventarioAnonimo($comic_id, $prod_cantidad)
    {
        $updstr = "UPDATE comics SET comic_stock = comic_stock + :prod_cantidad WHERE comic_id = :comic_id";
        return self::executeNonQuery($updstr, array("comic_id"=>intval($comic_id), "prod_cantidad"=>$prod_cantidad));
    }

    public static function restarProductoInventarioUsuario($comic_id, $prod_cantidad)
    {
        $updstr = "UPDATE comics SET comic_stock = comic_stock - :prod_cantidad WHERE comic_id = :comic_id";
        return self::executeNonQuery($updstr, array("comic_id"=>intval($comic_id), "prod_cantidad"=>$prod_cantidad));
    }

    public static function deleteProductoCarritoUsuario($usuario_id, $comic_id)
    {
        $delsql = "DELETE FROM carritocompraclienteregistrado WHERE usuario_id = :usuario_id AND comic_id = :comic_id;";
        return self::executeNonQuery(
            $delsql,
            array("usuario_id" => intval($usuario_id), "comic_id"=>intval($comic_id))
        );
    }

    public static function getProductosCarritoUsuario($usuario_id)
    {
        $sqlstr = "SELECT cr.*, p.comic_nombre, (cr.prod_cantidad * cr.comic_precio_venta) as 'total_comic',
            m.media_doc, m.media_path 
            FROM cosmic_comics.carritocompra cr 
            INNER JOIN cosmic_comics.comics p on cr.comic_id = p.comic_id 
            INNER JOIN cosmic_comics.media m on m.comic_id = p.comic_id 
            WHERE usuario_id = :usuario_id
            GROUP BY cr.comic_id;";
        $sqlParams=[
            "usuario_id" => $usuario_id
        ];
        return self::obtenerRegistros($sqlstr, $sqlParams);
    }

    public static function getTotalCarrito($usuario_id)
    {
        $sqlstr = "SELECT SUM(cr.prod_cantidad * cr.comic_precio_venta) as 'Total' FROM carritocompra cr INNER JOIN comics p on cr.comic_id = p.comic_id WHERE usuario_id = :usuario_id"; 
        return self::obtenerUnRegistro($sqlstr, array("usuario_id"=>intval($usuario_id)));
    }
}
?>