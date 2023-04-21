<?php

namespace Controllers\Mnt;

use Controllers\PublicController;
use Exception;
use Views\Renderer;

class RolUsuario extends PublicController
{
    private $redirectTo = "index.php?page=Mnt-rolesusuarios";
    private $viewData = array(
        "mode" => "DSP",
        "modedsc" => "",
        "usuario_id" => 0,
        "rol_id" => 0,        
        "ventas_prod_cantidad" => 0,
        "ventas_prod_precio_venta" => 0,        
        "general_errors" => array(),
        "has_errors" => false,
        "show_action" => true,
        "readonly" => false,        
    );

    private $modes = array(
        "DSP" => "Detalle de %s (%s)"        
    );
    public function run(): void
    {
        try {
            $this->page_loaded();            
            $this->render();
            
        } catch (Exception $error) {

            error_log(sprintf("Controller/Mnt/Rolusuario ERROR: %s", $error->getMessage()));
            \Utilities\Site::redirectToWithMsg(
                $this->redirectTo,
                "Algo Inesperado Sucedió. Intente de Nuevo."
            );
        }
        /*
        1) Captura de Valores Iniciales QueryParams -> Parámetros de Query ? 
            https://ax.ex.com/index.php?page=abc&mode=UPD&id=1029
        2) Determinamos el método POST GET
        3) Procesar la Entrada
            3.1) Si es un POST
            3.2) Capturar y Validara datos del formulario
            3.3) Según el modo realizar la acción solicitada
            3.4) Notificar Error si hay
            3.5) Redirigir a la Lista
            4.1) Si es un GET
            4.2) Obtener valores de la DB sin no es INS
            4.3) Mostrar Valores
        4) Renderizar
        */
    }

    private function page_loaded()
    {
        if (isset($_GET['mode'])) {
            if (isset($this->modes[$_GET['mode']])) {
                $this->viewData["mode"] = $_GET['mode'];
            } else {
                throw new Exception("Mode Not available");
            }
        } else {
            throw new Exception("Mode not defined on Query Params");
        }
        if ($this->viewData["mode"] !== "INS") {
            if (isset($_GET['rol_id'])) {
                $this->viewData["rol_id"] = intval($_GET["rol_id"]);
                $this->viewData["usuario_id"] = intval($_GET["usuario_id"]);
            } else {
                throw new Exception("Id not found on Query Params");
            }
        }
    }
    
    private function render()
    {

        
            $tmpCategorias = \Dao\Mnt\Rolesusuarios::getById($this->viewData["rol_id"],$this->viewData["usuario_id"]);
            if (!$tmpCategorias) {
                throw new Exception("Rolusuario no existe en DB");
            }

            \Utilities\ArrUtils::mergeFullArrayTo($tmpCategorias, $this->viewData);

            $this->viewData["modedsc"] = sprintf(
                $this->modes[$this->viewData["mode"]],                
                $this->viewData["rol_id"] ,
                $this->viewData["usuario_id"] ,
                $this->viewData["rol_usuario_est"] 
                
                
            );
            
            
                $this->viewData["readonly"] = "readonly";
            
            if ($this->viewData["mode"] === "DSP") {
                $this->viewData["show_action"] = false;            
        }

        Renderer::render("mnt/rolusuario", $this->viewData);
    }
}
