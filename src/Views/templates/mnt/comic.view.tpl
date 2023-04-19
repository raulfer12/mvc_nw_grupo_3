<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_comic&mode={{mode}}&comic_id={{comic_id}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="comic_id" class="col-4">Código del Comic</label>
    <input type="hidden" id="comic_id" name="comic_id" value="{{comic_id}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
     <input type="hidden" name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="comic_iddummy" value="{{comic_id}}"/>
    </section>
    <section class="row">
      <label for="comic_est" class="col-4">Estado</label>
      <select id="comic_est" name="comic_est" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{comic_est_ACT}}>Activo</option>
        <option value="INA" {{comic_est_INA}}>Inactivo</option>
      </select>
    </section>
    <section class="row">
      <label for="comic_nombre" class="col-4">Nombre</label>
      <input type="text" {{readonly}} name="comic_nombre" value="{{comic_nombre}}" maxlength="120" placeholder="Nombre"/>
    </section>
   <section class="row">
      <label for="comic_descripcion" class="col-4">Descripción</label>
      <input type="text" {{readonly}} name="comic_descripcion" value="{{comic_descripcion}}" maxlength="1000" placeholder="Descripción"/>
    </section>
 
     <section class="row">
      <label for="comic_precio_venta" class="col-4">Precio Venta</label>
      <input type="number" {{readonly}} name="comic_precio_venta" value="{{comic_precio_venta}}" />
    </section>
     <section class="row">
      <label for="comic_precio_compra" class="col-4">Precio Compra</label>
      <input type="number" {{readonly}} name="comic_precio_compra" value="{{comic_precio_compra}}" />
    </section>
     <label for="comic_stock" class="col-4">Comics en Stock</label>
      <input type="number" {{readonly}} name="comic_stock" value="{{comic_stock}}" />
    </section>
    {{if has_errors}}
        <section>
          <ul>
            {{foreach general_errors}}
                <li>{{this}}</li>
            {{endfor general_errors}}
          </ul>
        </section>
    {{endif has_errors}}
    <section>
      {{if show_action}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif show_action}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("bctnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=Mnt_comic");
      });
  });
</script>