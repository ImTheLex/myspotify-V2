<?php
    namespace myspotifyV2\Requests;

class Validator {


    private $request;
    private $errors = [];
    
    public function __construct($request) {
        $this->request = $request;
    }


    /**
     * Will take as parameters an array of input fields. If one of the given fields is empty string.Then it will push an error with the field name as key. Else if will overwrite the given request key with a new filtered and trimed value.
     */
    public function validate_fields() {

        foreach ($this->request as $field => $value) {

            if (preg_match('/^b[A-Z]/', $field) && empty($value)) {
                continue;
            }
            if (!isset($value) || $value === "" ) {
                $this->errors[$field] = "<p style='color:red'>Le champ {$field} est vide</p>";
            } else {
                $this->request[$field] = htmlspecialchars(trim($value));
            }
        }
        return $this;
        // die(var_dump($this->get_errors(),$fields,$field,$this->request));    
    }
   
    /**
     * Returns the errors.
     */
    public function get_errors(){
        return $this->errors;
    }
    /**
     * Returns the request.
     */
    public function get_request(){
        return $this->request;
    }
}