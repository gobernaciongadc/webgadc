<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConSemanario
 *
 * @property $id
 * @property $edicion
 * @property $fecha_publicacion
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ConSemanario extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['edicion', 'fecha_publicacion'];

    // Relaciones
    public function img_semanarios()
    {
        return $this->hasMany(ImgSemanario::class, 'semanario_id'); // se dirige hacia Generars
    }
}
