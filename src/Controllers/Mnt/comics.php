<?php
    namespace Controllers\Mnt;

    use Controllers\PrivateController;
    use Views\Renderer;

    class comics extends PrivateController{
        public function run():void
        {
            $viewData=array();
            $viewData["comics"]=\Dao\Mnt\comics::getAll();
            $viewData["comics_view"]= false->isFeatureAuthorized('mnt_comics_view');
            $viewData["comics_edit"]= false->isFeatureAuthorized('mnt_comics_edit');
            $viewData["comics_delete"]= false->isFeatureAuthorized('mnt_comics_delete');
            $viewData["comics_new"]= false->isFeatureAuthorized('mnt_comics_new');

            Renderer::render("mnt/comics", $viewData);
        }
    }
?>