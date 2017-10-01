<?php require_once("../includes/initialize.php"); ?>

<?php 
//$potrait = new Potrait();
if(isset($_GET['id'])){
	$id = $_GET['id'];
	echo "id: ".$id. "<br>";
	$form = Form::find_by_id($id);
	
	if(intval($id) == 0){
		redirect_to("../edit.php");
		}
	if(isset($_POST['submit'])){
		$form = new Form();	
		$form->name = trim(htmlentities($_POST['name']));
		$form->address = trim(htmlentities($_POST['address']));
		$form->date_of_birth = $_POST['dob'];
		$form->position = $_POST['position'];
		
		$form->updated = strftime("%Y-%m-%d %H:%M:%S", time()+(60*60));
		
		if($form->save($id)){
			//Success
			
			$session->message("Registration was updated successfully. ");
			redirect_to("../edit.php?id=$id");
			//redirect_to("../index.php");
			//redirect_to("../index.php?id=$id");
		}else{
			//Failure
			$errors = join("<br />", $form->errors);
			$session->message($errors);
			redirect_to("../edit.php?id=$id");
		}
	}else{
		//the $_POST is nt submitted
	}
}else{
	redirect_to("../index.php");	
}


?>

