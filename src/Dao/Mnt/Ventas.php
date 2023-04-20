<?php

namespace Dao\Mnt;

class Ventas extends \Dao\Table
{
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT v.*, u.usuario_nombre FROM Ventas v INNER JOIN usuarios u on v.usuario_id = u.usuario_id WHERE venta_est='ENVIADO';", array());
    }

    public static function getOne($venta_id)
    {
        $sqlstr = "SELECT v.*, u.usuario_nombre FROM Ventas v INNER JOIN usuarios u on v.usuario_id = u.usuario_id WHERE venta_id=:venta_id;";
        return self::obtenerUnRegistro($sqlstr, array("venta_id"=>$venta_id));
    }

    public static function getProductos($venta_id)
    {
        $sqlstr = "SELECT vp.comics_id, comic_nombre, comic_descripcion, comic_precio_venta, ventas_prod_cantidad FROM ventascomics vp INNER JOIN Libros p ON vp.comics_id = p.comics_id WHERE vp.venta_id=:venta_id;";
        return self::obtenerRegistros($sqlstr, array("venta_id"=>$venta_id));
    }

    public static function getTotal($venta_id)
    {
        $sqlstr = "SELECT SUM(ventas_prod_cantidad * ventas_prod_precio_venta) as 'VentaSubtotal', (SUM(ventas_prod_cantidad * ventas_prod_precio_venta)) + (SUM(ventas_prod_cantidad * ventas_prod_precio_venta) * venta_ISV) as 'VentaTotal' FROM ventas v INNER JOIN ventascomics vp ON v.venta_id = vp.venta_id WHERE v.venta_id=:venta_id GROUP BY v.venta_id;";
        return self::obtenerRegistros($sqlstr, array("venta_id"=>$venta_id));
    }

    static public function searchVentas($usuario_busqueda)
    {
        $sqlstr = "SELECT v.*, u.usuario_nombre FROM Ventas v INNER JOIN usuarios u on v.usuario_id = u.usuario_id 
        WHERE venta_id LIKE :usuario_busqueda OR venta_date LIKE :usuario_busqueda OR venta_ISV LIKE :usuario_busqueda 
        OR venta_est LIKE :usuario_busqueda OR venta_tipo_pago LIKE :usuario_busqueda OR venta_pago_envio LIKE :usuario_busqueda 
        OR v.cliente_dir LIKE :usuario_busqueda OR v.cliente_tel LIKE :usuario_busqueda OR usuario_nombre LIKE :usuario_busqueda;";
        
        return self::obtenerRegistros($sqlstr, array("usuario_busqueda"=>"%".$usuario_busqueda."%"));
    }
}
?>
