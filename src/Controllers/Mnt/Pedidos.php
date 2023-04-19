<?php 
namespace Controllers\Admin;

class Pedidos extends \Controllers\PrivateController
{
    private $UsuarioBusqueda = "";

    public function __construct()
    {
        parent::__construct();
    }

    public function run() :void
    {
        $dataview = array();
        
        if ($this->isPostBack()) 
        {   
            $this->UsuarioBusqueda = isset($_POST["UsuarioBusqueda"]) ? $_POST["UsuarioBusqueda"] : "";

            if(!empty($this->UsuarioBusqueda))
            {
                $dataview["items"] = \Dao\Mnt\Pedidos::searchPedidos($this->UsuarioBusqueda);
                \Utilities\Context::setContext("UsuarioBusqueda", $this->UsuarioBusqueda);
            }
            else
            {
                $dataview["items"] = \Dao\Mnt\Pedidos::getAll();
            }
        } 
        else
        {   
            $dataview["items"] = \Dao\Mnt\Pedidos::getAll();
        }

        \Views\Renderer::render("admin/pedidos", $dataview);
    }
}