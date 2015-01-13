<?php
require_once("../config/db.php");

// load the login class
require_once("../classes/User.php");
$u=new User();
session_start();
if($_SESSION['user_admin']!="admin"){
     header('Location:'.BASE_URL.'/login.php');
}
if(isset($_REQUEST['id']) && $_REQUEST['action']=="delete"){
    $u->deleteUser();
   // print_r($u->messages);
  //  $u=new User();
      $u=new User();
}
if($_REQUEST['action']=="reset"){
    $u->resetUser();
   // print_r($u->messages);
  //  $u=new User();
   //   $u=new User();
}



?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>Tables</title>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
        <link href="assets/styles.css" rel="stylesheet" media="screen">
        <link href="assets/DT_bootstrap.css" rel="stylesheet" media="screen">
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
                        <li  class="active">
                            <a href="<?php echo BASE_URL; ?>/admin"><i class="icon-chevron-right"></i> User</a>
                        </li>
                        <li>
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

    
                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Bootstrap dataTables with Toolbar</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
                                   <div class="table-toolbar">
                                      <div class="btn-group">
                                         <a href="<?php echo BASE_URL; ?>/admin/adduser.php"><button class="btn btn-success">Add New <i class="icon-plus icon-white"></i></button></a>
                                      </div>
               
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
                                    
                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example2">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>State</th>
                                                <th>City</th>
                                                <th>Zip</th>
                                                <th> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while($row=$u->user->fetch_assoc()){    
                                                    echo "<tr>";
                                                    echo "<td>".$row['fname']." ".$row['lname']."</td>";
                                                    echo "<td>".$row['user_email']."</td>";
                                                    echo "<td>".$row['address']."</td>";
                                                    echo "<td>".$row['state']."</td>";
                                                    echo "<td>".$row['city']."</td>"; 
                                                    echo "<td>".$row['zip']."</td>";
                                                    echo "<td> <a href='".BASE_URL."/admin/adduser.php?id=".$row['user_id']."'><i class='icon-large icon-pencil'></i></a> <a  class='close' href='".BASE_URL."/admin/index.php?action=delete&id=".$row['user_id']."'><i class='icon-large icon-remove'></i></a> <a  class='reset' href='".BASE_URL."/admin/index.php?action=reset&id=".$row['user_id']."'><i class='icon-large icon-wrench'></i></a>" ."</td>";
                                                    echo "</tr>";
                                                }
                                             ?>   
                                                               
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                    </div>
                </div>
            </div>
            <hr>
            <footer>
                <p>&copy; Vincent Gabriel 2013</p>
            </footer>
        </div>
        <!--/.fluid-container-->

        <script src="vendors/jquery-1.9.1.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="vendors/datatables/js/jquery.dataTables.min.js"></script>


        <script src="assets/scripts.js"></script>
        <script src="assets/DT_bootstrap.js"></script>
        <script>
        $(function() {
            
        });
        </script>
    </body>

</html>