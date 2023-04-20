<?php

namespace Controllers\Checkout;

use Controllers\PublicController;
class Accept extends PublicController{
    public function run():void
    {
        $dataview = array();
        $token = $_GET["token"] ?: "";
        $session_token = $_SESSION["orderid"] ?: "";
        if ($token !== "" && $token == $session_token) 
        {
            $result = \Utilities\Paypal\PayPalCapture::captureOrder($session_token);
            $dataview["orderjson"] = json_encode($result, JSON_PRETTY_PRINT);
            $msj = "Transacción realizada con éxito";
        } else 
        {
            $dataview["orderjson"] = "No Order Available!!!";
            $msj = "No hay orden";
        }

         //Cantidad total
         $this->CantidadTotal = $response->result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->gross_amount->value;
         //Comision de Paypal
         $this->ComisionPaypal = $response->result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value;
         //Cantidad Neta
         $this->CantidadNeta = $response->result->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->net_amount->value;
         //Devolución
         $this->LinkDevolucion = $response->result->purchase_units[0]->payments->captures[0]->links[1]->href;
         //Obtener la orden
         $this->LinkOrden = $response->result->purchase_units[0]->payments->captures[0]->links[2]->href;
 
         //Conversión de Moneda
         $this->CantidadTotal = $this->currencyConverter($this->CantidadTotal);
         $this->ComisionPaypal = $this->currencyConverter($this->ComisionPaypal);
         $this->CantidadNeta = $this->currencyConverter($this->CantidadNeta);
 
         //DbOperations
        $this->dbOperations();
        \Utilities\Site::redirectToWithMsg("index.php?page=carrito", $msj);

        \Views\Renderer::render("paypal/accept", $dataview);
    }

    private function dbOperations()
    {
        $usuario_id = \Utilities\Security::getUserId();
        $carrito_usuario = \Dao\Client\Checkout::getProductosCarritoUsuario($usuario_id);
        \Dao\Client\Checkout::insertarVenta($this->LinkDevolucion, $this->LinkOrden, $this->CantidadTotal, $this->ComisionPaypal, $this->CantidadNeta, $_SESSION['login']['DireccionUsuario'], $_SESSION['login']['TelefonoUsuario'], $usuario_id);

        foreach($carrito_usuario as $item)
        {
            \Dao\Client\Checkout::insertarDetalleVenta($item["comic_id"], $item["comic_precio_venta"], $item["comic_precio_venta"]);
        }

        \Dao\Client\Checkout::deleteAllCarritoUsuario($usuario_id);
    }

}
?>
