<?php
    namespace Controllers;

    use Controllers\PrivateController;
    use Exception;
    use Views\Renderer;

    class comic extends PrivateController{
        private $redirectTo:"index.php?page=Mnt-comic";
        private $viewData = array(
            "mode"=> "DSP",
            "modedsc"=>"",
            "comic_id"=>"",
            "comic_nombre"=>"",
            "comic_descripcion"=>"",
            "comic_precio_venta"=>0,
            "comic_precio_compra"=>0,
            "comic_est"=>"ACT",
            "comic_est_ACT"=>"selected",
            "comic_est_INA"=>"",
           "comic_stock"=>0,
            "general_errors"=>array(),
            "has_errors"=>false,
            "show_action"=>true,
            "readonly"=>false,
            "xssToken"=>""
        );
        private $modes = array(
            "DSP"=>"Detalle de %s (%s)",
            "INS"=>"Nuevo comic",
            "UPD"=>"Editar %s (%s)",
            "DEL"=>"Borrar %s (%s)",
        );
        private $modesAuth=array(
            "DSP"=>"comics_view",
            "INS"=>"comics_new",
            "UPD"=>"comics_edit",
            "DEL"=>"comics_delete",
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
                unset($_SESSION["xssToken_Mnt_comic"]);
                error_log(sprintf("Controllers/Mnt/comic ERROR: %s", $error->getMessage));
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
            if(isset($_GET('comic_id'))){
                $this->viewData["comic_id"] = strval($_Get["comic_id"]);
            }
        }
        
        }
        private function validatePostData(){
            if(isset($_POST["xssToken"])){
                if(isset($_SESSION["xssToken_Mnt_comic"])){
                    if($_POST["xssToken"]!==$_SESSION["xssToken_Mnt_comic"]){
                        throw new Exception("Invalid Xss Token no match");
                    }
                } else {
                    throw new Exception("Invalid Xss Token on Session");
                }
            }else{
                throw new Exception("Invalid Xss Token");
            }
        
            if(isset($_POST["comic_nombre"])){
                if(\Utilities\Validators::IsEmpty($_POST["comic_nombre"])){
                    $this->viewData["has_errors"] = true;
                    $this->viewData["comic_error"] = "El nombre no puede ir vacío!";
                }
            } else {
                throw new Exception("comic_nombre not present in form");
            }

            if(isset($_POST["comic_descripciom"])){
                if(\Utilities\Validators::IsEmpty($_POST["comic_descricion"])){
                    $this->viewData["has_errors"] = true;
                    $this->viewData["comic_error"] = "La descripcion no puede ir vacío!";
                }
            } else {
                throw new Exception("comic_descripcion not present in form");
            }
            if(isset($_POST["comic_precio_venta"])){
                if(\Utilities\Validators::IsEmpty($_POST["catnom"])){
                    $this->viewData["has_errors"] = true;
                    $this->viewData["comic_precio_venta_error"] = "El precio no puede ir vacío!";
                }
            } else {
                throw new Exception("comic_precio_venta not present in form");
            }
            if(isset($_POST["comic_precio_compra"])){
                if(\Utilities\Validators::IsEmpty($_POST["catnom"])){
                    $this->viewData["has_errors"] = true;
                    $this->viewData["comic_precio_compra_error"] = "El precio no puede ir vacío!";
                }
            } else {
                throw new Exception("comic_precio_compra not present in form");
            }
            if(isset($_POST["comic_est"])){
                if(!in_array($_POST["comic_est"],array("ACT","INA"))){
                    throw new Exception{"comic_est Inncorrect Value"};    
                }
            }else{
                if($this->viewData["mode"]!=="DEL") {
                    throw new Exception("comic_est not present in form");
                }
            }
        }
            
            if(isset($_POST["comic_stock"])){
                if(\Utilities\Validators::IsEmpty($_POST["comic_stock"])){
                    throw new Exception{"comic_stock Inncorrect Value"};    
                }
            }else{
                throw new Exception("comic_stock not present in form");
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
            if(isset($_POST["comic_id"])){
                if(\Utilities\Validators::IsEmpty($_POST["comic_id"])){
           
            $tmpPostData=array(
                
                    "comic_id"=>$_POST["comic_id"],
            );
            \Utilities\ArrUtils::mergeFullArrayTo(
                $tmpPostData,
                $this->viewData
            );
            if($this->viewData["mode"]!=="DEL"){
                $this->viewData["comic_est"] = $_POST["comic_est"];
            }
        }
        }
        private function executeAction(){
            switch($this->viewData["mode"]){
                case "INS":
                    $inserted=\Dao\Mnt\comic::insert(
                        $this->viewData["comic_nombre"],
                        $this->viewData["comic_descripcion"],
                        $this->viewData["comic_est"],
                        $this->viewData["comic_precio_venta"],
                        $this->viewData["comic_precio_compra"],
                        $this->viewData["comic_stock"]
                    );
                    if($inserted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "comic Creado Exitosamente"                        
                        );
                    }
                    break;
                case "UPD":
                    $updated=\Dao\Mnt\comic::insert(
                        $this->viewData["comic_nombre"],
                        $this->viewData["comic_descripcion"],
                        $this->viewData["comic_est"],
                        $this->viewData["comic_precio_venta"],
                        $this->viewData["comic_precio_compra"],
                        $this->viewData["comic_id  "],
                        $this->viewData["comic_stock"]
                    );
                    if($updated>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "comic Actualizado Exitosamente"                        
                        );
                    }
                    break;
                case "DEL":
                    $deleted=\Dao\Mnt\comics::insert(
                        $this->viewData["comic_id"]
                    );
                    if($deleted>0){
                        \Utilities\Site::redirectToWithMsg(
                            $this->redirecTo,
                            "comic Eliminado Exitosamente"                        
                        );
                    }
                    break;
            }
        }
        private function render(){
            $xssToken=md5("comic". rand(0,4000)*rand(5000*9999));
            $this->viewData["xssToken"]=$xssToken;
            $_SESSION["xssToken_Mnt_comic"]=$xssToken;
            if($this->viewData["mode"] === "INS") {
                $this->viewData["modedsc"] = $this->modes["INS"];
            } else {
                $tmpFunciones_Roles = \Dao\Mnt\comics::getById($this->viewData["rol_id"]);
                if(!$tmpcomics){
                    throw new Exception("comic no existe en DB");
                \Utilities\ArrUtils::mergeFullArrayTo($tmpcomics, $this->viewData);
                $this->viewData["comic_est_ACT"] = $this->viewData["comic_est"] === "ACT" ? "selected": "";
                $this->viewData["comic_est_INA"] = $this->viewData["comic_est"] === "INA" ? "selected": "";
                $this->viewData["modedsc"] = sprintf(
                    $this->modes[$this->viewData["mode"]],
                
                    $this->viewData["comic_id"]
                );
                if(in_array($this->viewData["mode"], array("DSP","DEL"))){
                    $this->viewData["readonly"] = "readonly";
                }
                if($this->viewData["mode"] === "DSP") {
                    $this->viewData["show_action"] = false;
                }
            }
            Renderer::render("mnt/comic", $this->viewData);
    }
  }
}
?>