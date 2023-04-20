<section class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card my-5 w-100">
      <div class="card-header text-light" style="background-color: #653719">
        <h3 class="text-center">{{mode_dsc}}</h3>
      </div>
      <div class="card-body"> 
        <form class="grid" method="post" action="index.php?page=admin_venta&mode={{mode}}&venta_id={{venta_id}}">

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="CategoriaId">Código</label>
            <input class="width-full center" type="hidden" class="form-control" id="venta_id" name="venta_id" value="{{venta_id}}"/>
            <input readonly type="text" class="width-full center disabled" class="form-control" name="venta_idDummy" value="{{venta_id}}"/>
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="venta_date">Fecha de la Venta</label>
            <input class="width-full center" type="text" class="form-control" readonly id="venta_date" name="venta_date" value="{{venta_date}}" maxlength="80">
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="venta_ISV">Impuesto sobre la Venta</label>
            <input class="width-full center" type="text" class="form-control" readonly id="venta_ISV" name="venta_ISV" value="{{venta_ISV}}" maxlength="80">
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="venta_est">Estado de la Venta</label>
            <input class="width-full center" type="text" class="form-control" readonly id="venta_est" name="venta_est" value="{{venta_est}}" maxlength="80">
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="usuario_nombre">Nombre del Cliente</label>
            <input class="width-full center" type="text" class="form-control" readonly id="usuario_nombre" name="usuario_nombre" value="{{usuario_nombre}}" maxlength="80">
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="cliente_tel">Télefono del Cliente</label>
            <input class="width-full center" type="text" class="form-control" readonly id="cliente_tel" name="cliente_tel" value="{{cliente_tel}}" maxlength="80">
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="cliente_dir">Dirección del Cliente</label>
            <textarea class="width-full center" type="text" class="form-control" readonly id="cliente_dir" name="cliente_dir" maxlength="300">{{cliente_dir}}</textarea>
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="venta_link_devolucion">Link para Devolución</label>
            <input class="width-full center" type="text" class="form-control" readonly id="venta_link_devolucion" name="venta_link_devolucion" value="{{venta_link_devolucion}}" maxlength="80">
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="venta_link_orden">Link para Orden en Paypal</label>
            <input class="width-full center" type="text" class="form-control" readonly id="venta_link_orden" name="venta_link_orden" value="{{venta_link_orden}}" maxlength="80">
          </div>
          <br>
          <div class="table-responsive table-hover rounded">
            <table class="table">
              <thead class="thead text-light" style="background-color: #653719">
                  <tr>
                  <th class="text-center align-middle">Código del Producto</th>
                  <th class="text-center align-middle">Nombre del Producto</th>
                  <th class="text-center align-middle">Descripcion del Producto</th>
                  <th class="text-center align-middle">Precio del Producto</th>
                  <th class="text-center align-middle">Cantidad de Producto</th>
                  </tr>
              </thead>
              <tbody>
                  {{foreach Productos}}
                  <tr>
                      <td class="text-center align-middle">{{comics_id}}</td>
                      <td class="text-center align-middle">{{comic_nombre}}</td>
                      <td class="text-center align-middle">{{comic_descripcion}}</td>
                      <td class="text-center align-middle">{{comic_precio_venta}}</td>
                      <td class="text-center align-middle">{{ventas_prod_cantidad}}</td>
                  </tr>
                  {{endfor Productos}}
              </tbody>
            </table>
          </div>
          
          <div class="row">
            <label class="col-12 col-m-4 flex center"for="venta_cantidad_total">Ganacia Bruta</label>
            <input class="width-full center" type="text" class="form-control" readonly id="venta_cantidad_total" name="venta_cantidad_total" value="{{venta_cantidad_total}}" maxlength="80">
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="venta_comision_PayPal">Comisión de Paypal</label>
            <input class="width-full center" type="text" class="form-control" readonly id="venta_comision_PayPal" name="venta_comision_PayPal" value="{{venta_comision_PayPal}}" maxlength="80">
          </div>

          <div class="row">
            <label class="col-12 col-m-4 flex center" for="venta_cantidad_neta">Ganancia Neta</label>
            <input class="width-full center" type="text" class="form-control" readonly id="venta_cantidad_neta" name="venta_cantidad_neta" value="{{venta_cantidad_neta}}" maxlength="80">
          </div>
          <br>
          <button type="button" class="btn btn-block btn-danger" id="btnCancelar" name="btnCancelar">Regresar</button>
        </form>
      </div>
    </div>
  </section>
  
  <script>
    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById("btnCancelar").addEventListener("click", function(e){
          e.preventDefault();
          e.stopPropagation();
          window.location.assign("index.php?page=admin_ventas");
        });
    });
  </script>