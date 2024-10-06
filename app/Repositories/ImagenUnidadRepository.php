<?php
namespace App\Repositories;
use App\Models\ImagenUnidad;

class ImagenUnidadRepository
{
    protected $imagenUnidad;
    public function __construct(ImagenUnidad $imagenUnidad)
    {
        $this->imagenUnidad = $imagenUnidad;
    }

    public function getImagenUnidadBannerByUnidadAndTipo($und_id,$tipo)
    {
        $imagenUnidad = ImagenUnidad::where([
            ['und_id','=',$und_id],
            ['tipo','=',$tipo],
            ['estado','=','AC']
        ])->orderBy('und_id','asc')->get();
        return $imagenUnidad;
    }

    public function update($unidaddespacho,$data)
    {
        $und_id = $unidaddespacho['und_id'];
        if(isset($data['imagen_banner'])) {
            $arreglom = $data['imagen_banner'];
            $cantidadimagenesunidadhay = substr_count($arreglom, ',');
            $i = 0;
            for ($a = 0; $a <= $cantidadimagenesunidadhay; $a++) {
                $imagenNom = explode(',', $arreglom);
                $imagenUnidad = new $this->imagenUnidad;
                $imagenUnidad->imagen = $imagenNom[$a];
                $imagenUnidad->alto = $data['alto_banner'];
                $imagenUnidad->ancho = $data['ancho_banner'];
                $imagenUnidad->tipo = $data['tipo_banner'];
                $imagenUnidad->estado = 'AC';
                $imagenUnidad->und_id = $und_id;
                $imagenUnidad->save();
                $imagenUnidad->fresh();
                $i++;
            }
        }
        return $data;
    }

    public function getById($imu_id):?ImagenUnidad
    {
        $imagenUnidad = ImagenUnidad::find($imu_id);
        return $imagenUnidad;
    }

    //UNIDADES

    public function saveUnidad($unidad,$data)
    {
        $und_id = $unidad['und_id'];
        if(isset($data['imagen_banner'])) {
            $arreglom = $data['imagen_banner'];
            $cantidadimagenesunidadhay = substr_count($arreglom, ',');
            $i = 0;
            for ($a = 0; $a <= $cantidadimagenesunidadhay; $a++) {
                $imagenNom = explode(',', $arreglom);
                $imagenUnidad = new $this->imagenUnidad;
                $imagenUnidad->imagen = $imagenNom[$a];
                $imagenUnidad->alto = $data['alto_banner'];
                $imagenUnidad->ancho = $data['ancho_banner'];
                $imagenUnidad->tipo = $data['tipo_banner'];
                $imagenUnidad->estado = 'AC';
                $imagenUnidad->und_id = $und_id;
                $imagenUnidad->save();
                $imagenUnidad->fresh();
                $i++;
            }
        }
        return $data;
    }


}
