<input type="hidden" value="{{$cantidadimageneshay}}" id="cantidadimageneshay" name="cantidadimageneshay">
<table class="table table-hover table-responsive-xl table-sm" id="tablaContenido">
    <thead>
        <tr>
            <th></th>
            <th>
                <center>Imagenes banner de 1740 x 550 px</center>
            </th>
            <th width="8%"></th>
        </tr>
    </thead>
    <tbody>
        @php
        $indice = 1;
        @endphp
        @foreach ($imagenesBanners as $item)
        <tr>
            <td>
                {{$indice++}}
            </td>
            <td align="center">
                {{
                    Html::image(asset('storage/uploads/'.$item->imagen), 'Sin Imagen', array('id'=>'imagen_icono', 'class' =>'img-thumbnail','width'=>'500'))
                }}
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm" onclick="eliminarImagenBanner('{{$item->imu_id}}','{{$item->imagen}}');"><i class="fa fa-trash"></i> </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table><br>