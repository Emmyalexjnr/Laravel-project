<?php
//require_once(LIB_PATH.DS.'user.php');   
 
class Session{
	
	private $logged_in = false;
	public $user_id;
	public $id;
	public $message;
	public $access;
	public $login_time;
	
	function __construct(){
		session_start();
		$this->check_login();
		$this->check_message();
		//$this->check_session_id();
		$this->check_user();
		if($this->logged_in){
		//actions to take right away if user is logged in
			
		}else{
		//actions to take right away if user is not logged in	
		}
	}
	
	public function is_logged_in(){
		return $this->logged_in;	
	}
	
	
	public function login($user){
	//database should find user based on username/password
	if($user){
		$this->user_id = $_SESSION['user_id'] = $user->id;
		$this->access = $_SESSION['access'] = $user->access;
		$this->login_time = $_SESSION['login_time'] = strftime("%Y-%m-%d %H:%M:%S", time()+(60*60));
		$this->logged_in = true;
		}
	}
	
	public function logout(){
		unset($_SESSION['user_id']);
		unset($this->user_id);
		unset($_SESSION['access']);
		unset($this->access);
		$this->logged_in = false;	
	}
	
	

	private function check_login(){
		if(isset($_SESSION['user_id'])){
			$this->user_id = $_SESSION['user_id'];
			$this->logged_in = true;
		}else{
		unset($this->user_id);
		$this->logged_in = false;	
			
		}
	}
	
	private function check_user(){
		if(isset($_SESSION['access'])){
			$this->access = $_SESSION['access'];
			//unset($_SESSION['access']);
		}else{
			$this->access = "";	
		}
	}
	public function session_id($id=""){
		if(!empty($id)){
			$_SESSION['id'] = $id;
		}else{
			if(isset($_SESSION['id'])){
				$this->id = $_SESSION['id'];
				unset($_SESSION['id']);
			}
			//unset($_SESSION['id']);
			return $this->id;
		}
	}
	// private function check_session_id(){
	// 	//Is there a message stored in the session?
	// 	if(isset($_SESSION['id'])){
	// 	//Add it as an attribute and erase the stored version
	// 		$this->id = $_SESSION['id'];
	// 		//unset($_SESSION['id']);
	// 	}else{
	// 		$this->id = "";
	// 	}
	// }
	public function message($msg=""){
		if(!empty($msg)){
			$_SESSION['message'] = $msg;
		}else{
			return $this->message;
		}
	}
	private function check_message(){
		//Is there a message stored in the session?
		if(isset($_SESSION['message'])){
		//Add it as an attribute and erase the stored version
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		}else{
			$this->message = "";
		}
	}
	
}

$session = new Session();
$message = $session->message();
$id = $session->session_id();

?>