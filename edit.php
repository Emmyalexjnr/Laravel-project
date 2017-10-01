<?php 
require_once("includes/initialize.php");
?>
<?php 
//$potrait = new Potrait();
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $form = Form::find_by_id($id);
    if(intval($id) == 0){
        redirect_to("index.php");
        }
    //echo "id: ".$id;
    //var_dump($form);
    //echo $form->id;
}else{
    redirect_to("index.php");   
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>Submit Form</title>

<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />

<!-- Insert to your webpage before the </head> -->
<script type="application/javascript" src="js/jquery-1.11.3.min.js"></script>


    <!-- End of head section HTML codes -->
</head>

<body>
<div class="container-fluid">
    <h2>Naveteur Test</h2>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title">Form submission</h2>
        </div>
        <div class="panel-body">
        
        <?php if(!empty($message)) { ?>
            <div class="alert alert-success" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong><?php echo $message; ?></strong>
            </div>
        <?php } ?>    
            <form method="POST" action="processes/edit_process.php?id= <?php echo urlencode($form->id); ?>">
                <div class="form-group">
                    <label for="name"> Name: </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                        <input id="name" class="form-control" type="text" name="name" value="<?php echo $form->name; ?>" placeholder="Name.." required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="address"> Address: </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker"></i></span>
                        <input id="address" class="form-control" type="text" name="address" value="<?php echo $form->address; ?>" placeholder="Address..." required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="dob"> Date of Birth: </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar-check-o"></i></span>
                        <input id="dob" class="form-control" type="Date" name="dob" value="<?php echo $form->date_of_birth; ?>" placeholder="Name.." required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="position"> Position: </label>
                    
                    <select name="position" id="position" class="form-control" required>
                        <?php $data_count = Form::count_all(); 
                        for($count=1; $count <= $data_count+1; $count++){
                            echo "<option value=\"{$count}\"";
                            if($form->position == $count){
                                echo " selected";
                            }
                            echo ">".$count."</option>";
                            }
                        ?>  
                        
                    </select>
                    
                </div>
                <div class="form-group">
                    <button class="form-control btn-info" name="submit" type="submit" id="submit">Update Registration</button> 
                </div>
                <button type="button"><a href="index.php">Registration Page</a></button>
            </form>
            
        </div>
        
    </div>
    
</div>

<script type="text/javascript">
$(document).ready(function(){
    $("button.close").click(function(){
        //alert('empty');
        $('.alert').fadeOut();
    });
})
    

</script>

</body>
</html>
