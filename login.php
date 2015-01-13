
<?php 
// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");
require_once("classes/User.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();
if($_SESSION['user_login_status'] == 1){
     header('Location:'.BASE_URL);
}  

if(isset($_POST['register'])){ 
    $u=new User();
    $u->addUSer2($_POST);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Modern Business </title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo BASE_URL; ?>">Company logo</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="<?php echo BASE_URL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="about.php">About</a>
                    </li>
                    <li>
                        <a href="services.php">Services</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <li>
                        <a href="ranking.php">Ranking</a>
                    </li>
                                 <?php
                    if($_SESSION['user_login_status'] == 1){
                        ?>
                  
                       <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['user_name']; ?></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="index.php?logout">Logout</a>
                            </li>                             
                        </ul>
                    </li>
                    <?php
                    } else{ ?>
                    <li>
                         <a href="login.php"><input type="submit"  name="login" value="Log in"  class="btn btn-primary"/></a>
                    </li>
                    <?php } ?>
                    
                 
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User Login
                    
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo BASE_URL; ?>">Home</a>
                    </li>
                    <li class="active">Login</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Content Row -->
        <div class="row">
            <!-- Map Column -->
            <div class="col-md-6" >

                
                <!-- login form box -->
            <form method="post" action="<?php $_SERVER['PHP_SELF'] ; ?>" name="loginform">
                <?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo $error;
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo $message;
        }
    }
}
?>
               <h3>User Login</h3>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Email Address</label>
                             <input id="login_input_username" class="form-control" type="text" name="user_name" required />
                            <p class="help-block"></p>
                        </div>
                    </div>
                     <div class="control-group form-group">
                        <div class="controls">
                            <label>Password</label>
                            <input id="login_input_password" class="form-control" type="password" name="user_password" autocomplete="off" required />
                            <p class="help-block"></p>
                        </div>
                    </div>              
                
                <input type="submit"  name="login" value="Log in"  class="btn btn-primary"/>

            </form>
            </div>
            <!-- Contact Details Column -->
          <div class="col-md-6" style="border-left: 1px dashed black;">
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
                <h3>New User Register</h3>
                <form name="sentMessage" id="contactForm" method="POST">
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>First Name:</label>
                             <input type="text" name="fname" data-required="1" class="form-control" value="<?php if(isset($row->fname)){echo $row->fname; } elseif(isset($_POST['fname'])){echo $_POST['fname'];} ?>"/>
                            <p class="help-block"></p>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Last Name:</label>
  			<input type="text" name="lname" data-required="1" class="form-control" value="<?php if(isset($row->lname)){echo $row->lname; } elseif(isset($_POST['lname'])){echo $_POST['lname'];} ?>"/>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Email Address:</label>
  			    <input name="email" type="text" class="form-control" value="<?php if(isset($row->user_email)){echo $row->user_email; } elseif(isset($_POST['email'])){echo $_POST['email'];} ?>"/>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Password:</label>
  			    <input name="password" type="rpassowrd" class="form-control" />
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Password:</label>
  			    <input name="rpassword" type="passowrd" class="form-control" />
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Phone Number:</label>
  			    <input name="number" type="text" class="form-control" value="<?php if(isset($row->phone_number)){echo $row->phone_number; } elseif(isset($_POST['number'])){echo $_POST['number'];} ?>"/>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Address:</label>
  			  <input name="address" type="text" class="form-control" value="<?php if(isset($row->address)){echo $row->address; } elseif(isset($_POST['address'])){echo $_POST['address'];} ?>"/>
                        </div>
                    </div>
                    
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>State:</label>
  			<input name="state" type="text" class="form-control" value="<?php if(isset($row->state)){echo $row->state; } elseif(isset($_POST['state'])){echo $_POST['state'];} ?>"/>
                        </div>
                    </div>
                    
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>City:</label>
  			<input name="city" type="text" class="form-control" value="<?php if(isset($row->city)){echo $row->city; } elseif(isset($_POST['city'])){echo $_POST['city'];} ?>"/>
                        </div>
                    </div>        
                    
                    <div class="control-group form-group">
                        <div class="controls">
                            <label>Zip:</label>
  			<input name="zip" type="text" class="form-control" value="<?php if(isset($row->zip)){echo $row->zip; } elseif(isset($_POST['zip'])){echo $_POST['zip'];} ?>"/>
                        </div>
                    </div> 
                    
                    
                    
                    <div id="success"></div>
                    
                    <button type="submit" class="btn btn-primary" name="register">Register</button>
                </form>
            </div>

        </div>
        <!-- /.row -->
 

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    
     <script type="text/javascript" src="admin/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
     <script>
        // $("#contactForm").validate();
 $(document).ready(function(){
   $("#contactForm").validate({
                rules: {

                    fname: {
                        minlength: 2,
                        required: true
                    },
                    lname: {
                        minlength: 2,
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },

                    number: {
                        required: true,
                        minlength: 8,
                        number: true
                    },
                    address: {
                        required: true,
                         minlength: 2,
                    },
                    state: {
                        required: true,
                         minlength: 2,
                    },
                    city: {
                        required: true,
                         minlength: 2,
                    },
                     zip: {
                        required: true,
                         minlength: 4,
                        number: true
                    },
                    password: {
                        required: true,
                         minlength: 8,
                        
                    },
                    rpassword: {
                        required: true,
                         minlength: 8,
                        
                    }
                
                },

     });
});

     </script>    
     
     <style type="text/css">
         #form .error {
color:red;
}
#form input.error {
border:1px solid red;
}
      </style>   
</body>

</html>
