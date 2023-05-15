<?php

include_once('App/Models/Alumno.php');
include_once('App/Models/Cursada.php');
include_once('App/Models/Examen.php');
include_once('App/Models/Mesa.php');
include_once('Fw/Validation.php');
include_once('App/Middleware/isLogin.php');
include_once('Fw/Response.php');

class AlumnoController{

    /**
     * Informacion basica del alumno
     */
    static function informacion(){
       
   
        Response::view('informacion', [
            'carreras' => Carrera::deAlumno(),
            'default' => Carrera::getDefault(),
            'datos' => Auth::user()
        ]);
    }

    /**
     * Cursadas que ha y esta realizando
     * Tambien informacion sobre si ha rendido el final o no
     */
    static function cursadas(){
       

        Response::view('cursadas', [
            'cursadas' => Cursada::alumno(),
            'finalesAprobados' => ArrayFlatter::flat(Examen::aprobados())
        ]);
    }

    /**
     * Todos los examenes que ha rendido
     */
    static function examenes(){
       
        Response::view('examenes', ['examenes' => Examen::alumno()]);
    }

    /**
     * Pagina para inscribirse y bajarse de las mesas
     */
    static function inscripciones(){

        // materias a las que se puede inscibir junto con sus mesas
        $materias = Alumno::inscribibles();
        //print_r($materias);
        // a cada mesa agregar los dias habiles que faltan
        foreach($materias as $key => $materia){
            $mesas = Mesa::materia($materia->id_asignatura);
            
            foreach($mesas as $keyMesa => $mesa){
                $mesa -> {'diasHabiles'} = DiasHabiles::desdeHoyHasta($mesa->fecha);
                $mesas[$keyMesa] = $mesa;
            }

            $materia -> {'mesas'} = $mesas;
            $materias[$key] = $materia;
        }
   
        // cache (?
        Session::set('alumno_inscribibles', $materias);

        $yaAnotadas = Examen::alumnoAnotado();
        
        include_once('App/Views/inscripciones.php');
    }

    /**
     * Inscribe al alumno en la mesa seleccionada [post]
     */
    static function inscribirAlumno(){
       

        $mesa = Request::value('mesa');

        $inscribibles = Session::exists('alumno_inscribibles')? Session::get('alumno_inscribibles') : Alumno::inscribibles();
        
        $noPuede = true;
        $finBusqueda = false;
        // la materia que selecciono esta en las que puede inscribirse
        // y no caduco la fecha de inscripcion
        foreach($inscribibles as $materia){
            if($finBusqueda) break;

            foreach($materia->mesas as $mesaMateria){
                if($mesaMateria->id_mesa == $mesa){
                    if(DiasHabiles::desdeHoyHasta($mesaMateria->fecha) >= 2) $noPuede = false;
                    else break;
                    $finBusqueda=true;
                }
            }
        }

        if($noPuede) Request::redirect('/alumno/inscripciones',['errores' => ['No puedes anotarte a esta mesa']]);

        if(Examen::yaAnotado($mesa)) Request::redirect('/alumno/inscripciones',['errores' => ['Ya estas anotado en esta mesa']]);

        Examen::anotarAlumno($mesa); 

        Request::redirect('/alumno/inscripciones',['mensajes'=>['Te has anotado a la mesa.']]);
    }

    /**
     * Baja a un alumno de una mesa [post]
     */
    static function desinscribirAlumno(){
       

        if(!Request::has('mesa')) Request::redirect('/alumno/inscripciones');
        
        $mesa = Mesa::select('fecha','id_mesa')
            -> where('id_mesa', Request::value('mesa'))
            -> first();
        
        if(!Examen::yaAnotado($mesa->id_mesa)){
            
            Request::redirect('/alumno/inscripciones', ['mensajes' => ['No estas inscripto en esta mesa.']]);
        }
        
        if(DiasHabiles::desdeHoyHasta($mesa->fecha) <= 1){
            Request::redirect('/alumno/inscripciones',['mensajes'=>['Timpo de desincripcion caducado.']]);
        }

        Examen::bajar($mesa);
        
        Request::redirect('/alumno/inscripciones',['mensajes'=>['Te has dado de baja de la mesa.']]);
    }
}