<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Funcion_Rol&mode={{mode}}&rol_id={{rol_id}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="rol_id" class="col-4">Código del Rol</label>
    <input type="hidden" id="rol_id" name="rol_id" value="{{rol_id}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
     <input type="hidden" name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="rol_iddummy" value="{{rol_id}}"/>
    </section>
    <section class="row">
      <label for="funcion_id" class="col-4">Codigo de la Funcion</label>
      <input type="text" {{readonly}} name="funcion_id" value="{{funcion_id}}" maxlength="100"/>
    </section>
    <section class="row">
      <label for="funcion_rol_est" class="col-4">Estado</label>
      <select id="funcion_rol_est" name="funcion_rol_est" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{funcion_rol_est_ACT}}>Activo</option>
        <option value="INA" {{funcion_rol_est_INA}}>Inactivo</option>
      </select>
    </section>
    <section class="row">
      <label for="funcion_exp" class="col-4">Fecha de Expiracion</label>
      <input type="text" {{readonly}} name="funcion_exp" value="{{funcion_exp}}" maxlength="10" placeholder="YYYY-MM-DD"/>
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
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=Mnt_Journals");
      });
  });
</script>