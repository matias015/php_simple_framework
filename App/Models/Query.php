<?php 

class Query{

    private $query = "";
    
    protected $model;
    protected $table;
    protected $primaryKey;
    protected $selectable;

    private $queryType = "SELECT";
    private $isFirstSetStatement = true;
    private $conditions = [];
    private $tables = [];
    private $fields = [];
    private $params = [];
    private $needsFromStatement = false;

    private function getQueryType(){
        return $this -> queryType;
    }

    private function setFromStatement(){
        $this -> addToFinalQuery(" FROM " . $this->getLocalTable());
        $this -> needsFromStatement = false;
        return $this;
    }

    private function needsFromStatement(){
        if($this -> needsFromStatement){
            $this -> setFromStatement();
            $this -> needsFromStatement = false;
        }
        return $this;
    }

    private function getLocalTable(){
        $inst = new $this->model();
        if(!$inst -> table) return $this->model . "s";
        return $inst -> table;
    }

    private function getLocalSelectable(){
        $inst = new $this->model();
        if(!$inst -> selectable) return ["*"];
        return $inst -> selectable;
    }

    private function getLocalPrimaryKey(){
        $inst = new $this->model();
        if(!$inst -> primaryKey) return "id";
        return $inst -> primaryKey;
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
        $instance -> model = get_called_class();
        
        if(count($fields) < 1) $fields = $instance->getLocalSelectable();
        
        $instance -> setQueryType("SELECT");
        $instance -> needsFromStatement = true;
        
        $instance -> addToFinalQuery(" " . $instance->parseList($fields));

        return $instance;
    }

    static function insert($table=null){
        $instance = new Query();
        $instance -> setQueryType("INSERT INTO");
        if(!$table){
            $instance -> model = get_called_class();
            $table = $instance -> getLocalTable();
        }
        $instance -> addToFinalQuery(" " . $table);

        return $instance;
    }

    static function update($table=null){
        $instance = new Query();
        $instance -> setQueryType("UPDATE");
        if(!$table) {
            $instance -> model = get_called_class();
            $table = $instance -> getLocalTable();
        }
        $instance -> addToFinalQuery(" $table");

        return $instance;
    }

    static function delete($table=null){
        $instance = new Query();
        $instance -> model = get_called_class();
        
        $instance -> setQueryType("DELETE");
        $instance -> needsFromStatement = true;

        return $instance;
    }

    static function all(...$fields){        
        $instance = new Query();
        $instance -> model = get_called_class();
        $instance -> setQueryType("SELECT");
        $instance -> needsFromStatement = true;

        if(!$fields) $instance -> addToFinalQuery(" *");
        else $instance -> addToFinalQuery(" " . $instance->parseList($fields));
        
        return $instance->exec();
    }

    static function id($id){        
        $instance = new Query();
        $instance -> model = get_called_class();

        $table = $instance -> getLocalTable();
        $pk = $instance -> getLocalPrimaryKey();

        $instance -> addToFinalQuery("SELECT * FROM $table WHERE $pk = ?");
        $instance -> addParam($id);
        
        return $instance->exec();
    }

    public function set($f,$v){
        if($this->isFirstSetStatement){
            $this -> addToFinalQuery(" SET $f = ");
            $this->isFirstSetStatement = false;
        }else{
            $this -> addToFinalQuery(", $f = ");
        }
        
        if(str_starts_with($v, ':')){
            $this -> addToFinalQuery(substr($v,1));
        }else{
            $this -> addToFinalQuery("?");
            $this -> addParam($v);
        }
        return $this;
    }

    public function fields(...$fields){
        $fieldList = $this -> parseList($fields);
        $this -> addToFinalQuery("($fieldList)");
        return $this;
    }

    public function values(...$values){

        $this -> addToFinalQuery(" VALUES(");
        
        
        foreach($values as $key => $value){
            if($key > 0) $this -> addToFinalQuery(", ");
            if(str_starts_with($value, ':')){
                $this -> addToFinalQuery(substr($value,1));
            }else{
                $this -> addToFinalQuery("?");
                $this -> addParam($value);
            }
        }
        $this -> addToFinalQuery(")");
        return $this;
    }

    public function from(...$tables){
        $tables = $this -> parseList($tables);
        if($this -> needsFromStatement) $this -> addToFinalQuery(" FROM " . $tables);
        else $this -> addToFinalQuery(", " . $tables);
        $this -> needsFromStatement = false;
        return $this;
    }

    private function conditionAdder($type,$field,$op,$value=null){

        $this -> needsFromStatement();

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

    private function insertJoin($type,$table, $f1, $f2){
        if(!$f1 && !$f2) $f1 = "$table.".$this -> getLocalPrimaryKey();
        if(!$f2) $f2 = "$table." . explode('.',$f1)[1];
        
        $this -> needsFromStatement();
        $this -> addToFinalQuery(" $type JOIN $table ON $f1 = $f2");
        return $this;
    }

    public function join($table, $f1=null, $f2=null){
        return $this -> insertJoin('',$table, $f1, $f2);
    }
 
    public function leftJoin($table, $f1=null, $f2=null){
        return $this -> insertJoin('LEFT',$table, $f1, $f2);
    }

    public function rightJoin($table, $f1=null, $f2=null){
        return $this -> insertJoin('RIGHT',$table, $f1, $f2);
    }

    public function innerJoin($table, $f1=null, $f2=null){
        return $this -> insertJoin('INNER',$table, $f1, $f2);
    }

    public function group($f){
        $this -> needsFromStatement();
        $this -> addToFinalQuery(" GROUP BY $f");
        return $this;
    }

    public function order($f, $type=''){
        $this -> needsFromStatement();
        $this -> addToFinalQuery(" ORDER BY $f $type");
        return $this;
    }

    public function exec(){  
        // echo $this ->query;
        $this -> needsFromStatement();
        return DB::query($this->query,$this->params);
    }

    public function getQueryString(){
        $this -> needsFromStatement();
        return $this->query;
    }
    
    public function first(){  
        $this -> needsFromStatement();
        return DB::queryFirst($this->query, $this->params);
    }

}