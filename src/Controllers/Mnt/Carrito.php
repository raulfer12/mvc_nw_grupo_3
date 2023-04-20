<?php

namespace Controllers;

class Carrito extends \Controllers\PublicController
{
    private $Items = array();
    private $Total = 0.00;
    private $Subtotal = 0.00;

    public function run() :void
    {
        if(!$this->isPostBack()) 
        {
            if(\Utilities\Security::isLogged())
            $this->mostarProductosCarritoUsuario();
        }
        else
        {   
            if(\Utilities\Security::isLogged())
            $this->eliminarProductoCarritoUsuario();
        }

        if(isset($_POST['btnEliminar']))
        {
            if(\Utilities\Security::isLogged())
            $this->eliminarProductoCarritoUsuario();
        }

        $layout = "layout.view.tpl";

        if(\Utilities\Security::isLogged())
        {
            $layout = "privatelayout.view.tpl";
            \Utilities\Nav::setNavContext();
        }

        $allViewData= get_object_vars($this);
        \Views\Renderer::render("carrito", $allViewData, $layout);
    }

    private function mostarProductosCarritoUsuario()
    {
        $usuario_id = \Utilities\Security::getUserId();

        $this->items = \Dao\Client\CarritoUsuario::getProductosCarritoUsuario($usuario_id);

        foreach($this->items as $key => $value)
        {
            $this->items[$key]["comic_precio_venta"] = number_format($value["comic_precio_venta"], 2);
            $this->items[$key]["total_comic"] = number_format($value["total_comic"], 2);

            $precioSinImpuesto = \Utilities\CalculoPrecios::CalcularPrecioSinImpuesto($value["comic_precio_venta"]);

            $this->Items[$key]["prod_precio_sin_impuesto"] = number_format($precioSinImpuesto, 2);
            $this->Items[$key]["prod_impuesto"] = number_format(($value["comic_precio_venta"] - $precioSinImpuesto), 2);
            $this->Subtotal += $precioSinImpuesto;
            $this->Total += $value["total_comic"];
        }

        $this->Subtotal = number_format($this->Subtotal, 2);
        $this->Total = number_format($this->Total, 2);
    }

    private function eliminarProductoCarritoUsuario()
    {
        $usuario_id = \Utilities\Security::getUserId();
        $comic_id = isset($_POST["comic_id"])?$_POST["comic_id"]:"";
        $prod_cantidad = isset($_POST["prod_cantidad"])?$_POST["prod_cantidad"]:"";

        if(!empty($comic_id) && !empty($prod_cantidad))
        {   
            $resultDelete = \Dao\Client\CarritoUsuario::deleteProductoCarritoUsuario($usuario_id, $comic_id);
            $resultUpdate = \Dao\Client\CarritoUsuario::sumarProductoInventarioAnonimo($comic_id, $prod_cantidad);

            if($resultDelete && $resultUpdate)
            {
                \Utilities\Site::redirectToWithMsg("index.php?page=carrito", "Producto Eliminado");
            }
        }
    }
}