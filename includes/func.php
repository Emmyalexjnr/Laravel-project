<?php

$errors = [];

function allowed_get_params($allowed_params=[]){
	$allowed_array = [];
	foreach($allowed_params as $param){
		if(isset($_GET[$param])){
			$allowed_array[$param] = $_GET[$param];
		}else{
			$allowed_array[$param] = NULL;
		}
	}
	return $allowed_array;
}
 function validate_presence_on($required_fields){
	 global $errors;
	 foreach($required_fields as $field){
		if(!has_presence($_POST[$field])){
			$error[$field] = " ' ".$field. "' can't be blank";
		}
	 }
}

function has_presence($value){
	$trimmed_value = trim($value);
	return isset($trimmed_value) && $trimmed_value !== "";
}

//options: exact, max, min
//has_length($first_name, ['exact' => 20])
//has_length($first_name, ['min' => 5, 'max' => 100])
function has_length($value, $options=[]){
	if(isset($options['max']) && (strlen($value) > (int)$options['max']) ){
		return false;
	}
	if(isset($options['min']) && (strlen($value) < (int)$options['min']) ){
		return false;
	}
	if(isset($options['exact']) && (strlen($value) != (int)$options['exact']) ){
		return false;
	}
	return true;
}

//(Use \A and \Z, not ^ and $ which allow line returns.)
//has_format_matching('1234', '/\d{4}/') is true
//has_format_matching('12345', '/\d{4}/') is also true
//has_format_matching('12345', '/\A\d{4}\Z/') is false
function has_format_matching($value, $regex='//'){
	return preg_match($regex, $value);
}

//has_number($item_to_order, ['min' => 1, 'max' => 5])
function has_number($value, $options=[]){
	if(!is_numeric($value)){
		return false;
	}
	if(isset($options['max']) && ($value > (int)$options['max']) ){
		return false;
	}
	if(isset($options['min']) && ($value < (int)$options['min']) ){
		return false;
	}
	return true;
}

function has_inclusion_in($value, $set=[]){
	return in_array($value, $set);
}
function has_exclusion_from($value, $set=[]){
	return !in_array($value, $set);
}

?>