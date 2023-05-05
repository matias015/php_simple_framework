<?php 

class Query{

    private $query = "";
    protected $table;
    private $queryType = "SELECT";
    private $conditions = [];
    private $tables = [];
    private $fields = [];
    private $params = [];

    private function getQueryType(){
        return $this -> queryType;
    }

    private function setQueryType($type){
        $this -> queryType = $type;
        $this -> addToFinalQuery($this->getQueryType());
    }

    private function addToFinalQuery($str){
        $this -> query = $this -> query . $str;
    }

    private function parseList($f){
        return implode(',', $f);
    }

    private function addParam($v){
        $this -> params[] = $v;
    }

    static function select(...$fields){
        $instance = new Query();
        $instance -> setQueryType("SELECT");
        
        $instance -> addToFinalQuery(" " . $instance->parseList($fields));

        return $instance;
    }

    public function from(...$tables){
        $tables = $this -> parseList($tables);
        $this -> addToFinalQuery(" FROM " . $tables);
        return $this;
    }

    private function conditionAdder($type,$field,$op,$value=null){
        if(!$value) {
            $value = $op; 
            $op = "=";
        }

        if($op === "NOT IN" || $op === "IN"){
            $this -> addToFinalQuery(" $type $field $op ($value)");
            return;    
        }
            
        if(str_starts_with($value, ':')){
            $this -> addToFinalQuery(" $type $field $op ".substr($value,1));
            return;
        }

        $this -> addToFinalQuery(" $type $field $op ?");
        $this -> addParam($value);
        return;
    }

    public function where($field,$op,$value=null){
        $this -> conditionAdder("WHERE",$field,$op,$value);
        return $this;
    }

    public function andWhere($field,$op,$value=null){
        $this -> conditionAdder("AND",$field,$op,$value);
        return $this;
    }

    public function orWhere($field,$op,$value=null){
        $this -> conditionAdder("OR",$field,$op,$value);
        return $this;
    }

    public function join($table, $f1, $f2){
        $this -> addToFinalQuery(" JOIN $table ON $f1 = $f2");
        return $this;
    }
 
    public function leftJoin($table, $f1, $f2){
        $this -> addToFinalQuery(" LEFT JOIN $table ON $f1 = $f2");
        return $this;
    }

    public function exec(){  
        return DB::query($this->query,$this->params);
    }
    
    public function first(){  
        return DB::queryFirst($this->query, $this->params);
    }

}