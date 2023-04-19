<?php

namespace Dao\Mnt;

class Pedidos extends \Dao\Table
{
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT v.*, u.usuario_id FROM Ventas v INNER JOIN usuarios u on v.usuario_id = u.usuario_id WHERE venta_est='PND';", array());
    }
    public static function getOne($venta_id)
    {
        $sqlstr = "SELECT v.*, u.usuario_id FROM Ventas v INNER JOIN usuarios u on v.usuario_id = u.usuario_id WHERE venta_id=:venta_id;";
        return self::obtenerUnRegistro($sqlstr, array("venta_id"=>$venta_id));
    }
    public static function update($venta_id)
    {
        $updsql = "UPDATE ventas SET venta_est = 'ENVIADO' WHERE venta_id=:venta_id;";
        return self::executeNonQuery(
            $updsql,
            array("venta_id" => $venta_id)
        );
    }
    public static function getProductos($venta_id)
    {
        $sqlstr = "SELECT vc.comic:id, comic_nombre, comic_descripcion, comic_precio_venta, ventas_prod_cantidad FROM ventascomics vc INNER JOIN comics c ON vc.comic_id = c.comic_id WHERE vc.venta_id=:venta_id;";
        return self::obtenerRegistros($sqlstr, array("venta_id"=>$venta_id));
    }
    static public function searchPedidos($usuario_busqueda)
    {
        $sqlstr = "SELECT v.*, u.usuario_id FROM ventas v INNER JOIN usuarios u on v.usuario_id = u.usuario_id 
        WHERE venta_id LIKE :usuario_busqueda 
        OR venta_date LIKE :usuario_busqueda 
        OR venta_ISV LIKE :usuario_busqueda 
        OR venta_est LIKE :usuario_busqueda 
        OR v.cliente_tel LIKE :usuario_busqueda 
        OR v.cliente_dir LIKE :usuario_busqueda 
        OR usuario_id LIKE :usuario_busqueda;";
        
        return self::obtenerRegistros($sqlstr, array("UsuarioBusqueda"=>"%".$UsuarioBusqueda."%"));
    }
}
?>