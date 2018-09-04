<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
 $user_home->redirect('index.php');
}
$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['btn-createuni']))
{
    $uni_name = trim($_POST['uni_name']);
    $uni_loc = trim($_POST['uni_loc']);
    $stu_num = trim($_POST['stu_num']);
    $uni_des = trim($_POST['uni_des']);
    $uni_im = $_POST['uni_image'];
    $userID = $_SESSION['userSession'];

    $check = $user_home->runQuery("SELECT * FROM universityprofile WHERE name=:uni_name");
    $check->execute(array(":uni_name"=>$uni_name));
    $row = $check->fetch(PDO::FETCH_ASSOC);

    if($check->rowCount() > 0)
    {
      $msg = "
        <div class='alert alert-danger'>
     <strong>Sorry!</strong> There's already a profile for that university.
     </div>
     ";
    }
    else
    {
      if($user_home->makeUni($uni_name, $uni_loc, $uni_des, $stu_num, $uni_im))
      {
          if($user_home->createUni($uni_name, $userID))
          {
              echo " yay you did it";
              $user_home->redirect('uniconfirmation.php');
          }
          else
          {
              die("fml you failed");
          }

          echo " yay you did it";
      }
      else
      {
        die("fml you failed");
      }
    }

}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>COP4710 Group 6</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />

    <!--  Material Dashboard CSS    -->
    <link href="../assets/css/material-dashboard.css" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>

</head>

<body>
<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="../assets/img/sidebar-1.jpg">
        <div class="logo">
            <a href="home.php" class="simple-text">
                <?php echo $row['userName']; ?>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav">
                <li>
                    <a href="home.php">
                        <i class="material-icons">dashboard</i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="active">
                    <a href="createuni.php">
                        <i class="material-icons">library_books</i>
                        <p>Create University</p>
                    </a>
                </li>
                <li>
                    <a href="approveevent.php">
                        <i class="material-icons">check</i>
                        <p>Approve Event</p>
                    </a>
                </li>
                <li>
                    <a href="uniresultsuperadmin.php">
                        <i class="material-icons">account_balance</i>
                        <p>View Universities</p>
                    </a>
                </li>
                <li>
                    <a href="logout.php">
                        <i class="material-icons">exit_to_app</i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
	<div class="main-panel" style="background-image: url('assets/img/wallpaper.jpeg'); background-size: cover; background-position: top center; min-height: 600px;">
			<nav class="navbar navbar-transparent navbar-absolute">
<div class="col-lg-4 col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="purple">
			<h4 class="title">Create a University</h4>
		</div><br>
		<div style="text-align:left" class="col-lg-12">
        <form action="" method="POST">
		<input type="text" class="input-block-level" placeholder="Name of University" name="uni_name" required />
        <br><br>
        <input type="text" class="input-block-level" placeholder="Location" name="uni_loc" required />
        <br><br>
        <textarea name="uni_des" placeholder="Description (not required)" maxlength="1000" rows="5" cols="40" class="input-block-level"></textarea>
        <br><br>
        <input type="text" class="input-block-level" placeholder="Number of Students" name="stu_num"/>
        <br><br>
        <h6>Image for Profile:</h6>
        <input type="file" name="uni_image">
        <br><br>
        <button class="btn btn-large btn-primary" type="submit" name="btn-createuni">Create University</button>
        <br><br><br>
		</form>
	  </div>
	</div>
  </div>
 </nav>
 </div>    
 
 </div>
 </body>
    <!--   Core JS Files   -->
      	<script src="../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
      	<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
      	<script src="../assets/js/material.min.js" type="text/javascript"></script>

      	<!--  Charts Plugin -->
      	<script src="../assets/js/chartist.min.js"></script>

      	<!--  Notifications Plugin    -->
      	<script src="../assets/js/bootstrap-notify.js"></script>

      	<!--  Google Maps Plugin    -->
      	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

      	<!-- Material Dashboard javascript methods -->
      	<script src="../assets/js/material-dashboard.js"></script>

</html>
