<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>Admin: Gallery</title>
<link href="../stylesheets/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="../stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../admin/stylesheets/index.css" rel="stylesheet" type="text/css" />
<!-- phone -->
<link href="../admin/stylesheets/phone.css" rel="stylesheet" type="text/css" />
<!-- tablet -->
<link href="../admin/stylesheets/tablet.css" rel="stylesheet" type="text/css" />
<!-- desktop -->
<link href="../admin/stylesheets/desktop.css" rel="stylesheet" type="text/css" />
<script type="application/javascript" src="../js/jquery-1.11.3.min.js"></script>
<script type="application/javascript" src="../js/bootstrap.min.js"></script>
</head>

<body>
<div class="container-fluid">
    <div id="site_intro">
        <img src="../images/Graphic6.png" alt="image" />
    </div>
</div> 
<?php
	if(isset($_SESSION['user_id'])){
		//$user_id = $session->user_id;
		$user = User::find_by_id($session->user_id);
	} 
 
?>
<div class="header">
	<div class="col-sm-4">
    	<h2>Admin panel</h2>
    </div>
    <div class="col-sm-8">
    	 
		<?php 
		if(isset($_SESSION['user_id'])){ ?>
        <a href=""><span class="fa fa-user"></span>
			<?php echo $user->username; ?>
        </a>   
		<?php } ?> 
        
    	<button class="btn btn-info"><span class="fa fa-edit"></span> Edit Profile</button>
        
        <button class="btn btn-warning">Change Password</button>
        <a href="index.php?logout=true"><span class="fa fa-sign-out"></span> Logout</a>
        <a href="logfile.php"><span class="fa fa-log"></span> Logfile</a>
    </div>
    <div class="clear"></div>
</div>

<aside class="col-sm-2">
    <div class="col-sm-12">
        <ul>
            <li><a id="dashboard" href="dashboard.php"><span class="fa fa-dashboard"></span> Dashboard</a></li>
            <li><a href="potrait_view.php">Potraits</a></li>
            <li><a href="card_view.php">Cards</a></li>
            <li><a href="web_view.php">Websites</a></li>
            <li><a href="dj_mix_view.php">DJ Mixes</a></li>
            <li><a href="add_user.php">Add New User</a></li>
            <li><a href="../../blog/admin/alex_post_view.php">Blog</a></li>
        </ul>
    </div>
</aside>    



