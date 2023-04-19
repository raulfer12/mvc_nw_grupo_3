<main>
    <table>
        <tr>
            <th>Codigo del comic</th>
            <th>Nombre del comic</th>
            <th>Descripcion del comic</th>
            <th>Estado</th>
            <th>Precio de venta</th>
            <th>Precio de compra</th>
            <th>comic en stock</th>
            <th>
                {{if comics_view}}
                <a href="index.php?page=Mnt-comics&mode=INS">Nuevo</a>
                {{endif comics_view}}
            </th>
        </tr>
        {{foreach comics}}
        <tr>
            <td>{{comic_id}}</td>
            <td>{{comic_nombre}}</td>
            <td>{{comic_descripcion}}</td>
            <td>{{comic_est}}</td>
            <td>{{comic_precio_venta}}</td>
            <td>{{comic_precio_compra}}</td>
            <td>{{comic_stock}}</td>
            <td>
                {{if ~comics_view}}
                <a href="index.php?page=Mnt-comicl&mode=DSP&comic_id={{comic_id}}">{{funcion_exp}}</a>
                {{endif ~comics_view}}
                {{ifnot ~comics_view}}
                {{endifnot ~comics_view}}
            </td>
            <td>
                {{if ~comics_edit}}
                <a href="index.php?page=Mnt-comic&mode=UPD&comic_id={{comic_id}}">Editar</a> &nbsp; <a href="index.php?page=Mnt-comic&mode=DEL&comic_id={{comic_id}}">Eliminar</a>
                {{endif ~comics_edit}}
                &nbsp;
                {{if ~comics_delete}}
                <a href="index.php?page=Mnt-comic&mode=UPD&comic_id={{comic_id}}">Editar</a> &nbsp; <a href="index.php?page=Mnt-comic&mode=DEL&comic_id={{comic_id}}">Eliminar</a>
                {{endif ~comics_delete}}
            </td>
        </tr>
        {{endfor comics}}
    </table>
</main>