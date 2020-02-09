<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EstatusInvitacion;

use App\Traits\CommonFunctionsGenetvi; 

class Invitacion extends Model
{
    use CommonFunctionsGenetvi;
    protected $table = 'invitaciones';
    protected $fillable = ['id', 
    'token', 
    'estatus_invitacion_id', 
    'tipo_invitacion_id', 
    'instrumento_id', 
    'curso_id', 
    'periodo_lectivo_id', 
    'momento_evaluacion_id',
    'cvucv_user_id', 
    'usuario_id',
    'cantidad_recordatorios',
    'created_at',
    'updated_at'];

    public static function create($token, $estatus_invitacion_id, $tipo_invitacion_id, $instrumento_id, $curso_id, $periodo_lectivo_id, $momento_evaluacion_id, $cvucv_user_id, $cantidad_recordatorios)   {
        $new = new Invitacion();

        $new->token                     = $token;
        $new->estatus_invitacion_id     = $estatus_invitacion_id;
        $new->tipo_invitacion_id        = $tipo_invitacion_id;
        $new->instrumento_id            = $instrumento_id;
        $new->curso_id                  = $curso_id;
        $new->periodo_lectivo_id        = $periodo_lectivo_id;
        $new->momento_evaluacion_id     = $momento_evaluacion_id;
        $new->cvucv_user_id             = $cvucv_user_id;
        $new->cantidad_recordatorios    = $cantidad_recordatorios;
        $new->created_at                = \Carbon\Carbon::now();
        $new->updated_at                = \Carbon\Carbon::now();

        $new->save();
    }

    public function instrumento()    {
        return $this->belongsTo('App\Instrumento','instrumento_id','id');
    }

    public function curso()    {
        return $this->belongsTo('App\Curso','curso_id','id');
    }

    public function periodo()    {
        return $this->belongsTo('App\PeriodoLectivo','periodo_lectivo_id','id');
    }
    public function estatus_invitacion()    {
        return $this->belongsTo('App\EstatusInvitacion','estatus_invitacion_id','id');
    }
    public function tipo_invitacion()    {
        return $this->belongsTo('App\TipoInvitacion','tipo_invitacion_id','id');
    }

    public function user_profile(){
        return $this->cvucv_get_profile($this->cvucv_user_id);
    }

    public function invitacion_completada(){
        if ($this->estatus_invitacion_id == 7){
            return true;
        }
        return false;
    }

    public function invitacion_revocada(){
        if ($this->estatus_invitacion_id == 8){
            return true;
        }
        return false;
    }

    public function actualizar_estatus_leida(){
        if($this->instrumento->puede_rechazar){
            $this->estatus_invitacion_id = 4; //Invitacion aceptada
        }else{
            $this->estatus_invitacion_id = 6; // Invitacion leída
        }
        $this->save();
    }

    public function getID(){
        return $this->id;
    }
    public function getToken(){
        return $this->token;
    }
    public static function generateToken(){
        do {
            //generate a random string using Laravel's str_random helper
            $token = str_random(191);
        } //verificamos que el token no exista
        while (Invitacion::where('token', $token)->first());

        return $token;
    }

   
    //Verificamos que no tenga invitación previa
    public static function invitacionPrevia($curso_id, $instrumento_id, $periodo_lectivo_id, $momento_evaluacion_activo_id, $participante_id ){
        $existe = Invitacion::where('cvucv_user_id', $participante_id)
        ->where('instrumento_id', $instrumento_id)
        ->where('momento_evaluacion_id', $momento_evaluacion_activo_id)
        ->where('periodo_lectivo_id', $periodo_lectivo_id)
        ->where('curso_id', $curso_id)
        ->first();

        if($existe === null){
            return false;
        }
        return true;
    }

    public static function invitarEvaluador($curso_id, $instrumento_id, $periodo_lectivo_id, $momento_evaluacion_activo_id, $participante_id, $tipo_invitacion_id){
        
        Invitacion::create(
            Invitacion::generateToken(), 
            EstatusInvitacion::getEstatusCreada(),
            $tipo_invitacion_id,
            $instrumento_id,
            $curso_id,
            $periodo_lectivo_id,
            $momento_evaluacion_activo_id,
            $participante_id,
            1
        );
    }
}
