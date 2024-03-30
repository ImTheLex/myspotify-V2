<?php

namespace myspotifyV2\dependencies;
require_once 'DatabaseConnection.php';


use DatabaseConnection;
use DateTime;

class MyModel{

    // Protected variables seem to be inherited by extensions of the Class they're declared in.
    protected $table;
    protected $db;
    protected $rules = [];


    // This construct takes a db connection and then store it in the protected variable. So all the "childrens" may access it.
    // This goes the same way for the table kinda "ORM Eloquent like from laravel"
    // We consider a model should be linked by a table with the same name but on lowerCase and eventually separated by underscores on every capital letter.
    public function __construct() {
        $db = new DatabaseConnection;
        $this->db = $db->get_pdo();
        $className = get_class($this);
        $className = preg_replace('/(?<=\\w)(?=[A-Z])/',"_", $className);
        $this->table = strtolower($className) . 's';
    }

    // This establish an array of rules available in all childrens.
    // So for example in the children model John we decide that the table johns and the field "name" needs to be min 2 lengtht
    // So we call this->rule(['name'=>'min:2']);
    // Then with the validate methods it will go through all the given rules.
    public function rules($rules = null) {
        if ($rules !== null) {
            $this->rules = $rules;
        }
        return $this->rules;
    
    }

    /**
     * @param array $data Takes an array of datas as parameter, for example ['name'=>'John']
     * @param array $rules Regroups the given rules among the children classes, for example ['name'=>'min:3|required']
     */
    public function validate(array $data){
        $rules = $this->rules();
        foreach($rules as $field => $rule){

            if(!isset($data[$field])){
                throw new \Exception("Missing field: $field");
            }
            $value = $data[$field];
            if($rule === 'required' && !$value){
                throw new \Exception("Field $field is required");
            }
            if(preg_match('/min:(\d+)/', $rule, $matches) && strlen($value) < $matches[1]) {
                throw new \Exception("Field $field must be at least {$matches[1]} characters long");
            }
            if($rule === 'birthdate'){
                $date = DateTime::createFromFormat('Y-m-d',$value);
                if(!$date){
                    throw new \Exception("Field $field must be a valid date (format: Y-m-d)");
                }
                $now = new DateTime();
                $interval = $now->diff($date);
                if($interval->y > 100 || $interval->y < 5){
                    throw new \Exception("Field $field must be a date between 5 and 100 years from the current date");
                }
            }
            if($rule === 'password') {
                if(!preg_match('/[A-Z]/',$value)){
                    throw new \Exception("Field $field must contain at least one uppercase letter");
                }
                if(!preg_match('/\d/',$value)){
                    throw new \Exception("Field $field must contain at least one digit");
                }
            }

            var_dump("rules:",$rules,"field:",$field,"rule:",$rule,"data:",$data, $data[$field]);
        }
        // exit;
    }
}
