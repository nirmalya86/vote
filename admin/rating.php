<?php
require_once("../config/db.php");

// load the login class
require_once("../classes/Rating.php");
$r=new Rating();
session_start();
if($_SESSION['user_admin']!="admin"){
     header('Location:'.BASE_URL.'/login.php');
}
if(isset($_POST['category'])){
   
    $r->listRating($_POST['category']);   
}
if(isset($_POST['add'])){
    $r->publish();  
   // $r=new Rating();
   // print_r($r->errors);
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
                            <li>
                                <a href="<?php echo BASE_URL; ?>/admin/">USER MANAGEMENT</a>
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/admin/category.php">CATEGORY</a>        
                            </li>
                            <li>
                                <a href="<?php echo BASE_URL; ?>/admin/players.php">PLAYERS</a>        
                            </li>
                            <li class="active">
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
                        <li>
                            <a href="<?php echo BASE_URL; ?>/admin/adduser.php"><i class="icon-chevron-right"></i> Add User</a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/admin/category.php"><i class="icon-chevron-right"></i> Category </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/admin/players.php"><i class="icon-chevron-right"></i> Players</a>
                        </li>
                        <li class="active">
                            <a href="<?php echo BASE_URL; ?>/admin/rating.php"><i class="icon-chevron-right"></i> Rating</a>
                        </li>

                    </ul>
                </div>
                <!--/span-->
                <div class="span9" id="content">
                     <form action="<?php $_SERVER['PHP_SELF'] ; ?>" id="rating" class="form-horizontal" method="POST">
                        <div class="controls">
                        <select class="form-control" name="category" onchange='this.form.submit()'>
                         <?php                                          echo "<option value='0'>Select Category</option>";
                                                                        while($row=$r->cat->fetch_assoc()){ 
                                                                                $sel="";
                                                                                if($row['cat_id']==$_POST['category']){
                                                                                    $sel='selected="selected"';
                                                                                }
                                                                                
                                                                                echo "<option $sel value='".$row['cat_id']."'>";
                                                                                echo $row['cat_name'];                                                                               
                                                                                echo "</option>";
                                                                            }
                         ?>  
                        </select>     
                       </div>
                     </form>
    
                     <div class="row-fluid">
                        <!-- block -->
                        <div class="block">
                            <div class="navbar navbar-inner block-header">
                                <div class="muted pull-left">Bootstrap dataTables with Toolbar</div>
                            </div>
                            <div class="block-content collapse in">
                                <div class="span12">
 
                                   <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example3">
                                        <thead>
                                            <tr>
                                                <th>Player's Name</th>
                                                <th>Category</th>
                                                <th>Rating</th>                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while($row=$r->player->fetch_assoc()){    
                                                    echo "<tr>";
                                                    echo "<td>".$row['player_name']."</td>";
                                                    echo "<td>".$row['cat_name']."</td>";  
                                                    echo "<td>".$row['rating']."</td>";   
                                                    echo "</tr>";
                                                }
                                             ?>   
                                                               
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /block -->
                        
                        
                     <!-- validation -->
                    <div class="row-fluid">

                                <div class="span12">
					<!-- BEGIN FORM-->   
                                        
                                        <form action="<?php $_SERVER['PHP_SELF'] ; ?>" id="form_sample_1" class="form-horizontal" method="POST">
						<fieldset>
                                                        <div class="alert alert-error <?php if(!$r->errors) { ?>hide<?php } ?>">
								<button class="close" data-dismiss="alert"></button>
                                                                <?php
                                                                if ($r->errors) {
                                                                    foreach ($r->errors as $errors) {
                                                                        echo $errors;
                                                                    }
                                                                }
                                                                else{
                                                                ?>
								You have some form errors. Please check below.
                                                                <?php } ?>
							</div>
                                                        <div class="alert alert-success <?php if(!$r->messages) {?> hide <?php } ?>">
								<button class="close" data-dismiss="alert"></button>
								<?php
                                                                if ($r->messages) {
                                                                    foreach ($r->messages as $message) {
                                                                        echo $message;
                                                                    }
                                                                }
                                                                
                                                                ?>
							</div>

                                                
  							<div class="form-actions">                                                      
                                                            <input type="hidden" name="cat" value="<?php echo $_REQUEST['category'];?>" />
                                                            <button type="submit"  name="add" class="btn btn-primary">Publish</button>
                                                       			
  							</div>
						</fieldset>
					</form>
					<!-- END FORM-->
				</div>

		    </div>
                     <!-- /validation -->
                                                          
                                                
                                               
                        
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