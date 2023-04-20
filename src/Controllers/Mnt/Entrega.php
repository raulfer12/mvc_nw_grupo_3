<?php

namespace Controllers;

class DireccionEntrega extends PublicController
{

    private $DireccionDepartamento = "";
    private $DireccionCiudad = "";
    private $Direccion = "";
    private $NumeroTelefonoCelular = "";

    private $hasErrors = false;
    private $aErrors = array();

    public function run() :void
    {

        $usuario_id = \Utilities\Security::getUserId();
        $getProductos = \Dao\Client\CarritoUsuario::getProductosCarritoUsuario($usuario_id);

        if($this->isPostBack())
        {
            $this->_loadPostData();
        }

        if(empty($usuario_id))
        {
            \Utilities\Site::redirectToWithMsg("index.php?page=sec_login", "Es necesario iniciar sesión para continuar");
        }
        else
        {
            if(!empty($getProductos))
            {
                $dataview = get_object_vars($this);
                \Utilities\Nav::setNavContext();
                \Views\Renderer::render("direccionentrega", $dataview, "privatelayout.view.tpl");
            }
            else
            {   
                \Utilities\Site::redirectToWithMsg("index.php?page=catalogoproductos&PageIndex=1", "No tiene productos en el carrito");
            }
        }
    }

    private function _loadPostData()
    {
        $this->DireccionDepartamento = isset($_POST["DireccionDepartamento"]) ? $_POST["DireccionDepartamento"] : "";
        $this->DireccionCiudad = isset($_POST["DireccionCiudad"]) ? $_POST["DireccionCiudad"] : "";
        $this->Direccion = isset($_POST["Direccion"]) ? $_POST["Direccion"] : "";
        $this->NumeroTelefonoCelular = isset($_POST["NumeroTelefonoCelular"]) ? $_POST["NumeroTelefonoCelular"] : "";

        if (\Utilities\Validators::IsEmpty($this->DireccionDepartamento)) 
        {
            $this->aErrors[] = "El departamento no puede ir vacío";
        }

        if (!\Utilities\Validators::isLetter($this->DireccionDepartamento)) 
        {
            $this->aErrors[] = "El departamento ingresado no es válido";
        }

        if (\Utilities\Validators::IsEmpty($this->DireccionCiudad)) 
        {
            $this->aErrors[] = "La ciudad no puede ir vacía";
        }

        if (!\Utilities\Validators::isLetter($this->DireccionCiudad)) 
        {
            $this->aErrors[] = "La ciudad ingresada no es válida";
        }

        if (\Utilities\Validators::IsEmpty($this->Direccion1)) 
        {
            $this->aErrors[] = "La dirección 1 no puede ir vacía";
        }

        if (\Utilities\Validators::IsEmpty($this->NumeroTelefonoCelular)) 
        {
            $this->aErrors[] = "El télefono o celular no puede ir vacío";
        }

        if (!\Utilities\Validators::ValidarNumeros($this->NumeroTelefonoCelular)) 
        {
            $this->aErrors[] = "El número de télefono o celular no es válido";
        }

        $this->hasErrors = (count($this->aErrors) > 0);

        if(!$this->hasErrors)
        {   
            $direccion = $this->DireccionDepartamento . ", " . $this->DireccionCiudad . ", " . $this->Direccion1 . ", " . $this->Direccion2;  

            $_SESSION["login"]["DireccionUsuario"] = $direccion;
            $_SESSION["login"]["TelefonoUsuario"] = $this->NumeroTelefonoCelular;

            \Utilities\Site::redirectToWithMsg("index.php?page=checkout_checkout", "Información para entrega guardada");
        }
    }
}
?>