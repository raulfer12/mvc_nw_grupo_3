<?php

namespace Controllers\Sec;

use Controllers\PublicController;
use \Utilities\Validators;
use Exception;

class Register extends PublicController
{
    private $txtNombre = "";
    private $txtEmail = "";
    private $txtPswd = "";
    private $errorNombre = "";
    private $errorEmail ="";
    private $errorPswd = "";
    private $hasErrors = false;
    public function run() :void
    {

        if ($this->isPostBack()) {
            $this->txtEmail = $_POST["txtEmail"];
            $this->txtPswd = $_POST["txtPswd"];
            //validaciones

            if (!(Validators::isLetter($this->txtNombre))) {
                $this->errorNombre = "El nombre solo puede llevar letras.";
                $this->hasErrors = true;
            }
            if ((Validators::IsEmpty($this->txtNombre))) {
                $this->errorNombre = "Debe escribir su nombre.";
                $this->hasErrors = true;
            }

            if (!(Validators::IsValidEmail($this->txtEmail))) {
                $this->errorEmail = "El correo no tiene el formato adecuado";
                $this->hasErrors = true;
            }
            if ((Validators::IsEmpty($this->txtEmail))) {
                $this->errorEmail = "Debe escribir su correo electrónico.";
                $this->hasErrors = true;
            }

            if (!Validators::IsValidPassword($this->txtPswd)) {
                $this->errorPswd = "La contraseña debe tener al menos 8 caracteres una mayúscula, un número y un caracter especial.";
                $this->hasErrors = true;
            }

            if(!empty(\Dao\Security\Security::getUsuarioByEmail($this->txtEmail)))
            {
                $this->errorGeneral = "Ya existe un usuario registrado con este correo";
                $this->hasErrors = true;
            }

            if (!$this->hasErrors) {
                try{
                    if (\Dao\Security\Security::newUsuarioAdmin($this->txtEmail, $this->txtPswd)) {
                        \Utilities\Site::redirectToWithMsg("index.php?page=sec_login", "Usuario Registrado");
                    }
                } catch (Error $ex){
                    die($ex);
                }
            }
        }
        $viewData = get_object_vars($this);
        \Views\Renderer::render("security/sigin", $viewData);
    }
}
?>
