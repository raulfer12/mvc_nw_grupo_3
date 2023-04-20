<?php

namespace Controllers\Checkout;

use Controllers\PublicController;

class Checkout extends PublicController{
    public function run():void
    {
        $viewData = array();
        if ($this->isPostBack()) {
            $PayPalOrder = new \Utilities\Paypal\PayPalOrder(
                "test".(time() - 10000000),
                "http://localhost/mvc_nw_grupo_3/index.php?page=checkout_error",
                "http://localhost/mvc_nw_grupo_3/index.php?page=checkout_accept"
            );
            $usuario_id = \Utilities\Security::getUserId();
            $items = \Dao\Client\CarritoUsuario::getProductosCarritoUsuario($usuario_id);

            foreach($items as $key => $value)
            {
                $precio_sin_impuesto = \Utilities\CalculoPrecios::CalcularPrecioSinImpuesto($value["comic_precio_venta"]);

                $items[$key]["prod_precio_sin_impuesto"] = round($precio_sin_impuesto, 2);
                $items[$key]["prod_impuesto"] = round(($value["comic_precio_venta"] - $precio_sin_impuesto), 2);
            }

            foreach($items as $item)
            {
                $PayPalOrder->addItem(strval($item["comic_nombre"]), substr($item["comic_nombre"], 0, 20), strval($item["comic_id"]), $item["prod_precio_sin_impuesto"], $item["prod_impuesto"], $item["prod_cantidad"], "PHYSICAL_GOODS");
            }
           
            $response = $PayPalOrder->createOrder();
            $_SESSION["orderid"] = $response[1]->result->id;
            \Utilities\Site::redirectTo($response[0]->href);
            die();
        }

        \Views\Renderer::render("paypal/checkout", $viewData);
    }
}
?>
