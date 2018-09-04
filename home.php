<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();
if(!$user_home->is_logged_in())
{
    $user_home->redirect('index.php');
}
else if($user_home->is_superadmin())
{
    $user_home->redirect('superadminhome.php');
}

$userID = $_SESSION['userSession'];
$i = 1;

$stmt = $user_home->runQuery("SELECT * FROM users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// First parentheses are for private events, second are for rso events, and last is for public events
$query = $user_home->runQuery("SELECT * FROM event E, approvespub Pu WHERE E.eventId = Pu.eventId GROUP BY E.eventId");
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
	                <li class="active">
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-plain">
                        <span class="nav-tabs-title"></span>
                        <ul class="nav nav-tabs" data-tabs="tabs">
                            <li class="active">
                                <a href="">
                                    <i class="material-icons">face</i>
                                    public events
                                    <div class="ripple-container"></div></a>
                            </li>
                            <li>
                                <a href="homeprivateevents.php">
                                    <i class="material-icons">account_balance</i>
                                    university events
                                    <div class="ripple-container"></div></a>
                            </li>
                            <li>
                                <a href="homersoevents.php">
                                    <i class="material-icons">supervisor_account</i>
                                    rso events
                                    <div class="ripple-container"></div></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <?php
                        while ($row2 = $query->fetch(PDO::FETCH_ASSOC)) {
                            $button1 = "comment-button".$i;
                            $eventId = $row2['eventId'];
                            $commentString = trim($_POST['commentString']);

                            if(isset($_POST[$button1]))
                            {
                                if($user_home->makeComment($commentString))
                                {
                                    $maxcommentid = $user_home->runQuery("SELECT MAX(commentId) FROM commentinfo");
                                    $maxcommentid->execute();
                                    $commentId = $maxcommentid->fetchColumn();

                                    $user_home->comments($userID, $commentId, $eventId);
                                    echo " yay you did it";
                                    $user_home->redirect('home.php');
                                }
                                else
                                {
                                    die("fml you failed");
                                }
                            }
                            ?>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header card-chart" data-background-color="purple">
                                        <?php
                                        $mapLat = $row2['latitude'];
                                        $mapLon = $row2['longitude'];
                                        $mapImg = "<img src='https://maps.googleapis.com/maps/api/staticmap?center=" . $mapLat . "," . $mapLon . "&zoom=15&size=180x70&scale=2&maptype=roadmap&markers=size:tiny%7Ccolor:red%7C" . $mapLat . "," . $mapLon . "&key=AIzaSyBJe20lWQ7SqNplFqtoS6LQpOunJ83X0sw'>";
                                        echo $mapImg;
                                        ?>
                                    </div>
                                    <div class="card-content">
                                        <h3 class="title"><?php echo $row2['eventName']; ?></h3>
                                        <p class="category"><?php echo $row2['category']; ?></p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats" style="width:100%;">
                                            <table class="table">
                                                <thead>
                                                <div class="text" align="justify">
                                                    <h4>  <?php echo $row2['eventDescription'];?> </h4>
                                                </div>
                                                </thead>
                                                <td style="vertical-align:top;">
                                                    <h5>
                                                        <i class="material-icons" style="font-size: 16px;">date_range</i><br>
                                                        <i class="material-icons" style="font-size: 16px;">alarm</i><br>
                                                        <i class="material-icons" style="font-size: 16px;">voicemail</i><br>
                                                        <i class="material-icons" style="font-size: 16px;">email</i><br>
                                                        <i class="material-icons" style="font-size: 16px;">add_location</i>
                                                    </h5>
                                                </td>
                                                <td style="vertical-align:top;">
                                                    <h5>
                                                        <strong>Date:</strong><br>
                                                        <strong>Time:</strong><br>
                                                        <strong>Contact Phone: </strong><br>
                                                        <strong>Contact Email:</strong><br>
                                                        <strong>Location:</strong><br>
                                                    </h5>
                                                </td>
                                                <td style="text-align:left;">
                                                    <h5>
                                                        <div class="text"> <?php echo $row2['date'];?></div><br>
                                                        <div class="text"> <?php echo $row2['time'];?></div><br>
                                                        <div class="text"> <?php echo $row2['phoneNo'];?></div><br>
                                                        <u>
                                                            <?php
                                                            $emailLink="<a href='mailto:" . $row2['eventEmail'] ."'>". $row2['eventEmail'] . "</a>";
                                                            echo $emailLink;
                                                            ?>
                                                        </u><br>
                                                        <div class="text"> <?php echo $row2['locationName'];?></div>
                                                    </h5>
                                                </td>
                                            </table>

                                            <form method="post">
                                                <table class="table" style="width:100%;">
                                                    <td style="vertical-align:top; padding:0; margin:0;">
                                                        <div class = "input-group">
                                                            <textarea class="form-control" name="commentString" style="width:100%;"placeholder="Leave a comment for <?php echo $row2['eventName'];?>" rows=3></textarea>
                                                        </div>
                                                    </td>
                                                    <td style="text-align:right; padding:0; margin:0;">
                                                        <div class="input-group">
                                                            <button class="btn btn-info btn-small" align="right" name="comment-button<?php echo $i; ?>" type="submit">Submit</button>
                                                        </div>
                                                    </td>
                                                </table>
                                            </form>
                                            <table class="table">
                                                <thead>
                                                <td style="text-align:left;">
                                                    <?php
                                                    $sql = "SELECT U.userName, I.commentString FROM commentinfo I, comments C, users U WHERE (I.commentId = C.commentId) AND (C.eventId = $eventId) AND (C.userID = U.userID)";
                                                    $comments = $user_home->runQuery($sql);
                                                    $comments->execute(array($_SESSION['userSession']));

                                                    while ($row3 = $comments->fetch(PDO::FETCH_ASSOC)) {?>
                                                        <h6>
                                                            <p><strong><?php echo $row3['userName'];?> <?php echo ":"?> </strong>
                                                                <?php echo $row3['commentString'];?>
                                                            </p>
                                                        </h6>
                                                        <br>

                                                    <?php } ?> <!-- end inner loop -->
                                                </td>
                                                </thead>
                                            </table>

                                        </div> <!-- end content -->
                                    </div> <!-- end comments footer -->
                                </div> <!-- end event card -->
                            </div>
                        <?php $i++; } ?>  <!-- end outer loop -->
                    </div>
                </div>
            </div> <!-- end content -->
        </nav>
    </div> <!-- end main panel -->
</div> <!-- end wrapper -->

<!--   Core JS Files   -->
<script src="../assets/js/jquery-3.1.0.min.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/js/material.min.js" type="text/javascript"></script>

<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="assets/js/nouislider.min.js" type="text/javascript"></script>

<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
<script src="assets/js/material-kit.js" type="text/javascript"></script>

<!--  Charts Plugin -->
<script src="../assets/js/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="../assets/js/bootstrap-notify.js"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Material Dashboard javascript methods -->
<script src="../assets/js/material-dashboard.js"></script>
</body>
</html>