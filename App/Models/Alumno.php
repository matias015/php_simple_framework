<?php
require_once('querys.php');
require_once('Fw/Auth.php');
require_once('App/Services/FlatArray.php');
require_once('App/Models/Examen.php');
require_once('App/Models/Cursada.php');
require_once('App/Models/Correlativa.php');


class Alumno extends DB{

    static function sinRegistrar($correo){
        $alumno = DB::queryFirst("SELECT * FROM alumnos WHERE CORREO=:correo AND password IS NULL",$correo,true);
        return $alumno;
    }

    static function buscarMailPassword($data){
        $data['password'] = md5($data['password']);

        $user=DB::queryFirst("SELECT * FROM alumnos WHERE correo=:correo AND password=:password", $data);
        if(!$user) return false;
        else return $user;
    }

    static function setPasword($data){
        $email = $data[0];
        $pw = md5($data[1]);
        return DB::query("UPDATE alumnos SET alumnos.password = ? WHERE alumnos.correo = ? ",[$pw,$email]);
    }

    static function setVerificacionToken($mail,$token){
        DB::query("UPDATE alumnos SET alumnos.mail_token=? WHERE alumnos.correo=?",[$token,$mail]);
    }

    static function unsetVerificacionToken($token){
        DB::query("UPDATE alumnos SET alumnos.mail_token=NULL WHERE alumnos.mail_token=?",[$token]);
    }
    
    static function verificarMail($mailToken){
        DB::query('UPDATE alumnos SET verified=1 WHERE mail_token=:token',$mailToken);
        Alumno::unsetVerificacionToken($mailToken);
    }
        
    // materias a las que el alumno se puede inscribir a final
    // falta: comprobar que haya mesas para esas materias
    static function inscribibles(){
        $exAprob = Examen::aprobados();
        $exAprobString = implode(',',ArrayFlatter::flat($exAprob));

        $sinRendir = Cursada::aprobadasSinRendir($exAprobString);

        $posibles=[];

        foreach($sinRendir as $materia){
            $puede=true;

            $correlativas = correlativa::de($materia['ID_ASIGNATURA']);
            if(count($correlativas)>0){
                foreach($correlativas as $correlativa){
                    if(!in_array($correlativa,$exAprob)){
                        $puede=false;
                    }
                }
            }
            if($puede) $posibles[]=$materia;    
        }
        return $posibles;
    }

    static function yaEstaEnMesa(){
        $id = Auth::user()['ID_USUARIO'];

        //DB::query();
    }

    

}