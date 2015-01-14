<script type="text/javascript">
 function  validateForm(){
     //alert("hi");
     var player_1 =$("#play_1").chosen().val();
      var player_2 =$("#play_2").chosen().val();
       var player_3 =$("#play_3").chosen().val();
        var player_4 =$("#play_4").chosen().val();
         var player_5 =$("#play_5").chosen().val();
          var player_6 =$("#play_6").chosen().val();
           var player_7 =$("#play_7").chosen().val();
            var player_8 =$("#play_8").chosen().val();
             var player_9 =$("#play_9").chosen().val();
              var player_10 =$("#play_10").chosen().val();
      if(player_1==0 || player_2==0 || player_3==0 || player_4==0 || player_5==0 || player_6==0 || player_7==0 || player_8==0 || player_9==0 || player_10==0){
          alert("Pleaae choose all the option from the drop down");
          return false;
      }
      if(player_1==player_2 || player_1==player_3 || player_1==player_4 || player_1==player_5 || player_1==player_6 || player_1==player_7 || player_1==player_8 || player_1==player_9 || player_1==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      if( player_2==player_3 || player_2==player_4 || player_2==player_5 || player_2==player_6 || player_2==player_7 || player_2==player_8 || player_2==player_9 || player_2==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      if(player_3==player_4 || player_3==player_5 || player_3==player_6 || player_3==player_7 || player_3==player_8 || player_3==player_9 || player_3==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      if(player_4==player_5 || player_4==player_6 || player_4==player_7 || player_4==player_8 || player_4==player_9 || player_4==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      if( player_5==player_6 || player_5==player_7 || player_5==player_8 || player_5==player_9 || player_6==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      if(player_6==player_7 || player_6==player_8 || player_6==player_9 || player_6==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      if(player_7==player_8 || player_7==player_9 || player_7==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      if(player_8==player_9 || player_8==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      if(player_9==player_10){
          alert("Same player can not be choosen more than once");
          return false;
      }
      
      
 }
</script>   

<?php
require_once("config/db.php");

// load the login class
require_once("classes/Rating.php");
$r=new Rating();
session_start();
if($_REQUEST['cat']){
    $r=new Rating();
    $r->getPlayer($_REQUEST['cat']);
}
$players=array();
 while($row=$r->player->fetch_assoc()){ 
     $players[]=$row['player_name'];                                                                                
     
  }
 // print_r($players);

if($_SESSION['user_login_status'] != 1){
     header('Location:'.BASE_URL.'/login.php');
}
if(isset($_POST['add'])){
    $r->rateThis();  
    $rat=$r->rate();
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
                    <li class="active">
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
                <h1 class="page-header">Choose your top ten
                   
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#">Home</a>
                    </li>
                    <li class="active">Ranking</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                   <div class="alert alert-error <?php if(!$r->errors) { ?>hide<?php } ?>">
								<button class="close" data-dismiss="alert"></button>
                                                                <?php
                                                                if ($u->errors) {
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
                <!-- ranking form Post -->
                 
                <form class="form-horizontal" method="POST" action="<?php $_SERVER['PHP_SELF'] ; ?>" onsubmit="return validateForm();">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Select Category</label>
                      <div class="col-sm-9">
                          <select class="form-control"  onchange='this.form.submit()' name="cat" required>
                                                    <?php               echo "<option value='0'>Select Category</option>";
                                                                        while($row=$r->cat->fetch_assoc()){ 
                                                                                $sel="";
                                                                                if($row['cat_id']==$_REQUEST['cat']){
                                                                                    $sel='selected="selected"';
                                                                                }
                                                                                
                                                                                echo "<option $sel value='".$row['cat_id']."'>";
                                                                                echo $row['cat_name'];                                                                               
                                                                                echo "</option>";
                                                                            }
                                                        ?> 
                          </select>
                      </div>
                    </div>
                    <?php for($i=1;$i<11;$i++){?>
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-4 control-label"><?php echo $i; ?></label>
                      <div class="col-sm-8">
                          <select  id="play_<?php echo $i; ?>" data-placeholder="Choose a Country..." class="chosen-select" style="width:350px;" tabindex="2" name="player[]">
                                      
                                                    <?php               echo "<option value='0'>Select Player</option>";
                                                                        foreach($players as $v){ 
                                                                                         
                                                                                echo "<option value='".$v."'>";
                                                                                echo $v;                                                                               
                                                                                echo "</option>";
                                                                            }
                                                        ?> 
                          </select>
                      </div>
                    </div>
                    <?php } ?>
 
                    <div class="form-group">
                      <div class="col-sm-offset-4 col-sm-10">
                          <button type="submit" class="btn btn-primary" name="add">Submit</button>
                      </div>
                    </div>
                </form>
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">


                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Sports Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">
                                 <?php       $rat=$r->rate();                                    
                                        while($row=$r->cat->fetch_assoc()){                                                                               
                                                                               
                                                                            
                                             echo "<li><a href='".BASE_URL."/ranking.php?cat=".$row['cat_id']."'>".$row['cat_name']."</a></li>";        
                                   
                                             }
                                  ?> 
                            </ul>
                        </div>
      
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

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


