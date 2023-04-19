<?php 
namespace Controllers\Admin;

use Dao\Security\Estados;

class Pedido extends \Controllers\PrivateController
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * `venta_id` int NOT NULL AUTO_INCREMENT,
  *`venta_date` datetime NOT NULL,
  *`venta_ISV` decimal(9,2) NOT NULL,
  *`venta_est` varchar(10) NOT NULL,
  *`venta_link_devolucion` varchar(100) DEFAULT NULL,
  *`venta_link_orden` varchar(100) DEFAULT NULL,
  *`venta_cantidad_total` decimal(9,2) DEFAULT NULL,
  *`venta_comision_PayPal` decimal(9,2) DEFAULT NULL,
  *`venta_cantidad_neta` decimal(9,2) DEFAULT NULL,
  *`cliente_tel` char(20) DEFAULT NULL,
  *`cliente_dir` char(180) DEFAULT NULL,
  *`usuario_id` int DEFAULT NULL,
     */

    private $venta_id = 0;
    private $venta_date = "";
    private $venta_ISV = "";
    private $venta_est = "";
    private $venta_link_devolucion = "";
    private $venta_link_orden = "";
    private $venta_cantidad_total = "";
    private $venta_comision_PayPal = "";
    private $venta_cantidad_neta = "";
    private $cliente_tel = "";
    private $cliente_dir = "";
    private $usuario_id = "";
    private $Productos = array();

    private $mode_dsc = "";
    private $mode_adsc = array(
        "UPD" => "Editar Venta Código: %s, Nombre del Cliente: %s",
        "DSP" => "Visualizar Venta Código: %s, Nombre del Cliente: %s"
    );
    private $readonly = "";
    private $showaction= true;
    private $notDisplayIns= false;
    private $hasErrors = false;
    private $aErrors = array();
    public function run() :void
    {
        $this->mode = isset($_GET["mode"])?$_GET["mode"]:"";
        $this->venta_id = isset($_GET["venta_id"])?$_GET["venta_id"]:0;
        if (!$this->isPostBack()) 
        {
            $this->_load();
        } 
        else 
        { 
            switch ($this->mode)
            {
                case "UPD":
                    if (\Dao\Mnt\Pedidos::update($this->venta_id)) 
                    {
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=admin_pedidos",
                            "Estado del Pedido Actualizado"
                        );
                    }
                break;
            }
        }

        $dataview = get_object_vars($this);
        \Views\Renderer::render("admin/pedido", $dataview);
    }

    private function _load()
    {
        $_data = \Dao\Mnt\Pedidos::getOne($this->venta_id);
        $_productos= \Dao\Mnt\Pedidos::getProductos($this->venta_id);
        if ($_data && $_productos) 
        {
            $this->venta_id = $_data["venta_id"];
            $this->venta_date = $_data["venta_date"];
            $this->venta_ISV = $_data["venta_ISV"];
            $this->venta_est = $_data["venta_est"];
            $this->venta_link_devolucion = $_data["venta_link_devolucion"];
            $this->venta_link_orden = $_data["venta_link_orden"];
            $this->venta_cantidad_total = $_data["venta_cantidad_total"];
            $this->venta_comision_PayPal = $_data["venta_comision_PayPal"];
            $this->venta_cantidad_neta = $_data["venta_cantidad_neta"];
            $this->cliente_tel = $_data["cliente_tel"];
            $this->cliente_dir = $_data["cliente_dir"];
            $this->usuario_id = $_data["usuario_id"];
            $this->Productos = $_productos;
            $this->_setViewData();
        }
    }
    private function _setViewData()
    {
        $this->mode_dsc = sprintf(
            $this->mode_adsc[$this->mode],
            $this->venta_id,
            $this->usuario_id
        );
        $this->notDisplayIns = ($this->mode=="INS") ? false : true;
        $this->readonly = ($this->mode =="DEL" || $this->mode=="DSP") ? "readonly":"";
        $this->showaction = !($this->mode == "DSP");
    }
}
?>