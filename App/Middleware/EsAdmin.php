<?php
class EsAdmin{

    static function check(){
        if(Session::exists('Admin')) return;
        else Request::redirect('/admin/login');
    }

}