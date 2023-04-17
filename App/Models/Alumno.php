<?php
require_once('querys.php');
require_once('Fw/Auth.php');
require_once('App/Services/FlatArray.php');
require_once('App/Models/Examen.php');
require_once('App/Models/Cursada.php');
require_once('App/Models/Correlativa.php');


class Alumno extends DB{

    static function sinRegistrar($mail){
        $alumno = DB::queryFirst("SELECT * FROM alumnos WHERE CORREO=? AND password IS NULL",[$mail],true);
        print_r($alumno);
        return $alumno;
    }

    static function buscarMailPassword($data){
        $email = $data['email']; $pw=md5($data['password']);

        $user=DB::queryFirst("SELECT * FROM alumnos WHERE correo=? AND password=?",[$email,$pw]);
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

    static function unsetVerificacionToken($mail,$token){
        DB::query("UPDATE alumnos SET alumnos.mail_token=NULL WHERE alumnos.correo=?",[$mail]);
    }

    
    static function verificarMail($mailToken){
        DB::query('UPDATE alumnos SET verified=1 WHERE correo=? AND mail_token=?',$mailToken);
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

}