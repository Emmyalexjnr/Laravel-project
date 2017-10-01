<?php 
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'session.php');


class User extends DatabaseObject { 

	protected static $table_name = "users";
	protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name', 'access', 'email', 'filename', 'type', 'size','phone','created');
	//protected static $db_fields_user = array('id', 'username', 'password', 'first_name', 'last_name', 'access', 'email');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $email;
	public $access;
	public $filename;
	public $type;
	public $size;
	public $phone;
	public $created;
	protected $upload_dir = "user_image";
	public $errors = array();
	protected $upload_errors = array(
	UPLOAD_ERR_OK 		  => "No errors.",
	UPLOAD_ERR_INI_SIZE   => "larger than upload_max_filesize.",
	UPLOAD_ERR_FORM_SIZE  => "Larger than form MAX_FILE_SIZE.",
	UPLOAD_ERR_PARTIAL	  => "partial upload.",
	UPLOAD_ERR_NO_FILE	  => "No file.",
	UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
	UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
	UPLOAD_ERR_EXTENSION  => "File upload stopped by extension."
);

	public function full_name(){
		if(isset($this->first_name) && isset($this->last_name)){
			return $this->first_name . " ". $this->last_name;
		}else{
			return " ";
		}
	}
	
	public function image_path(){
		return $this->upload_dir.DS.$this->filename;	
	}

	public function default_image_path(){
		$default_img = 'img.jpg';
		return $this->upload_dir.DS.$default_img;	
	}
	public function target_path(){
		return SITE_ROOT.DS.'public'.DS.$this->image_path();	
	}

	public static function authenticate($username="", $password=""){
		global $database;
		$sql = "SELECT * FROM users ";
		$sql .= "WHERE username = :username ";
		$sql .= "AND password = :password ";
		$sql .= "LIMIT 1";
		$stmt = $database->prepare($sql);
		$stmt->execute(array(
			':username' => $username,
			':password' => $password
		));
		while($row = $stmt->fetch(PDO::FETCH_OBJ)){
			//return $row;
			return !empty($row) ? $row : false;	
		}

	}
	
	public function userN_E_exist($email=false, $field){
		global $database;
		$sql = "SELECT * FROM ".static::$table_name;
		if($email){
			$sql .= " WHERE email = :email";
			}else{
			$sql .= " WHERE username = :username";
		}
		$sql .= " LIMIT 1";	
		$stmt = $database->prepare($sql);
		if($email){
			$stmt->execute(array(':email' => $this->email));	
			}else{
			$stmt->execute(array(':username' => $this->username));
		}	
		if($stmt->rowCount() > 0){
			if($email){
				$this->errors[] = "This " .$field." ".$this->email." already exist";
			}else{
				$this->errors[] = "This " .$field." ".$this->username." already exist";
			}
			return false;
			}
		}

	
	public function size_as_text(){
		if($this->size < 1024){
			return "{$this->size} btyes";	
		}elseif($this->size < 1048576){
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		}else{
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}
	
	public function select_user(){
		global $database;
		$sql = "SELECT access FROM ".static::$table_name;
		$sql .= " WHERE id = :id";
		$sql .= " LIMIT 1";	
		$stmt = $database->prepare($sql);
		if(!empty($_SESSION['user_id'])){
			$stmt->execute(array(':id' => $_SESSION['user_id']));
			$result_sets = $stmt->fetch(PDO::FETCH_ASSOC);
			return array_shift($result_sets);
		}
	}
	
	public function attach_file($file){
		//Perform error checking on the form parameters
		if(!$file || empty($file) || !is_array($file)){
			$this->errors[] = "No file was uploaded.";
			return false;
		}elseif($file['error'] != 0){
			$this->errors[] = $this->upload_errors[$file['error']];
			return false;
		}else{
			//Set object attributed to the form parameters.
			$this->temp_path = $file['tmp_name'];
			$this->filename  = basename($file['name']);
			$this->type 	 = $file['type'];
			$this->size 	 = $file['size'];
			$this->created = strftime("%Y-%m-%d %H:%M:%S", time()+(60*60));
			return true;
		}
	
	}
	
	protected function check_error(){
		if(!isset($this->first_name) || empty($this->first_name)){
			$this->errors[] = "Please input your First Name";
			return false;
		}
		elseif(strlen($this->first_name) >= 50){
			$this->errors[] = "Please the charaters in First Name should not be more than 50";
			return false;
		}
		elseif(!isset($this->last_name) || empty($this->last_name)){
			$this->errors[] = "Please input your Last Name";
			return false;
		}
		elseif(strlen($this->last_name) >= 50){
			$this->errors[] = "Please the charaters in Last Name should not be more than 50";
			return false;
		}
		elseif(!isset($this->username) || empty($this->username)){
			$this->errors[] = "Please input a User Name";
			return false;
		}
		$this->userN_E_exist($email=false, 'Username');
		if(!isset($this->password) || empty($this->password)){
			$this->errors[] = "Please input a Password";
			return false;
		}
		if(strlen($this->password) >= 10){
			$this->errors[] = "Please the charaters in Password should not be more than 10";
			return false;
		}
		$this->userN_E_exist($email=true, 'Email');
		
	
	}

	public function save_user($file){
		if(isset($this->id)){
			$this->update_all();
		}else{
			$this->check_error();
			if(!empty($this->errors)){ return false;}
			if(!empty($file) && $file['error'] !== 4){
				echo "this is a test";
				$this->attach_file($file);
				$target_path = SITE_ROOT .DS. 'public' .DS. $this->upload_dir .DS.$this->filename;
				
				if(empty($this->filename) || empty($this->temp_path)){
					$this->errors[] = "The file location was not available.";
					return false;
				}
				
				if(file_exists($target_path)){
					$this->errors[] = "The Profile Picture ".$this->filename." already exists.";
					return false;
				}
				if(move_uploaded_file($this->temp_path, $target_path)){
				//Success
				//Save a corresponding entry to the database
					if($this->create()){
						unset($this->temp_path);
						return true;
					}
				}else{
				//Failure
					$this->errors[] = "could not move profile picture.";
					return false;
				}
			}else{
				if(empty($this->email)){
					$this->email = "";
				}
				$this->filename = "1.jpg";
				$this->size = 0;
				$this->type = 0;	
			}

		if($this->create()){
				return true;
			}else{
				$this->errors[] = "This form registration failed, Please recheck your details 
				and try again. Thank You.";
				return false;
			}

		}
	
	}

	public function create_thumbnail($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
	//folder path setup
		$target_path = $target_folder;
		$thumb_path = $thumb_folder;
		
		//file name setup
		$filename_err = explode(".",$_FILES[$field_name]['name']);
		$filename_err_count = count($filename_err);
		$file_ext = $filename_err[$filename_err_count-1];
		if($file_name != ''){
			$fileName = $file_name.'.'.$file_ext;
		}else{
			$fileName = $_FILES[$field_name]['name'];
		}
		
		//upload image path
		$upload_image = $target_path.basename($fileName);
		
		//upload image
		if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
		{
			//thumbnail creation
			if($thumb == TRUE)
			{
				$thumbnail = $thumb_path.$fileName;
				list($width,$height) = getimagesize($upload_image);
				$thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
				switch($file_ext){
					case 'jpg':
						$source = imagecreatefromjpeg($upload_image);
						break;
					case 'jpeg':
						$source = imagecreatefromjpeg($upload_image);
						break;
					case 'png':
						$source = imagecreatefrompng($upload_image);
						break;
					case 'gif':
						$source = imagecreatefromgif($upload_image);
						break;
					default:
						$source = imagecreatefromjpeg($upload_image);
				}
				imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
				switch($file_ext){
					case 'jpg' || 'jpeg':
						imagejpeg($thumb_create,$thumbnail,100);
						break;
					case 'png':
						imagepng($thumb_create,$thumbnail,100);
						break;
					case 'gif':
						imagegif($thumb_create,$thumbnail,100);
						break;
					default:
						imagejpeg($thumb_create,$thumbnail,100);
				}
			}

			return $fileName;
		}
		else
		{
			return false;
		}
	}

	public function make_thumbnail($file, $target_folder = '', $file_name = '', $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
		$target_path = $target_folder;
		$thumb_path = $thumb_folder;
		
		//file name setup
		//$filename_err = explode(".",$_FILES[$field_name]['name']);
		$filename_err = explode(".",$file['name']);
		$filename_err_count = count($filename_err);
		$file_ext = $filename_err[$filename_err_count-1];
		if($file_name != ''){
			$fileName = $file_name.'.'.$file_ext;
		}else{
			$fileName = $file['name'];
		}
		//upload image path
		$upload_image = $target_path.'/'.basename($fileName);
		//thumbnail creation
		$thumbnail = $thumb_path.'/'.$fileName;
		list($width,$height) = getimagesize($upload_image);
		$thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
		switch($file_ext){
			case 'jpg':
				$source = imagecreatefromjpeg($upload_image);
				break;
			case 'jpeg':
				$source = imagecreatefromjpeg($upload_image);
				break;
			case 'png':
				$source = imagecreatefrompng($upload_image);
				break;
			case 'gif':
				$source = imagecreatefromgif($upload_image);
				break;
			default:
				$source = imagecreatefromjpeg($upload_image);
		}
		imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
		switch($file_ext){
			case 'jpg' || 'jpeg':
				imagejpeg($thumb_create,$thumbnail,100);
				break;
			case 'png':
				imagepng($thumb_create,$thumbnail,100);
				break;
			case 'gif':
				imagegif($thumb_create,$thumbnail,100);
				break;
			default:
				imagejpeg($thumb_create,$thumbnail,100);
		}

		//return $fileName;

	}

	protected function check_email_exist(){
		global $database;
		$sql = "SELECT * FROM ".static::$table_name;
		$sql .= " WHERE email = :email";
		$sql .= " LIMIT 1";	
		$stmt = $database->prepare($sql);
		$stmt->execute(array(':email' => $this->email));
		return $result = $stmt->rowCount();		
	}		
	protected function check_phone_exist(){
		global $database;
		$sql = "SELECT * FROM ".static::$table_name;
		$sql .= " WHERE phone = :phone";
		$sql .= " LIMIT 1";	
		$stmt = $database->prepare($sql);
		$stmt->execute(array(':phone' => $this->phone));
		return $result = $stmt->rowCount();
	}	
	protected function check_pix_exist($filename){
		global $database;
		$sql = "SELECT * FROM ".static::$table_name;
		$sql .= " WHERE filename = :filename";
		$sql .= " LIMIT 1";	
		$stmt = $database->prepare($sql);
		$stmt->execute(array(':filename' => $filename));
		return $result = $stmt->rowCount();
	}			

	public function save_comment_user($file){
		$target_upload = SITE_ROOT .DS. 'blog' .DS.'user_image';
		$target_upload_thumb = SITE_ROOT .DS. 'blog' .DS.'user_image'.DS.'thumb';
		if(!isset($this->first_name) || empty($this->first_name)){
			$this->first_name = "Anonymous";
		}
		if(!isset($this->last_name) || empty($this->last_name)){
			$this->last_name = "Anonymous";
		}
		if(!isset($this->username) || empty($this->username)){
			$this->username = "Anonymous";
		}
		if(!isset($this->password) || empty($this->password)){
			$this->password = "";
		}
		if(!isset($this->phone) || empty($this->phone)){
			$this->phone = 0;
		}
		if(!isset($this->email) || empty($this->email)){
			$this->email = "email@alex_innovation.com";
		}
		$phone_result = $this->check_phone_exist();
		$email_result = $this->check_email_exist();
		$pix_result = $this->check_pix_exist($file['name']);
		// check whether phone number exists
		if($phone_result == 1){
			//if it exists and a profile picture was uploaded move the uploaded file
			//Then return false: meaning stop processing and leave
			if($file['error'] == 0){
				$target_path = SITE_ROOT .DS. 'blog' .DS.'user_image'.DS.$file['name'];
				$temp_path = $file['tmp_name']; 
				move_uploaded_file($temp_path, $target_path);
				$this->make_thumbnail($file,$target_upload,'',$target_upload_thumb,'50','50');
			}
			//$this->errors[] = "This phone exists ";
			return false;
		// check whether Email exists	
		}elseif($email_result == 1){
			//if it exists and a profile picture was uploaded move the uploaded file
			//Then return false: meaning stop processing and leave
			if($file['error'] == 0){
				$target_path = SITE_ROOT .DS. 'blog' .DS.'user_image'.DS.$file['name'];
				$temp_path = $file['tmp_name']; 
				move_uploaded_file($temp_path, $target_path);
				$this->make_thumbnail($file,$target_upload,'',$target_upload_thumb,'50','50');
			}
			//$this->errors[] = "This email exists ";
			return false;
		}elseif($pix_result == 1){
			//$this->errors[] = "This pix exists ";
			return false;
		}
		
		//error = 4 means no file was uploaded
		// Assign variables to the contents of $FILES
		if($file['error'] == 4){
			$this->filename = '1.jpg';
			$this->size = 0;
			$this->type = "image/jpeg";
			$this->created = strftime("%Y-%m-%d %H:%M:%S", time()+(60*60));
			$this->create();
			return true;
		}else{
			$this->attach_file($file);
			$target_path = SITE_ROOT .DS. 'blog' .DS.'user_image'.DS.$this->filename;
			if(empty($this->filename) || empty($this->temp_path)){
				$this->errors[] = "The file location was not available.";
				return false;
			}
			if(move_uploaded_file($this->temp_path, $target_path)){
				$this->make_thumbnail($file,$target_upload,'',$target_upload_thumb,'50','50');
			//Success
			//Save a corresponding entry to the database
				if($this->create()){
					unset($this->temp_path);
					return true;
				}else{
					//$this->errors[] = "The files couldn't be inserted into the table.";
					return false;
				}
			}else{
			//Failure
				$this->errors[] = "could not move profile picture.";
				return false;
			}
		}
		
		
	}
	


}//closing Tag for the Class

	
	


$user = new User();
?>