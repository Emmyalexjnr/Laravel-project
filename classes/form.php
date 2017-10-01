<?php 
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'session.php');



class Form extends DatabaseObject{

	protected static $table_name = "form_submission";
	protected static $db_fields = array('id', 'name', 'address', 'date_of_birth', 'position', 'created', 'updated');
	public $id;
	public $name;
	public $address;
	public $date_of_birth;
	public $position;
	public $created;
	public $updated;
	
	public $errors = array();

	protected function validate(){
		if(strlen($this->name) >= 255){
				$this->errors[] = "Please Name cannot be more than 255 characters long.";
				//return false;
			}
			if(empty($this->name)){	
				$this->errors[] = "Please type in a Name";
				//return false;
			}
			if(strlen($this->address) >= 255){
				$this->errors[] = "Please Address should not be more than 255 long.";
				//return false;
			}
			if(empty($this->address)){	
				$this->errors[] = "Please type in an Address";
				//return false;
			}
			if(empty($this->date_of_birth)){	
				$this->errors[] = "Please type in your date of birth";
				//return false;
			}
	}

	
	public function save($id=""){

		if($id != ""){

			//$this->updated = strftime("%Y-%m-%d %H:%M:%S", time()+(60*60));
			$this->validate();
			if(!empty($this->errors)){ return false;}
				if($this->update($id)){
					return true;
				}else{
					$this->errors[] = "The form was not able to update, please check your details and try again.";
					return false;
				}
			//return $rowcount;
				// if($this->update($id)){
				// 	return true;
				// }else{
				// 	$this->errors[] = "The form was not able to update, please check your details and try again.";
				// 	return false;
				// }
				
			}else{
			
			$this->validate();
			if(!empty($this->errors)){ return false;}
			
			$this->created = strftime("%Y-%m-%d %H:%M:%S", time()+(60*60));
			$this->updated = strftime("%Y-%m-%d %H:%M:%S", time()+(60*60));
			if($this->create()){
				// $session = new Session();
				// $session->session_id($this->id);
				//return true;
				return $this->id;
			}else{
				$this->errors[] = "The form Submission failed, please check your details and try again.";
				return false;
			}

			
		}
	}

	
}

$form = new Form();
?>