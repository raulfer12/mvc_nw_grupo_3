<h1>Roles Usuarios</h1>
<section class="WWFilter">

</section>
<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>id Usuario</th>
        <th>id Rol</th>
        <th>Estado Usuario</th>        
      </tr>
    </thead>
    <tbody>
      {{foreach rolesusuarios}}
      <tr>        
        <td>
          <center>

          <a href="index.php?page=mnt_rolusuario&mode=DSP&rol_id={{rol_id}}&usuario_id={{usuario_id}}">{{usuario_id}}</a>
          </center>
          </td>
        <td>
          <center>

          <a href="index.php?page=mnt_rolusuario&mode=DSP&rol_id={{rol_id}}&usuario_id={{usuario_id}}">{{rol_id}}</a>
          </center>
          </td>
        <td>
          <center>
          {{rol_usuario_est}}
          </center>
        </td>       
       
      </tr>
      {{endfor rolesusuarios}}
    </tbody>
  </table>
</section>


