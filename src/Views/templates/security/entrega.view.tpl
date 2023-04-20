<section class="container min-vh-100">

    <div class="col-md-4 p-0 mt-5">
        <form action="index.php" method="GET">
            <input type="hidden" name="page" value="carrito">
            <button class="btn primary" onclick=""><i class="fas fa-arrow-left mx-2"></i>Regresar</button>
        </form>  
    </div>

    <div class="card mt-5 mb-1 w-100">
        <div class="card-header" style="background-color: #653719">
            <h3 class="text-center text-light">Datos para la Entrega del Producto</h3>
        </div>
        <div class="card-body"> 
            <form class="form" method="post" action="index.php?page=direccionentrega">

                <div class="form-group col-md-5">
                    <label for="DireccionDepartamento">Departamento *</label>
                    <input type="text" class="form-control" id="DireccionDepartamento" name="DireccionDepartamento" value="{{DireccionDepartamento}}" maxlength="30" placeholder="Departamento en el que reside">
                </div>

                <div class="form-group col-md-5">
                    <label for="DireccionCiudad">Ciudad *</label>
                    <br/>
                    <input type="text" class="form-control" id="DireccionCiudad" name="DireccionCiudad" value="{{DireccionCiudad}}" maxlength="30" placeholder="Ciudad en que reside">
                </div>

                <div class="form-group col-md-12">
                    <label for="Direccion">Dirección *</label>
                    <br/>
                    <input type="text" class="form-control" id="direccion" name="direccion" value="{{direccion}}" maxlength="50" placeholder="Información dirección en la que reside">
                </div>

                <div class="form-group col-md-5">
                    <label for="NumeroCelular">Número Teléfono o Celular *</label>
                    <br/>
                    <input type="text" class="form-control" id="NumeroTelefonoCelular" name="NumeroTelefonoCelular" value="{{NumeroTelefonoCelular}}" maxlength="80" placeholder="Número de télefono o celular">
                </div>   

                {{if hasErrors}}
                <section>
                    <ul>
                        {{foreach aErrors}}
                            <li class="text-danger my-2">{{this}}</li>
                        {{endfor aErrors}}
                    </ul>
                </section>
                {{endif hasErrors}}

                <button type="submit" class="btn primary mt-2 ml-3" id="btnAceptar" name="btnAceptar">Aceptar</button>
            </form>
        </div>
    </div>
</section>