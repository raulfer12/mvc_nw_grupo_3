<?php
    namespace Controllers;

    use Controllers\PrivateController;
    use Exception;
    use Views\Renderer;

    class Journal extends PrivateController{
        private $redirectTo:"index.php?page=Mnt-Journals";
        private $viewData = array(
            "mode"=> "DSP",
            "modedsc"=>"",
            "rol_id"=>"",
            "funcion_id"=>"",
            "funcion_rol_est"=>"ACT",
            "funcion_rol_est_ACT"=>"selected",
            "funcion_rol_est_INA"=>"",
            "funcion_exp"=>"",
            "general_errors"=>array(),
            "has_errors"=>false,
            "show_action"=>true,
            "readonly"=>false,
            "xssToken"=>""
        );
        private $modes = array(
            "DSP"=>"Detalle de %s (%s)",
            "INS"=>"Nueva Funcion_Rol",
            "UPD"=>"Editar %s (%s)",
            "DEL"=>"Borrar %s (%s)",
        );
        private $modesAuth=array(
            "DSP"=>"funciones_roles_view",
            "INS"=>"funciones_roles_new",
            "UPD"=>"funciones_roles_edit",
            "DEL"=>"funciones_roles_delete",
        )
        public function run() :void
        {
            try{
            $this->page_loaded();
            if($this->isPostBack()){
                $this->validatePostData();
                if($this->viewData["has_errors"]){
                    $this->executeAction();
                }
            }
            $this->render();
            } catch(Exception $error) {
                unset($_SESSION["xssToken_Mnt_Funcion_Rol"]);
                error_log(sprintf("Controllers/Mnt/Funcion_Rol ERROR: %s", $error->getMessage));
                \Utilities\Sites::redirectToWithMsg(
                    $redirectTo,
                    "Algo Inesperado Sucedió. Intente de Nuevo"
                )
            }

        }
        private function page_loaded()
        {
            if(isset($_GET['mode'])){
                if(isset($this->modes[$_GET['mode']])){
                    if($this->isFeatureAuthorized($this->modesAuth[$_Get['mode']])){
                        throw new Exception("Mode is not Authorized");
                    }
                    $this->viewData["mode"] = $_Get['mode'];
                } else{
                    throw "Mode Not available";
                }
            } else{
                throw "Mode Not Defined on Query Params"
            }
            if($this->viewData["mode"] !== "INS"){
            if(isset($_GET('rol_id'))){
                $this->viewData["rol_id"] = strval($_Get["rol_id"]);
            }
        }
        }
        private function validatePostData(){
            if(isset($_POST["xssToken"])){
                if(isset($_SESSION["xssToken_Mnt_Funcion_Rol"])){
                    if($_POST["xssToken"]!==$_SESSION["xssToken_Mnt_Funcion_Rol"]){
                        throw new Exception("Invalid Xss Token no match");
                    }
                } else {
                    throw new Exception("Invalid Xss Token on Session");
                }
            }else{
                throw new Exception("Invalid Xss Token");
            }
            if(isset($_POST["funcion_id"])){
                if(\Utilities\Validators::IsEmpty($_POST["funcion_id"])){
                    $this->viewData["has_errors"]= true;
                }

            } else{
                throw new Exception{"Funcion Id not presented in form"};
            }
            if(isset($_POST["funcion_rol_est"])){
                if(!in_array($_POST["funcion_rol_est"],array("ACT","INA"))){
                    throw new Exception{"funcion_rol_est Inncorrect Value"};    
                }
            }else{
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("funcion_rol_est not present in form");
                }
            }
            
            if(isset($_POST["funcion_exp"])){
                if(\Utilities\Validators::IsEmpty($_POST["funcion_exp"])){
                    throw new Exception{"funcion_exp Inncorrect Value"};    
                }
            }else{
                throw new Exception("funcion_exp not present in form");
            }
            if(isset($_POST["mode"])){
                if(!key_exists($_POST["mode"], $this->modes)){
                    throw new Exception{"Mode has a bad value"};
                }
                if($this->viewData["mode"]!==$_POST["mode"]){
                    throw new Exception{"Mode value is diffrent from query"};
                }                
            }else{
                throw new Exception{"Mode not presented in form"};
            }
            if(isset($_POST["rol_id"])){
                if(\Utilities\Validators::IsEmpty($_POST["rol_id"])){
                    $this->viewData["has_errors"]= true;
                }

            } else{
                throw new Exception{"Rol Id not presented in form"};
            }
            $tmpPostData=array(
                "funcion_exp"=>$_POST["funcion_exp"],
                    "funcion_id"=>$_POST["funcion_id"],
            );
            \Utilities\ArrUtils::mergeFullArrayTo(
                $tmpPostData,
                $this->viewData
            );
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["funcion_rol_est"] = $_POST["funcion_rol_est"];
            }
        }
        private function executeAction(){
            switch($this->viewData["mode"]){
                case "INS":
                    $inserted=\Dao\Mnt\Journals::insert(
                        $this->viewData["funcion_id"],
                        $this->viewData["funcion_rol_est"],
                        $this->viewData["funcion_exp"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Funcion por Rol Creado Exitosamente"                        
                        );
                    }
                    break;
                case "UPD":
                    $updated=\Dao\Mnt\Journals::insert(
                        $this->viewData["funcion_id"],
                        $this->viewData["funcion_rol_est"],
                        $this->viewData["funcion_exp"],
                        $this->viewData["rol_id"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Funcion por Rol Actualizado Exitosamente"                        
                        );
                    }
                    break;
                case "DEL":
                    $deleted=\Dao\Mnt\Journals::insert(
                        $this->viewData["rol_id"]
                    );
                    if($deleted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "Funcion por Rol Eliminado Exitosamente"                        
                        );
                    }
                    break;
            }
        }
        private function render(){
            $xssToken=md5("FUNCUON_ROL". rand(0,4000)*rand(5000*9999));
            $this->viewData["xssToken"]=$xssToken;
            $_SESSION["xssToken_Mnt_Funcion_Rol"]=$xssToken;
            if($this->viewData["mode"] === "INS") {
                $this->viewData["modedsc"] = $this->modes["INS"];
            } else {
                $tmpFunciones_Roles = \Dao\Mnt\Funciones_Roles::getById($this->viewData["rol_id"]);
                if(!$tmpFunciones_Roles){
                    throw new Exception("Funcion por Rol no existe en DB");
                }
                \Utilities\ArrUtils::mergeFullArrayTo($tmpFunciones_Roles, $this->viewData);
                $this->viewData["funcion_rol_est_ACT"] = $this->viewData["funcion_rol_est"] === "ACT" ? "selected": "";
                $this->viewData["funcion_rol_est_INA"] = $this->viewData["funcion_rol_est"] === "INA" ? "selected": "";
                $this->viewData["modedsc"] = sprintf(
                    $this->modes[$this->viewData["mode"]],
                    $this->viewData["funcion_exp"],
                    $this->viewData["rol_id"]
                );
                if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                    $this->viewData["readonly"] = "readonly";
                }
                if($this->viewData["mode"] === "DSP") {
                    $this->viewData["show_action"] = false;
                }
            }
            Renderer::render("mnt/funcion_rol", $this->viewData);
    }
}
?>