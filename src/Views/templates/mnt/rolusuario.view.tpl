<h1>{{mode_dsc}}</h1>
<section>
  
    <section>
      <label for="catid">Id Rol</label><br><br>
      <input type="number" {{readonly}}  name="rol_id" value="{{rol_id}}" />      
      
    </section>
    <section>
      <label for="catid">Id Usuario</label><br><br>
      <input type="number" {{readonly}}  name="usuario_id" value="{{usuario_id}}" />      
    </section>    

    <section>
      <label for="catest">Estado Usuario</label><br><br>
      <input type="text" {{readonly}} name="estado" value="{{rol_usuario_est}}" maxlength="45"  />

    </section>
    
    {{if hasErrors}}
    <section>
      <ul>
        {{foreach aErrors}}
        <li>{{this}}</li>
        {{endfor aErrors}}
      </ul>
    </section>
    {{endif hasErrors}}
    <section>
      {{if show_action}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif show_action}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  
</section>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("btnCancelar").addEventListener("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      window.location.assign("index.php?page=mnt_rolesusuarios");
    });
  });
</script>