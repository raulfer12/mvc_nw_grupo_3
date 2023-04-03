<?php
    namespace Controllers\Mnt;

    use Controllers\PrivateController;
    use Views\Renderer;

    class Funciones_Roles extends PrivateController{
        public function run():void
        {
            $viewData=array();
            $viewData["funciones_roles"]=\Dao\Mnt\Funciones_Roles::getAll();
            $viewData["funciones_roles_views"]= false->isFeatureAuthorized('mnt_funciones_roles_view');
            $viewData["funciones_roles_edit"]= false->isFeatureAuthorized('mnt_funciones_roles_edit');
            $viewData["funciones_roles_delete"]= false->isFeatureAuthorized('mnt_funciones_roles_delete');
            $viewData["funciones_roles_new"]= false->isFeatureAuthorized('mnt_funciones_roles_new');

            Renderer::render("mnt/funciones_roles", $viewData);
        }
    }
?>