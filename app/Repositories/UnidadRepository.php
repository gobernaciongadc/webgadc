<?php

namespace App\Repositories;
use App\Models\Unidad;
use Illuminate\Support\Facades\DB;

class UnidadRepository
{
    protected $unidad;
    public function __construct(Unidad $unidad)
    {
        $this->unidad = $unidad;
    }

    public function getById($und_id)
    {
        return $this->unidad->find($und_id);
    }

    public function getUnidadDespacho()
    {
        return $this->unidad->where([
            ['estado','=','AC']
        ])->whereHas('tipoUnidad', function ($query) {
            $query->where('tipo', '=', 0);
        })->first();
    }

    public function getAllAcUnidadesParaComboSelectOrdenadosByTipo()
    {
        return $this->unidad->where([
            ['estado','=','AC']
        ])->orderBy('tiu_id','asc')->orderBy('nombre','asc')->pluck('nombre','und_id');
    }

    public function getAllAcUnidadesParaComboSelectOrdenadosByArrayTipoUnidad($array)
    {
        return $this->unidad->where([
            ['estado','=','AC']
        ])->whereHas('tipoUnidad', function ($query) use($array){
            $query->where([
                ['estado','=','AC']
            ])->whereIn('tipo', $array);
        })->orderBy('tiu_id','asc')->orderBy('nombre','asc')->pluck('nombre','und_id');
    }

    public function save($data):?Unidad
    {
        $unidad = new $this->unidad;
        $unidad->nombre = $data['nombre'];
        $unidad->mision = $data['mision'];
        $unidad->vision = $data['vision'];
        $unidad->objetivo = $data['objetivo'];
        $unidad->historia = $data['historia'];
        if(isset($data['organigrama'])){
            $unidad->organigrama = $data['organigrama'];
        }
        if(isset($data['imagen_icono'])){
            $unidad->imagen_icono = $data['imagen_icono'];
        }
        if(isset($data['telefonos'])){  $unidad->telefonos = $data['telefonos']; }else{ $unidad->telefonos = null;  }
        if(isset($data['email'])){  $unidad->email = $data['email']; }else{ $unidad->email = null;  }
        $unidad->celular_wp = $data['celular_wp'];
        $unidad->lugar = $data['lugar'];
        $unidad->direccion = $data['direccion'];
        $unidad->tiu_id = $data['tiu_id'];
        if(isset($data['und_padre_id'])){  $unidad->und_padre_id = $data['und_padre_id']; }else{ $unidad->und_padre_id = null;  }
        $unidad->save();
        return $unidad->fresh();
    }


    public function update($data):?Unidad
    {
        $unidad = Unidad::find($data['und_id']);
        $unidad->nombre = $data['nombre'];
        $unidad->mision = $data['mision'];
        $unidad->vision = $data['vision'];
        $unidad->objetivo = $data['objetivo'];
        $unidad->historia = $data['historia'];
        if(isset($data['organigrama'])){
            $unidad->organigrama = $data['organigrama'];
        }
        if(isset($data['imagen_icono'])){
            $unidad->imagen_icono = $data['imagen_icono'];
        }
        if(isset($data['telefonos'])){  $unidad->telefonos = $data['telefonos']; }else{ $unidad->telefonos = null;  }
        $unidad->celular_wp = $data['celular_wp'];
        $unidad->lugar = $data['lugar'];
        $unidad->direccion = $data['direccion'];
        if(isset($data['link_facebook'])){  $unidad->link_facebook = $data['link_facebook']; }else{ $unidad->link_facebook = null;  }
        if(isset($data['link_twiter'])){  $unidad->link_twiter = $data['link_twiter']; }else{ $unidad->link_twiter = null;  }
        if(isset($data['link_instagram'])){  $unidad->link_instagram = $data['link_instagram']; }else{ $unidad->link_instagram = null;  }
        if(isset($data['link_youtube'])){  $unidad->link_youtube = $data['link_youtube']; }else{ $unidad->link_youtube = null;  }
        $unidad->estado = $data['estado'];
        if(isset($data['longitud'])){  $unidad->longitud = $data['longitud']; }else{ $unidad->longitud = null;  }
        if(isset($data['latitud'])){  $unidad->latitud = $data['latitud']; }else{ $unidad->latitud = null;  }
        if(isset($data['imagen_direccion'])){
            $unidad->imagen_direccion = $data['imagen_direccion'];
        }
        if(isset($data['email'])){  $unidad->email = $data['email']; }else{ $unidad->email = null;  }
        if(isset($data['bio_id'])){  $unidad->bio_id = $data['bio_id']; }else{ $unidad->bio_id = null;  }
        if(isset($data['und_padre_id'])){  $unidad->und_padre_id = $data['und_padre_id']; }else{ $unidad->und_padre_id = null;  }
        $unidad->tiu_id = $data['tiu_id'];
        $unidad->save();
        return $unidad->fresh();
    }

    public function delete($data,$texto):?Unidad
    {
        $unidad = Unidad::find($data['und_id']);
        if($texto == 'inhabilitar') {
            $unidad->estado = 'EL';
            $unidad->save();
            return $unidad->fresh();
        }
        if($texto == 'habilitar'){
            $unidad->estado = 'AC';
            $unidad->save();
            return $unidad->fresh();
        }
    }

    /// --------------------------   UNIDAD SECRETARIA  ----------------------------------
    /// se debe de modificar aun
    public function getAllUnidadPaginateBySearchAndSortACAndEl($limit,$tipoUnidad)
    {
        return $this->unidad->where([

        ])->whereHas('tipoUnidad', function ($query)use($tipoUnidad) {
            $query->where('tipo', '=', $tipoUnidad);
        })->orderBy('nombre','asc')->paginate($limit);

    }

    public function saveUnidad($data):?Unidad
    {
        $unidad = new $this->unidad;
        if(isset($data['und_padre_id'])){
            $unidad->und_padre_id = $data['und_padre_id'];
        }else{
            $unidad->und_padre_id = null;
        }
        $unidad->nombre = $data['nombre'];
        $unidad->mision = $data['mision'];
        $unidad->vision = $data['vision'];
        $unidad->objetivo = $data['objetivo'];
        $unidad->historia = $data['historia'];
        if(isset($data['organigrama'])){$unidad->organigrama = $data['organigrama'];}
        if(isset($data['imagen_icono'])){$unidad->imagen_icono = $data['imagen_icono'];}
        if(isset($data['telefonos'])){  $unidad->telefonos = $data['telefonos']; }else{ $unidad->telefonos = null;  }
        $unidad->celular_wp = $data['celular_wp'];
        $unidad->lugar = $data['lugar'];
        $unidad->direccion = $data['direccion'];
        if(isset($data['link_facebook'])){  $unidad->link_facebook = $data['link_facebook']; }else{ $unidad->link_facebook = null;  }
        if(isset($data['link_twiter'])){  $unidad->link_twiter = $data['link_twiter']; }else{ $unidad->link_twiter = null;  }
        if(isset($data['link_instagram'])){  $unidad->link_instagram = $data['link_instagram']; }else{ $unidad->link_instagram = null;  }
        if(isset($data['link_youtube'])){  $unidad->link_youtube = $data['link_youtube']; }else{ $unidad->link_youtube = null;  }
        $unidad->estado = $data['estado'];
        if(isset($data['longitud'])){  $unidad->longitud = $data['longitud']; }else{ $unidad->longitud = null;  }
        if(isset($data['latitud'])){  $unidad->latitud = $data['latitud']; }else{ $unidad->latitud = null;  }
        if(isset($data['imagen_direccion'])){$unidad->imagen_direccion = $data['imagen_direccion'];}
        if(isset($data['bio_id'])){  $unidad->bio_id = $data['bio_id']; }else{ $unidad->bio_id = null;  }
        if(isset($data['email'])){  $unidad->email = $data['email']; }else{ $unidad->email = null;  }
        $unidad->tiu_id = $data['tiu_id'];
        $unidad->save();
        return $unidad->fresh();
    }

    public function updateUnidad($data):?Unidad
    {
        $unidad = Unidad::find($data['und_id']);
        if(isset($data['und_padre_id'])){
            $unidad->und_padre_id = $data['und_padre_id'];
        }else{
            $unidad->und_padre_id = null;
        }
        $unidad->nombre = $data['nombre'];
        $unidad->mision = $data['mision'];
        $unidad->vision = $data['vision'];
        $unidad->objetivo = $data['objetivo'];
        $unidad->historia = $data['historia'];
        if(isset($data['organigrama'])){$unidad->organigrama = $data['organigrama'];}
        if(isset($data['imagen_icono'])){$unidad->imagen_icono = $data['imagen_icono'];}
        if(isset($data['telefonos'])){  $unidad->telefonos = $data['telefonos']; }else{ $unidad->telefonos = null;  }
        $unidad->celular_wp = $data['celular_wp'];
        $unidad->lugar = $data['lugar'];
        $unidad->direccion = $data['direccion'];
        if(isset($data['link_facebook'])){  $unidad->link_facebook = $data['link_facebook']; }else{ $unidad->link_facebook = null;  }
        if(isset($data['link_twiter'])){  $unidad->link_twiter = $data['link_twiter']; }else{ $unidad->link_twiter = null;  }
        if(isset($data['link_instagram'])){  $unidad->link_instagram = $data['link_instagram']; }else{ $unidad->link_instagram = null;  }
        if(isset($data['link_youtube'])){  $unidad->link_youtube = $data['link_youtube']; }else{ $unidad->link_youtube = null;  }
        $unidad->estado = $data['estado'];
        if(isset($data['longitud'])){  $unidad->longitud = $data['longitud']; }else{ $unidad->longitud = null;  }
        if(isset($data['latitud'])){  $unidad->latitud = $data['latitud']; }else{ $unidad->latitud = null;  }
        if(isset($data['imagen_direccion'])){$unidad->imagen_direccion = $data['imagen_direccion'];}
        if(isset($data['bio_id'])){  $unidad->bio_id = $data['bio_id']; }else{ $unidad->bio_id = null;  }
        if(isset($data['email'])){  $unidad->email = $data['email']; }else{ $unidad->email = null;  }
        $unidad->tiu_id = $data['tiu_id'];
        $unidad->save();
        return $unidad->fresh();
    }

    public function getListaSecretariasAc()
    {
        return $this->unidad->where([
            ['estado','=','AC']
        ])->whereHas('tipoUnidad', function ($query) {
            $query->where('tipo', '=', 1);
        })->orderBy('nombre','asc')->get();
    }

    public function getListaServiciosDepartamentalesAc()
    {
        return $this->unidad->where([
            ['estado','=','AC']
        ])->whereHas('tipoUnidad', function ($query) {
            $query->where('tipo', '=', 4);
        })->orderBy('nombre','asc')->get();
    }

    public function updateMapaOrganigrama($data)
    {
        $unidad = $this->unidad->find($data['und_id']);
        $unidad->mapa_organigrama = $data['mapa_organigrama'];
        $unidad->save();
        return $unidad->fresh();
    }

    public function getUnidadesDependientes($und_id)
    {
        return $this->unidad->where([
            ['estado','=','AC'],
            ['und_padre_id','=',$und_id]
        ])->orderBy('tiu_id','asc')->orderBy('nombre','asc')->get();
    }

    public function getAllIdsUnidadesDependientes($und_id)
    {
        $datos = DB::select("WITH RECURSIVE c AS (
           SELECT und_id AS id
            FROM und_unidad where und_id = $und_id
           UNION ALL
           SELECT sa.und_id
           FROM und_unidad AS sa
              JOIN c ON c.id = sa.und_padre_id
        )
        SELECT distinct id FROM c order by id asc");
        $arreglo = array();
        foreach ($datos as $index=>$dato) {
            array_push($arreglo,$dato->id);
        }
        return $arreglo;
    }

    //nueva funcion para direcciones unidades y servicios
    public function getAllUnidadPaginateBySearchAndSortACAndEl2($limit,$tipoUnidad,$unidadesdependientes)
    {
        return $this->unidad->whereIn('und_id',$unidadesdependientes)
            ->whereHas('tipoUnidad', function ($query)use($tipoUnidad) {
            $query->where('tipo', '=', $tipoUnidad);
        })->orderBy('nombre','asc')->paginate($limit);
    }

}
