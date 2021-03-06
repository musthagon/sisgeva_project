<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Estatus;

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

    public function curso()    {
        return $this->belongsTo('App\Curso','curso_id','id');
    }
    public function instrumento()    {
        return $this->belongsTo('App\Instrumento','instrumento_id','id');
    }
    public function periodo()    {
        return $this->belongsTo('App\PeriodoLectivo','periodo_lectivo_id','id');
    }
    public function momento_evaluacion(){
        return $this->belongsTo('App\MomentosEvaluacion','momento_evaluacion_id','id');
    }

    public function estatus_invitacion()    {
        return $this->belongsTo('App\Estatus','estatus_invitacion_id','id');
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

    public function invitacion_rechazada(){
        if ($this->estatus_invitacion_id == 5){
            return true;
        }
        return false;
    }

    public function invitacion_aceptada(){
        if ($this->estatus_invitacion_id == 4){
            return true;
        }
        return false;
    }

    public function actualizar_estatus_leida(){
        /*if($this->instrumento->puede_rechazar){
            $this->estatus_invitacion_id = 4; //Invitacion aceptada
        }else{*/
            $this->estatus_invitacion_id = 6; // Invitacion leída
        //}
        $this->save();
    }
    public function actualizar_estatus_recordatorio_enviado(){
        $this->estatus_invitacion_id = 3;
        $this->cantidad_recordatorios += 1;
        $this->save();
    }
    public function actualizar_estatus_completada(){
        $this->estatus_invitacion_id = 7;
        $this->save();
    }
    public function actualizar_estatus_aceptada($acepto){
        if($acepto){
            $this->estatus_invitacion_id = 4;
            $this->save();
        }else{
            $this->estatus_invitacion_id = 5;
            $this->save();
        }
    }

    public function getID(){
        return $this->id;
    }
    public function getToken(){
        return $this->token;
    }
    public function getCvucv_user_id(){
        return $this->cvucv_user_id;
    }
    public function getUsuario_id(){
        return $this->usuario_id;
    }

    public function checkToken($token){
        return $this->getToken() == $token;
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
        $existe = Invitacion::where('instrumento_id', $instrumento_id)
        ->where('momento_evaluacion_id', $momento_evaluacion_activo_id)
        ->where('periodo_lectivo_id', $periodo_lectivo_id)
        ->where('curso_id', $curso_id)
        ->where('cvucv_user_id', $participante_id)
        ->first();

        if($existe === null){
            return false;
        }
        return true;
    }
    public static function invitacionPrevia2($curso_id, $instrumento_id, $periodo_lectivo_id, $momento_evaluacion_activo_id, $participante_id ){
        return Invitacion::where('instrumento_id', $instrumento_id)
        ->where('momento_evaluacion_id', $momento_evaluacion_activo_id)
        ->where('periodo_lectivo_id', $periodo_lectivo_id)
        ->where('curso_id', $curso_id)
        ->where('cvucv_user_id', $participante_id)
        ->first();

    }
    public static function invitaciones_de_un_usuario( $participante_id ){
        return Invitacion::where('cvucv_user_id', $participante_id)->get();
    }
    public static function invitaciones_pendientes_de_un_usuario( $participante_id ){
        return Invitacion::where('cvucv_user_id', $participante_id)
        ->where(function ($query){
            $query->where('estatus_invitacion_id', Estatus::getEstatusCreada())
            ->orWhere('estatus_invitacion_id', Estatus::getEstatusAceptada())
            ->orWhere('estatus_invitacion_id', Estatus::getEstatusLeida())
            ->orWhere('estatus_invitacion_id', Estatus::getEstatusRecordatorio());
        })->get();
    }
    public static function invitaciones_restantes_de_un_usuario( $participante_id ){
        return Invitacion::where('cvucv_user_id', $participante_id)
        ->where(function ($query){
            $query->where('estatus_invitacion_id', Estatus::getEstatusCompletada())
            ->orWhere('estatus_invitacion_id', Estatus::getEstatusRechazada());
        })->get();
    }

    public static function invitarEvaluador($curso_id, $instrumento_id, $periodo_lectivo_id, $momento_evaluacion_activo_id, $participante_id, $tipo_invitacion_id){
       
        $new = new Invitacion();

        $new->token                     = Invitacion::generateToken();
        $new->estatus_invitacion_id     = Estatus::getEstatusCreada();
        $new->tipo_invitacion_id        = $tipo_invitacion_id;
        $new->instrumento_id            = $instrumento_id;
        $new->curso_id                  = $curso_id;
        $new->periodo_lectivo_id        = $periodo_lectivo_id;
        $new->momento_evaluacion_id     = $momento_evaluacion_activo_id;
        $new->cvucv_user_id             = $participante_id;
        $new->cantidad_recordatorios    = 2;
        $new->created_at                = \Carbon\Carbon::now();
        $new->updated_at                = \Carbon\Carbon::now();

        $new->save();

        return $new;
    }

    public static function confirmarMensaje($response){

        if(isset($response[0]['msgid'])){
            if($response[0]['msgid'] == -1){
                return false;
            }
        }elseif(empty($response)){
            return false;
        }
        return true;
    }

    public static function EstatusEvaluacionesCursos (&$estatus, &$estatus_count, $nombre_categoria = null){

        $estatus = [];

        $invitaciones = Invitacion::all();

        $estatusTodos = Estatus::all();

        foreach($estatusTodos as $estatusIndex => $estatusActual){
                $estatus_count[$estatusIndex] = 0;
        }

        if($nombre_categoria != null){
            $id_categoria_padre = CategoriaDeCurso::getCategoriaPorNombre($nombre_categoria);
        }

        foreach($invitaciones as $indexInvitacion => $invitacion){

            $estatusInvitacionActual = $invitacion->estatus_invitacion->getNombre();
            
            if($invitacion->curso != null){

                if( $nombre_categoria == null || $invitacion->curso->categoria->categoria_raiz->getID() == $id_categoria_padre){

                    foreach($estatusTodos as $estatusIndex => $estatusActual){
                        if( $estatusInvitacionActual == $estatusActual->getNombre() ){
                            $estatus[$estatusIndex] = $estatusActual->getNombre();
                            $estatus_count[$estatusIndex]++;
                            break;
                        }
                    } 
                }

            }

            
        }
    }

    public static function messageTemplate($user_profile, $curso, $token){//Mensaje de invitación enviado por el Campus/Correo electronico
        $message = "<div> Estimado ".$user_profile['fullname'].", este es un mensaje de prueba de la aplicación GENETVI, ya que te encuentras matriculado en el curso". $curso->cvucv_fullname."</div>
        <div> <a href=".route('evaluacion_link', ['token' => $token])."> Enlace para evaluar curso ".$curso->cvucv_fullname." </a> </div>";

        return $message;
    }
}
