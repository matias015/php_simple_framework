 <?php

include_once('Fw/Route.php');

class Request{

    static function redirect($path = '/', $data=null){
      if($data){
        foreach($data as $key => $value){
          $_SESSION[$key] = $value;
        }
      }
      header("location: ".Route::route($path));
      exit;
    }


    static function has($ex){
      $method = Route::method();
        
      $values = $method === 'POST'? $_POST : $_GET;

        if(isset($values[$ex])){
          if(strlen(trim($values[$ex],' ')) > 0){
            return true;
          } 
        }

        return false;
    }

    static function scape($value){
      return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
    }

    static function values(...$fields) {
      $data = [];
      if(count($_POST)>0) $data = $_POST;
      if(count($_GET)>0) $data = $_GET; 

      $values = array();
      
      foreach ($fields as $field) {
        if (isset($data[$field])) {
          $values[$field] = Request::scape($data[$field]);
        }
      }
      
      return $values;
    }
    
    static function value($field) {
      if(isset($_GET[$field])) return Request::scape($_GET[$field]);
      if(isset($_POST[$field])) return Request::scape($_POST[$field]);
      return null;
    }

    
  static function bcrypt($wd){
    return password_hash($wd, PASSWORD_DEFAULT);
  }

  static function ip(){
    return $_SERVER['REMOTE_ADDR'];
  }

}

?>
