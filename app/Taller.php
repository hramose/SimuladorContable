<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Taller extends Model
{
    /**
     * El nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'Taller';

    /**
     * El nombre de la llave primaria de la tabla.
     * Se modifica debido a que no es el nombre por defecto: id.
     *
     * @var string
     */
    protected $primaryKey = 'tall_id';

    /**
     * El nombre del campo equivalente a CREATE_AT en la base de datos.
     * Se modifica debido a que no es el nombre por defecto: create_at.
     *
     * @var string
     */
    const CREATED_AT = 'tall_fechacreacion';

    /**
     * El nombre del campo equivalente a UPDATED_AT en la base de datos.
     * Se modifica debido a que no es el nombre por defecto: update_at.
     *
     * @var string
     */
    const UPDATED_AT = 'tall_fechamodificacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tall_id', 'tall_nombre','tall_tipo','tall_tiempo','curs_id','tall_rutaarchivo','tall_nombrearchivo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * Obtener las preguntas para el taller
     */
    public function preguntas()
    {
        return $this->hasMany('App\Pregunta','preg_id');
    }

    /**
     * Obtener el curso que es dueño del taller.
     */
    public function curso()
    {
        return $this->belongsTo('App\Curso', 'curs_id');
    }

    /**
     * Obtener las tarifas para el taller.
     */
    public function tarifas()
    {
        return $this->hasMany('App\Tarifa', 'tall_id');
    }

    public static function getPossibleEnumValues(){
        $type = DB::select(DB::raw('SHOW COLUMNS FROM Taller WHERE Field = "tall_tipo"'))[0]->Type;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $values = array();
        foreach(explode(',', $matches[1]) as $value){
            $values[] = trim($value, "'");
        }
        return $values;
    }
}
