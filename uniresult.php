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

$query = $user_home->runQuery("SELECT * FROM universityprofile GROUP BY name");
$query->execute(array($_SESSION['userSession']));

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
                <li>
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
                        <p>Join RSOs</p>
                    </a>
                </li>
                <li class="active">
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
 <div class="content">
                        <div class="container-fluid">
                          <div class="row">
                            <?php
                              while ($row2 = $query->fetch(PDO::FETCH_ASSOC)) {?>
                  						<div class="col-lg-4 col-md-6 col-sm-6">
                  							<div class="card card-stats">
                  								<div class="card-header card-stats" data-background-color="purple">
													<i class="material-icons">account_balance</i>
												</div>
                  								<div class="card-content"><div class="clearfix">
                                    <h3 class="title"><center><?php echo $row2['name'];?></h3></center>
                                    <br>
                  								</div>
                                  </div>
                  								<div class="card-footer">
                  									<div class="stats">
                                      <table class="table">
                                        <thead>
                                          <div class="text text-primary" align="justify">
                                            <h5>
                                              <?php echo $row2['description'];?>
                                            </h5>
                                          </div>
                                          <td style="vertical-align:top;  padding-top:10px;">
                                            <h5>
                                            <i class="material-icons" style="font-size: 16px;">face</i><br>
                                            <i class="material-icons" style="font-size: 16px;">add_location</i><br>
                                            </h5>
                                          </td>
                                          <td style="vertical-align:top;">
                                            <h5>
                                              <strong>Students:</strong><br>
                                              <strong>Location:</strong><br>
                                            </h5>
                                          </td>
                                          <td style="text-align:left;">
                                            <h5>
                                              <div class="text text-info">
                                                <div class="text text-primary"> <?php echo $row2['studentNo'];?></div><br>
                                                <div class="text text-primary"> <?php echo $row2['location'];?></div><br>
                                              </div>
                                            </h5>
                                          </td>
                                      </thead>
                                    </table>
                                    <center>

                                    <br>
                                  </div> <!-- end content -->
                                        </div> <!-- end comments footer -->
                                      </div> <!-- end event card -->
                  								  </div>
                                    <?php } ?>  <!-- end outer loop -->
                  							  </div>
                  						  </div>
                              </div> <!-- end content -->
        </nav>
    </div>
</div>
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
