<?php

namespace myspotifyV2\dependencies;
require_once 'DatabaseConnection.php';

class MyModel{

    // Protected variables seem to be inherited by extensions of the Class they're declared in.
    protected $table;
    protected $db;
    protected $rules = [];


    // This construct takes a db connection and then store it in the protected variable. So all the "childrens" may access it.
    // This goes the same way for the table kinda "ORM Eloquent like from laravel"
    // We consider a model should be linked by a table with the same name but on lowerCase and eventually separated by underscores on every capital letter.
    public function __construct() {
        $db = new DatabaseConnection();
        $this->db = $db->get_pdo();
        $className = get_class($this);
        $className = preg_replace('/(?<=\\w)(?=[A-Z])/',"_", $className);
        $this->table = basename(strtolower($className)) . 's';
        // die(var_dump($className,$this->table,$this->db));

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
     * This will be a global class validator, not supposed to directly validate a request but at least will force datas to be in a desired format before inserting in db.
     * The thing is kinda complex as it doesn't care about case_sensitive, as it does just check if the input name matches close enough from what's expected in the datase.
     * @param array $data Takes an array of datas as parameter, for example ['name'=>'John']
     * @param array $rules Regroups the given rules among the children classes, for example ['name'=>'min:3|required']
     * @param array $inputnames is what html input names may look like ['userNamE'==='username OR 'name']
     * Once again, this function is the last stand verification before inserting in database.
     * Its main purpose is not to filter empty fields, nor trim, I leave that for a request validator.
     * 
     */
    public function validate(array $data, $rules){

        $counter = null;
        foreach($data as $inputName => $value) {
            foreach($rules as $field => $ruleset){
            // var_dump($counter,$inputName,$field,strpos(strtolower($inputName), strtolower($field)));
                if (strpos(strtolower($inputName), strtolower($field)) !== false) {
                    $counter ++;
                    $rulesexploded = explode('|', $ruleset);
                    foreach($rulesexploded as $rule) {
                        if(!isset($data[$inputName])){
                            throw new \Exception("Missing field: $field");
                        }
                        $value = $data[$inputName];
                        if($rule === 'required' && !$value && $value !== '0'){
                            throw new \Exception("Field $field is required");
                        }
                        if($rule === 'int' && !is_numeric($value)){
                            throw new \Exception("Field $field is not a number");
                        }
                        if(preg_match('/min:(\d+)/', $rule, $matches) && strlen($value) < $matches[1]) {
                            throw new \Exception("Field $field must be at least {$matches[1]} characters long");
                        }
                        if(preg_match('/max:(\d+)/',$rule,$matches) && strlen($value) > $matches[1]) {
                            throw new \Exception("Field $field must be no more than {$matches[1]} characters long");
                        }
                        if($rule === 'birthdate'){
                            $date = \DateTime::createFromFormat('Y-m-d',$value);
                            if(!$date){
                                throw new \Exception("Field $field must be a valid date (format: Y-m-d)");
                            }
                            $now = new \DateTime();
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
                    }
                }
            }
        }
        if($counter < count($data) -1){
            // var_dump($counter,count($data));
            // exit;
            return false;
        }else{
            return true;
        }
    }

    /**
     * Executes a query in a short form will directly return a result in case the request is Insert or Update.
     * @param string $sql The sql takes the whole query.
     * @param array $params The params takes the parametters.
    */
    public function query($sql, $params = []) {
        $request = $this->db->prepare($sql);
        $request->execute($params);
        if(strpos(strtoupper($sql),'SELECT') === 0) {
            return $request;
        }
        elseif (strpos(strtoupper($sql), 'INSERT') === 0) {
            return $this->db->lastInsertId();
        }
        elseif (strpos(strtoupper($sql), 'UPDATE') === 0 || strpos(strtoupper($sql), 'DELETE') === 0) {
            $result = $request->rowCount() > 0 ? true : 0;
            return $result;    
        }
        return false;

    }
}
