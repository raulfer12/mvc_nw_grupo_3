<?php

namespace Dao\Client;

class Comics extends \Dao\Table
{
    public static function getProductosRecientes()
    {
        return self::obtenerRegistros("SELECT * FROM cosmic_comics.comics p INNER JOIN media m on p.comic_id = m.comic_id WHERE comic_stock > 0 AND comic_est = 'ACT' GROUP BY p.comic_id ORDER BY p.comic_id DESC LIMIT 8;", array());
    }

    public static function getProductCount()
    {
        $sqlstr = "SELECT COUNT(comic_id) as 'Total' FROM cosmic_comics.comics WHERE comic_stock > 0 AND comic_est = 'ACT' ;";
        return self::obtenerUnRegistro($sqlstr, array());
    }

    public static function getProductosforPage($Inicio, $Limite)
    {
        $sqlstr = "SELECT * FROM cosmic_comics.comics p INNER JOIN media m on p.comic_id = m.comic_id WHERE comic_stock > 0 AND comic_est = 'ACT' GROUP BY p.comic_id LIMIT :Inicio, :Limite;"; 
        return self::obtenerRegistrosIntParams($sqlstr, array("Inicio"=>$Inicio, "Limite"=>$Limite));
    }

    public static function getOne($comic_id)
    {
        $sqlstr = "SELECT * FROM cosmic_comics.comics p INNER JOIN media m on p.comic_id = m.comic_id WHERE p.comic_id = :comic_id AND comic_est = 'ACT' GROUP BY p.comic_id;";
        return self::obtenerUnRegistro($sqlstr, array("comic_id"=>$comic_id));
    }

    public static function getAllProductMedia($comic_id)
    {
        $sqlstr = "SELECT * FROM media WHERE comic_id=:comic_id";
        return self::obtenerRegistros($sqlstr, array("comic_id"=>$comic_id));
    }

    static public function searchProductosCliente($usuario_busqueda, $Inicio, $Limite)
    {
        $sqlstr = "SELECT * FROM cosmic_comics.comics p INNER JOIN media m on p.comic_id = m.comic_id WHERE comic_est = 'ACT' AND comic_stock > 0 AND (p.comic_nombre LIKE :usuario_busqueda) GROUP BY p.comic_id LIMIT :Inicio, :Limite;";
        return self::obtenerRegistros($sqlstr, array("usuario_busqueda"=>"%".$usuario_busqueda."%", "Inicio"=>intval($Inicio), "Limite"=>intval($Limite)));
    }

    static public function searchProductosClienteCount($usuario_busqueda)
    {
        $sqlstr = "SELECT COUNT(comic_id) as 'Total' FROM cosmic_comics.comics WHERE comic_stock > 0 AND comic_est = 'ACT' AND (comic_nombre LIKE :usuario_busqueda);";
        
        return self::obtenerUnRegistro($sqlstr, array("usuario_busqueda"=>"%".$usuario_busqueda."%"));
    }
}
?>