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
            -> first();

        return $alumno;
    }

    static function buscarMailPassword($data){
        $user = Alumno::select("*")
            -> where('email', $data['correo'])
            -> first();

        if($user && password_verify($data['password'], $user->password)) return $user;
        return false;

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

    static function verificarMail($mailToken){
        Alumno::update()->set('verificado',':1')->exec();
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