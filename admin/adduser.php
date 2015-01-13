<?php
require_once("../config/db.php");

// load the login class
require_once("../classes/User.php");
$u=new User();
session_start();
if($_SESSION['user_admin']!="admin"){
     header('Location:'.BASE_URL.'/login.php');
}
if(isset($_POST['add'])){ 
    $u->addUSer($_POST);
}
if(isset($_REQUEST['id'])){
    $row=$u->getUser();
}
if(isset($_POST['update'])){
   
    $u->updateUSer();
    $row=$u->getUser();
}
?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>Add User</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="vendors/flot/excanvas.min.js"></script><![endif]-->
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="vendors/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    </head>
    
    <body>
        <div class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid">
                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                     <span class="icon-bar"></span>
                    </a>
                    <a class="brand" href="#">Admin Panel</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="icon-user"></i> <?php echo $_SESSION['user_name']; ?> <i class="caret"></i>

                                </a>
                                <ul class="dropdown-menu">

                                    <li>
                                        <a tabindex="-1" href="<?php echo BASE_URL; ?>/?logout">Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav">
                            <li class="active">
                                <a href="<?php echo BASE_URL; ?>/admin/">USER MANAGEMENT</a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/admin/category.php">CATEGORY</a>        
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/admin/players.php">PLAYERS</a>        
                            </li>
                            <li >
                                <a href="<?php echo BASE_URL; ?>/admin/rating.php">RATING REVIEW</a>        
                            </li>                           
 
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span3" id="sidebar">
                    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                        <li>
                            <a href="<?php echo BASE_URL; ?>/admin"><i class="icon-chevron-right"></i> User</a>
                        </li>
                        <li  class="active">
                            <a href="<?php echo BASE_URL; ?>/admin/adduser.php"><i class="icon-chevron-right"></i> Add User</a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/admin/category.php"><i class="icon-chevron-right"></i> Category </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/admin/players.php"><i class="icon-chevron-right"></i> Players</a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/admin/rating.php"><i class="icon-chevron-right"></i> Rating</a>
                        </li>

                    </ul>
                </div>
                <!--/span-->
                <div class="span9" id="content">


                     <!-- validation -->
                    <div class="row-fluid">
                         <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Form Validation</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
					<!-- BEGIN FORM-->   
                                        
                                        <form action="<?php $_SERVER['PHP_SELF'] ; ?>" id="form_sample_1" class="form-horizontal" method="POST">
						<fieldset>
                                                        <div class="alert alert-error <?php if(!$u->errors) { ?>hide<?php } ?>">
								<button class="close" data-dismiss="alert"></button>
                                                                <?php
                                                                if ($u->errors) {
                                                                    foreach ($u->errors as $errors) {
                                                                        echo $errors;
                                                                    }
                                                                }
                                                                else{
                                                                ?>
								You have some form errors. Please check below.
                                                                <?php } ?>
							</div>
                                                        <div class="alert alert-success <?php if(!$u->messages) {?> hide <?php } ?>">
								<button class="close" data-dismiss="alert"></button>
								<?php
                                                                if ($u->messages) {
                                                                    foreach ($u->messages as $message) {
                                                                        echo $message;
                                                                    }
                                                                }
                                                                
                                                                ?>
							</div>
                                                    <input type="hidden" name="base_url" id="base_url" value="<?php echo BASE_URL; ?>" data-required="1" class="span6 m-wrap"/>
  							<div class="control-group">
  								<label class="control-label">First Name<span class="required">*</span></label>
  								<div class="controls">
                                                                    <input type="text" name="fname" data-required="1" class="span6 m-wrap" value="<?php if(isset($row->fname)){echo $row->fname; } elseif(isset($_POST['fname'])){echo $_POST['fname'];} ?>"/>
  								</div>
  							</div>
                                                        <div class="control-group">
  								<label class="control-label">Last Name<span class="required">*</span></label>
  								<div class="controls">
  									<input type="text" name="lname" data-required="1" class="span6 m-wrap" value="<?php if(isset($row->lname)){echo $row->lname; } elseif(isset($_POST['lname'])){echo $_POST['lname'];} ?>"/>
  								</div>
  							</div>
  							<div class="control-group">
  								<label class="control-label">Email<span class="required">*</span></label>
  								<div class="controls">
  									<input name="email" type="text" class="span6 m-wrap" value="<?php if(isset($row->user_email)){echo $row->user_email; } elseif(isset($_POST['email'])){echo $_POST['email'];} ?>"/>
  								</div>
  							</div>
  						
  							<div class="control-group">
  								<label class="control-label">Phone Number<span class="required">*</span></label>
  								<div class="controls">
  									<input name="number" type="text" class="span6 m-wrap" value="<?php if(isset($row->phone_number)){echo $row->phone_number; } elseif(isset($_POST['number'])){echo $_POST['number'];} ?>"/>
  								</div>
  							</div>
                                                    	<div class="control-group">
  								<label class="control-label">Street Address<span class="required">*</span></label>
  								<div class="controls">
  									<input name="address" type="text" class="span6 m-wrap" value="<?php if(isset($row->address)){echo $row->address; } elseif(isset($_POST['address'])){echo $_POST['address'];} ?>"/>
  								</div>
  							</div>
                                                    	<div class="control-group">
  								<label class="control-label">State<span class="required">*</span></label>
  								<div class="controls">
  									<input name="state" type="text" class="span6 m-wrap" value="<?php if(isset($row->state)){echo $row->state; } elseif(isset($_POST['state'])){echo $_POST['state'];} ?>"/>
  								</div>
  							</div>
                                                        <div class="control-group">
  								<label class="control-label">City<span class="required">*</span></label>
  								<div class="controls">
  									<input name="city" type="text" class="span6 m-wrap" value="<?php if(isset($row->city)){echo $row->city; } elseif(isset($_POST['city'])){echo $_POST['city'];} ?>"/>
  								</div>
  							</div>
                  
  							<div class="control-group">
  								<label class="control-label">Zip Code<span class="required">*</span></label>
  								<div class="controls">
  									<input name="zip" type="text" class="span6 m-wrap" value="<?php if(isset($row->zip)){echo $row->zip; } elseif(isset($_POST['zip'])){echo $_POST['zip'];} ?>"/>
  								</div>
  							</div>
  							    <?php if(isset($_REQUEST['id'])){?>                                                           
                                                    <input type="hidden"  name="id" value="<?php echo $_REQUEST['id']; ?>">
                                                            <?php } ?>
  							<div class="form-actions">
                                                            <?php if(isset($_REQUEST['id'])){?>                                                           
                                                            <button type="submit"  name="update" class="btn btn-primary">Update</button>
                                                            <?php } else{?>
                                                            <button type="submit"  name="add" class="btn btn-primary">Add</button>
                                                            <?php } ?>
  								<button type="button" class="btn">Cancel</button>
  							</div>
						</fieldset>
					</form>
					<!-- END FORM-->
				</div>
			    </div>
			</div>
                     	<!-- /block -->
		    </div>
                     <!-- /validation -->


                </div>
            </div>
            <hr>
            <footer>
                <p>&copy; Vincent Gabriel 2013</p>
            </footer>
        </div>
        <!--/.fluid-container-->
        <link href="vendors/datepicker.css" rel="stylesheet" media="screen">
        <link href="vendors/uniform.default.css" rel="stylesheet" media="screen">
        <link href="vendors/chosen.min.css" rel="stylesheet" media="screen">

        <link href="vendors/wysiwyg/bootstrap-wysihtml5.css" rel="stylesheet" media="screen">

        <script src="vendors/jquery-1.9.1.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/jquery.uniform.min.js"></script>
        <script src="vendors/chosen.jquery.min.js"></script>
        <script src="vendors/bootstrap-datepicker.js"></script>

        <script src="vendors/wysiwyg/wysihtml5-0.3.0.js"></script>
        <script src="vendors/wysiwyg/bootstrap-wysihtml5.js"></script>

        <script src="vendors/wizard/jquery.bootstrap.wizard.min.js"></script>

	<script type="text/javascript" src="vendors/jquery-validation/dist/jquery.validate.min.js"></script>
	<script src="assets/form-validation.js"></script>
        
	<script src="assets/scripts.js"></script>
        <script>

	jQuery(document).ready(function() {   
	   FormValidation.init();
	});
	      
        </script>
    </body>

</html>