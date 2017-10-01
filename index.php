<?php 
require_once("includes/initialize.php");
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
<script type="application/javascript" src="js/bootstrap.min.js"></script>


    <!-- End of head section HTML codes -->
</head>

<body>
<div class="container-fluid">
    <h2>Naveteur Test</h2>
    <h3>I am testing git hub</h3>
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
            <form method="POST" action="processes/form_submit_process.php">
                <div class="form-group">
                    <label for="name"> Name: </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                        <input id="name" class="form-control" type="text" name="name" placeholder="Name.." required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="address"> Address: </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-map-marker"></i></span>
                        <input id="address" class="form-control" type="text" name="address" placeholder="Address..." required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="dob"> Date of Birth: </label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-calendar-check-o"></i></span>
                        <input id="dob" class="form-control" type="Date" name="dob" placeholder="Name.." required />
                    </div>
                </div>
                <div class="form-group">
                    <label for="position"> Position: </label>
                    
                    <select name="position" id="position" class="form-control" required>
                        <?php $data_count = Form::count_all(); 
                        for($count=1; $count <= $data_count+1; $count++){
                                echo "<option value=\"{$count}\">{$count}</option>";
                            }
                        ?>  
                        
                    </select>
                    
                </div>
                <div class="form-group">
                    <button class="form-control btn-info" name="submit" type="submit" id="submit">Submit</button>
                    
                </div>
            </form>
            <?php if(!empty($id)) {?>
                <button><a href="edit.php?id= <?php echo urlencode($id); ?>">Previous/Retrieve</a></button>
            <?php } ?>
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
