<?php

class Validator {


    private $request;
    private $errors = [];

    public function __construct($request) {
        $this->request = $request;
    }


    /**
     * Will take as parameters an array of input fields.
     * If one of the given fields doesn't match with the request, or if it does but is empty string.
     * Then it will push an error with the field name as key.
     * Else if will increase the given request key with a new filtered and trimed value.
     */
    public function validate_fields(array $fields) {
        foreach ($fields as $field) {
            if (!isset($this->request[(string)$field]) || $this->request[(string)$field] === "" ) {
                $this->errors[$field] = "<p style='color:red'>Le champ {$field} est vide</p>";
            } else {
                $this->request[$field] = htmlspecialchars(trim($this->request[(string)$field]));
            }
        }
        // Vardump gives some juicy info on how it works.
        // var_dump($this->get_errors(),$fields,$field,$this->request);
        // exit;
    }
   
    /**
     * Va retourner des erreurs s'il y en a.
     */
    public function get_errors(){
        return $this->errors;
    }
    /**
     * Va retourner la requete filtrée par validate_fields
     */
    public function get_request(){
        return $this->request;
    }
}