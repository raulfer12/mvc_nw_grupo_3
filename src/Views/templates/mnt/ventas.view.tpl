<section class="container-fluid min-vh-100">

    <h3 class="my-4 text-center display-4 mb-2">Gestión de Ventas</h3>

    <div class="rounded">
        <form method="POST" action="index.php?page=admin_ventas">
        <div class="form-row">
            <div class="col-10">
            <input type="search" class="form-control rounded" id="usuario_busqueda" name="usuario_busqueda" value="{{usuario_busqueda}}" placeholder="Ingrese su busqueda">
            </div>
            <div class="col-2">
            <button type="submit" class="fas fa-search mb-3 rounded" id="btnBuscar" name="btnBuscar">Buscar</button>
            </div>
        </div>
        </form> 
    </div>

    <div class="table-responsive table-hover rounded">
        <table class="table">
        <thead class="thead text-light" style="background-color: #653719">
            <tr>
                <th class="text-center align-middle">Código</th>
                <th class="text-center align-middle">Fecha</th>
                <th class="text-center align-middle">ISV</th>
                <th class="text-center align-middle">Estado</th>
                <th class="text-center align-middle">Nombre del Cliente</th>
                <th class="text-center align-middle">Teléfono del Cliente</th>
                <th class="text-center align-middle">Dirección del Cliente</th>
                <th class="text-center align-middle">Link para Devolución</th>
                <th class="text-center align-middle">Link para Orden en Paypal</th>
                <th class="text-center align-middle">Ganancia Bruta</th>
                <th class="text-center align-middle">Comisión de Paypal</th>
                <th class="text-center align-middle">Ganancia Neta</th>
            <th class="text-center align-middle"></th>
            </tr>
        </thead>
        <tbody>
            {{foreach items}}
            <tr>
                <td class="text-center align-middle"><a href="index.php?page=admin_venta&mode=DSP&venta_id={{venta_id}}">{{venta_id}}</a></td>
                <td class="text-center align-middle">{{venta_date}}</td>
                <td class="text-center align-middle">{{venta_ISV}}</td>
                <td class="text-center align-middle">{{venta_est}}</td>
                <td class="text-center align-middle">{{usuario_nombre}}</td>
                <td class="text-center align-middle">{{cliente_tel}}</td>
                <td class="text-center align-middle">{{cliente_dir}}</td>
                <td class="text-center align-middle"><a href="{{venta_link_devolucion}}">{{venta_link_devolucion}}</a></td>
                <td class="text-center align-middle"><a href="{{venta_link_orden}}">{{venta_link_orden}}</a></td>
                <td class="text-center align-middle">{{venta_cantidad_total}}</td>
                <td class="text-center align-middle">{{venta_comision_PayPal}}</td>
                <td class="text-center align-middle">{{venta_cantidad_neta}}</td>
                <td class="text-center align-middle">
                <form action="index.php" method="get">
                    <input type="hidden" name="page" value="admin_venta"/>
                    <input type="hidden" name="mode" value="UPD" />
                    <input type="hidden" name="venta_id" value={{venta_id}} />
                </form>
                </td>
            </tr>
            {{endfor items}}
        </tbody>
      </table>
    </div>
  </section>