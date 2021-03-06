<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InstrumentoCursoParticipanteRol extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'instrumentos_cursos_participantes_roles';

    protected $fillable = ['id', 'curso_participante_rol_id', 'instrumento_id','created_at','updated_at'];

    /**
	 * Indicates if the IDs are auto-incrementing.
	 *
	 * @var bool
	 */
	public $incrementing = true;
}
