<?php
require_once('Query.php');
require_once('Fw/Auth.php');
require_once('App/Services/FlatArray.php');
require_once('App/Models/Examen.php');
require_once('App/Models/Cursada.php');
require_once('App/Models/Correlativa.php');

class Alumno extends Query{

    protected $primaryKey = "id";
    protected $selectable = ['id','dni','nombre','apellido','email','telefono1',];

    static function sinRegistrar($correo){
        $alumno = Alumno::select('*')
            -> where('email', $correo)
            -> andWhere('password','0')
            -> exec();

        return $alumno;
    }

    static function buscarMailPassword($data){
        $data['password'] = md5($data['password']);

        $user = Alumno::select("*")
            -> where('email', $data['correo'])
            -> andWhere('password', $data['password'])
            -> first();

        if(!$user) return false;
        else return $user;
    }

    static function setPasword($data){        
        $data['password'] = md5($data['password']);

        return Alumno::update()
            -> set('password', $data['password'])
            -> where('email',$data['email'])
            -> exec();
    }

    static function setVerificacionToken($mail,$token){
        Alumno::update()
            -> set('mail_token', $token)
            -> where('correo', $mail)
            -> exec();
    }

    static function unsetVerificacionToken($token){
        DB::query("UPDATE alumnos SET alumnos.mail_token=NULL WHERE alumnos.mail_token=?",[$token]);
    }
    
    static function verificarMail($mailToken){
        Alumno::update()->set('verified',':1')->where('mail_token',$mailToken)->exec();
        //DB::query('UPDATE alumnos SET verified=1 WHERE mail_token=?',[$mailToken]);
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

            $correlativas = correlativa::de($materia -> id_asignatura);
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