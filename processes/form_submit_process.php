<?php require_once("../includes/initialize.php"); ?>
<?php

if(isset($_POST['submit'])){
	$form = new Form();	
	$form->name = trim(htmlentities($_POST['name']));
	$form->address = trim(htmlentities($_POST['address']));
	$form->date_of_birth = $_POST['dob'];
	$form->position = $_POST['position'];
	$id = $form->save();
	if($id){
		$session = new Session();
		$session->session_id($id);
		//Success
		$session->message("Successfully registration.");
		redirect_to("../index.php");
	}else{
		//Failure
		$errors = join("<br />", $form->errors);
		$session->message($errors);
		//$message = join("<br />", $form->errors);
		redirect_to("../index.php");
	}
}

?>