<?php
class csrfTokenMiddle{

    static function check(){
        if(!isset($_SESSION['csrf']) || !isset($_POST['csrf'])) Request::redirect('/405');
        if(Session::getAndDelete('csrf')!= $_POST['csrf']) Request::redirect('/405');
    }

}