<main>
    <table>
        <tr>
            <th>Codigo del Rol</th>
            <th>Codigo de la Funcion</th>
            <th>Estado</th>
            <th>Fecha de Expiracion</th>
            <th>
                {{if funciones_roles_view}}
                <a href="index.php?page=Mnt-Funcion_Rol&mode=INS">Nuevo</a>
                {{endif funciones_roles_view}}
            </th>
        </tr>
        {{foreach funciones_roles}}
        <tr>
            <td>{{rol_id}}</td>
            <td>{{funcion_id}}</td>
            <td>{{funcion_rol_est}}</td>
            <td>
                {{if ~funciones_roles_view}}
                <a href="index.php?page=Mnt-Funcion_Rol&mode=DSP&rol_id={{rol_id}}">{{funcion_exp}}</a>
                {{endif ~funciones_roles_view}}
                {{ifnot ~funciones_roles_view}}
                {{funcion_exp}}
                {{endifnot ~funciones_roles_view}}
            </td>
            <td>
                {{if ~funciones_roles_edit}}
                <a href="index.php?page=Mnt-Funcion_Rol&mode=UPD&rol_id={{rol_id}}">Editar</a> &nbsp; <a href="index.php?page=Mnt-Funcion_Rol&mode=DEL&rol_id={{rol_id}}">Eliminar</a>
                {{endif ~funciones_roles_edit}}
                &nbsp;
                {{if ~funciones_roles_delete}}
                <a href="index.php?page=Mnt-Funcion_Rol&mode=UPD&rol_id={{rol_id}}">Editar</a> &nbsp; <a href="index.php?page=Mnt-Funcion_Rol&mode=DEL&rol_id={{rol_id}}">Eliminar</a>
                {{endif ~funciones_roles_delete}}
            </td>
        </tr>
        {{endfor funciones_roles}}
    </table>
</main>