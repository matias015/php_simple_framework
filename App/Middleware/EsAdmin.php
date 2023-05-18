<?php
class EsAdmin{

    static function check(){
        if(!Auth::isLogin('admin')){
            Request::redirect('/');
            return false;
        }
    }

}