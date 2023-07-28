<?php
namespace zazaCv;
class Validation {
    public function validateNameAndSurname($value):void{
        $value = trim($value);
        if (!is_string($value)) {
            include("redirectTemplate.html");
            exit("{$value} is not string");
        }elseif(strlen($value) < 2){
            include("redirectTemplate.html");
            exit("{$value} must be at least 2 characters long");        
        }elseif((!preg_match('/^[a-zA-Z\s]+$/', $value))){
            include("redirectTemplate.html");
            exit("{$value} must not contain numbers and special characters");
        }
        
    }
    public function validateDate($date):void {
        $d = explode('-', $date);
        $year = intval($d[0]);
        $month = intval($d[1]);
        $day = intval($d[2]);
        if ((!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) or (!checkdate($month, $day, $year))) {
            include("redirectTemplate.html");
            exit("The date is not Valid");
        }
    }
    public function validateRelationshipStatusAndPhoto($value, $possibleValues):void{
        if(!in_array($value, $possibleValues)){
            include("redirectTemplate.html");
            exit("{$value} is not a valid type");
        }
    }
    public function validatePhoneandEmail($pattern, $value):void{
        $value = str_replace(' ', '', $value);
        if (!preg_match($pattern, $value)) {
            $value = str_replace(' ', '', $value);
            include("redirectTemplate.html");
            exit("{$value} is not a valid ");
        }
    }
}