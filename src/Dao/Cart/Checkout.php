<?php

namespace Dao\Client;

class Checkout extends \Dao\Table
{

    public static function insertarVenta($venta_link_devolucion, $venta_link_orden, $venta_cantidad_total, $venta_comision_Paypal, $venta_cantidad_neta, $cliente_tel, $cliente_dir, $usuario_id)
    {
        $insstr = "INSERT INTO ventas VALUES 
        (
            0, 
            NOW(), 
            0.15, 
            'PND', 
            :venta_link_devolucion, 
            :venta_link_orden, 
            :venta_cantidad_total, 
            :venta_comision_Paypal, 
            :venta_cantidad_neta, 
            :cliente_tel,
            :cliente_dir,  
            :usuario_id
        );";

        return self::executeNonQuery
        (
            $insstr, 
            array(
                "venta_link_devolucion"=>$venta_link_devolucion, 
                "venta_link_orden"=>$venta_link_orden, 
                "venta_cantidad_total"=>$venta_cantidad_total, 
                "venta_comision_Paypal"=>$venta_comision_Paypal,
                "venta_cantidad_neta"=>$venta_cantidad_neta,
                "cliente_tel"=>$cliente_tel,
                "cliente_dir"=>$cliente_dir,
                "usuario_id"=>intval($usuario_id)
            )
        );
    }

    public static function insertarDetalleVenta($comic_id, $ventas_prod_cantidad, $ventas_prod_precio_venta)
    {
        $venta_id = self::obtenerUnRegistro("Select max(venta_id) as venta_id from ventas;", array());
        $venta_id = $venta_id["venta_id"];
        $insstr = "INSERT INTO ventascomics VALUES (:comic_id, :venta_id, :ventas_prod_cantidad, :ventas_prod_precio_venta);";
        return self::executeNonQuery($insstr, array("comic_id"=>intval($comic_id), "venta_id"=>intval($venta_id), "ventas_prod_cantidad"=>intval($ventas_prod_cantidad), "ventas_prod_precio_venta"=>floatval($ventas_prod_precio_venta)));
    }

    public static function deleteAllCarritoUsuario($usuario_id)
    {
        $delsql = "DELETE FROM carritocompra WHERE usuario_id = :usuario_id;";
        return self::executeNonQuery($delsql, array("usuario_id" => $usuario_id));
    }

    public static function getProductosCarritoUsuario($usuario_id)
    {
        $sqlstr = "SELECT cr.*, p.comic_nombre, (cr.prod_cantidad * cr.comic_precio_venta) as 'total_producto', m.media_doc, m.media_path FROM carritocompra cr INNER JOIN comics p on cr.comic_id = p.comic_id INNER JOIN media m on m.comic_id = p.comic_id WHERE usuario_id = :usuario_id GROUP BY cr.comic_id;"; 
        return self::obtenerRegistros($sqlstr, array("usuario_id"=>intval($usuario_id)));
    }
}
?>