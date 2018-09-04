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
if(isset($_POST['btncreaterso']))
{
    $i = 1;
    $userID = $_SESSION['userSession'];
    $RSOName = trim($_POST['RSOName']);
    $RSODescription= trim($_POST['RSODescription']);
    $s1email = trim($_POST['s1email']);
    $s2email = trim($_POST['s2email']);
    $s3email = trim($_POST['s3email']);
    $s4email = trim($_POST['s4email']);
    $s5email = trim($_POST['s5email']);
    $d1 = explode('@',$s1email);
    $d2 = explode('@',$s2email);
    $d3 = explode('@',$s3email);
    $d4 = explode('@',$s4email);
    $d5 = explode('@',$s5email);
    $domain1 = array_pop($d1);
    $domain2 = array_pop($d2);
    $domain3 = array_pop($d3);
    $domain4 = array_pop($d4);
    $domain5 = array_pop($d5);

    $check = $user_home->runQuery("SELECT * FROM rso WHERE RSOName=:RSOName");
    $check->execute(array(":RSOName"=>$RSOName));
    $row = $check->fetch(PDO::FETCH_ASSOC);

    $query = $user_home->runQuery("SELECT COUNT(*) FROM users U, userstudent S WHERE (S.userID = U.userID) AND (U.userEmail = '$s1email'
                                        OR U.userEmail = '$s2email' OR U.userEmail = '$s3email' OR U.userEmail = '$s4email' OR U.userEmail = '$s5email')");
    $query->execute();
    $registeredEmails = $query->fetchColumn();

    $query2 = $user_home->runQuery("SELECT U.userID FROM users U, userstudent S WHERE (S.userID = U.userID) AND (U.userEmail = '$s1email'
                                        OR U.userEmail = '$s2email' OR U.userEmail = '$s3email' OR U.userEmail = '$s4email' OR U.userEmail = '$s5email')");
    $query2->execute(array($_SESSION['userSession']));

    if($check->rowCount() > 0)
    {
      $msg = "
        <div class='alert alert-danger'>
     <h6>Sorry...<br> There's already a RSO with that name.</h6>
     </div>
     ";

      echo $msg;
    }
    else if ($registeredEmails < 5)
    {
        $msg = "
        <div class='alert alert-danger'>
     <h6>Sorry...<br> At least one of the emails you entered is not registered with this website.</h6>
     </div>
     ";

        echo $msg;
    }
    else if ((strcmp($domain1, $domain2) || strcmp($domain2, $domain3) || strcmp($domain3, $domain4) || strcmp($domain4, $domain5)) != 0)
    {
        $msg = "
        <div class='alert alert-danger'>
     <h6>Sorry...<br> All of the email domains must match to create an RSO.</h6>
     </div>
     ";

        echo $msg;
    }
    else
    {
      if($user_home->makeRSO($RSOName, $RSODescription, 5))
      {
          $query3 = $user_home->runQuery("SELECT MAX(RSOId) FROM rso");
          $query3->execute();
          $RSOId = $query3->fetchColumn();

          $query4 = $user_home->runQuery("SELECT * FROM useradmin WHERE userID=:uid");
          $query4->execute(array(":uid"=>$_SESSION['userSession']));
          $row3 = $query4->fetch(PDO::FETCH_ASSOC);

          while ($row2 = $query2->fetch(PDO::FETCH_ASSOC))
          {
              $joinUserID = $row2['userID'];

              $user_home->joinRSO($joinUserID, $RSOId);
          }

          if ($query4->rowCount() < 1)
              $user_home->registerAdmin($userID);

          if($user_home->RSOcreator($userID, $RSOId) && $user_home->ownsRSO($userID, $RSOId))
          {
              echo "Successfully created new RSO.";
              $user_home->redirect('rsoconfirmation.php');
          }
          else
          {
              die("Oops... Something went wrong.");
          }
      }
      else
      {
        die("Oops... Something went wrong.");
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
                <?php echo $row['userName']; ?><br>
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
                <?php if ($user_home->is_admin()) { ?>
                    <li>
                        <a href="createevent.php">
                            <i class="material-icons">add_circle</i>
                            <p>Create Event</p>
                        </a>
                    </li>
                <?php } ?>
                <li class="active">
                    <a href="createrso.php">
                        <i class="material-icons">add_box</i>
                        <p>Create RSO</p>
                    </a>
                </li>
                <li>
                    <a href="viewrso.php">
                        <i class="material-icons">group</i>
                        <p>View RSOs</p>
                    </a>
                </li>
                <li>
                    <a href="rsoresult.php">
                        <i class="material-icons">supervisor_account</i>
                        <p>Join RSOs </p>
                    </a>
                </li>
                <li>
                    <a href="uniresult.php">
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
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header" data-background-color="purple">
                        <h4 class="title">Create an RSO</h4>
                    </div><br>
                    <div style="text-align:left" class="col-lg-12">
                        <form action="" method="POST">
                            <input type="text" class="input-block-level" placeholder="Name of RSO" name="RSOName" required />
                            <br><br>
                            <textarea name="RSODescription" placeholder="Description (not required)" maxlength="1000" rows="5" cols="40" class="input-block-level"></textarea>
                            <br><br>
                            <input type="email" class="input-block-level" placeholder="Your email address" name="s1email" required />
                            <br><br>
                            <input type="email" class="input-block-level" placeholder="Student 1 email address" name="s2email" required />
                            <br><br>
                            <input type="email" class="input-block-level" placeholder="Student 2 email address" name="s3email" required />
                            <br><br>
                            <input type="email" class="input-block-level" placeholder="Student 3 email address" name="s4email" required />
                            <br><br>
                            <input type="email" class="input-block-level" placeholder="Student 4 email address" name="s5email" required />
                            <br><br>
                            <button class="btn btn-large btn-primary" type="submit" name="btncreaterso">Create RSO</button>
                            <br><br><br>
                        </form>
                    </div>
                </div>
            </div>
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

