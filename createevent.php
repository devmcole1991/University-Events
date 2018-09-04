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
$privacy = "";
$eventId;
$userID = $_SESSION['userSession'];

if(isset($_POST['btn-createevent']))
{
    $eventName = trim($_POST['event_name']);
    $category = trim($_POST['category']);
    $date = trim($_POST['date']);
    $time = trim($_POST['time']);
    $locationName = trim($_POST['locationName']);
    $latitude = trim($_POST['latitude']);
    $longitude = trim($_POST['longitude']);
    $eventDescription = trim($_POST['event_des']);
    $phoneNo = trim($_POST['phoneNo']);
    $eventEmail = trim($_POST['eventEmail']);
    $privacy = trim($_POST['privacy']);
    $eventImage = $_POST['event_image'];
    $uName = $_REQUEST['uName'];

    if($user_home->makeEvent($eventName,$category,$eventDescription,$time,$date,$phoneNo,$eventEmail,$privacy,$locationName,$latitude,$longitude,$eventImage,$uName))
    {
        $stmt = $user_home->runQuery("SELECT MAX(eventId) FROM event");
        $stmt->execute();
        $eventId = $stmt->fetchColumn();

        $user_home->hostEvent($userID, $eventId);

        if($privacy == "public")
        {
            if($user_home->makePublicEvent($eventId))
            {
                echo " yay you did it";
                $user_home->redirect('eventconfirmation.php');
            }
            else
            {
                die("fml you failed");
            }
        }
        else if ($privacy == "private")
        {
            if($user_home->makePrivateEvent($eventId))
            {
                echo " yay you did it";
                $user_home->redirect('eventconfirmation.php');
            }
            else
            {
                die("fml you failed");
            }
        }
        else if ($privacy == "rso")
        {
            if($user_home->makeRSOEvent($eventId))
            {
                echo " yay you did it";
                $user_home->redirect('eventconfirmation.php');
            }
            else
            {
                die("fml you failed");
            }
        }
    }
    else
    {
        die("fml you failed");
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
	                    <a href="createevent.php">
	                        <i class="material-icons">add_circle</i>
	                        <p>Create Event</p>
	                    </a>
	                </li>
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
<div class="col-lg-6 col-md-12">
      <div class="card">
        <div class="card-header" data-background-color="purple">
			<h4 class="title">Create an Event</h4>
		</div><br>
		<div style="text-align:left" class="col-lg-12">
            <form action="" method="POST">
            <input type="text" class="input-block-level" placeholder="Name of Event" name="event_name" size="30" required />
            <br><br>
            <input type="text" class="input-block-level" placeholder="Category" name="category" size="30" required />
            <br><br>
            <select class="input-block-level" name="uName">
                <?php
                $stmt = $user_home->runQuery("SELECT name FROM universityprofile");
                $stmt->execute();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    unset($uName);
                    $uName = $row['name'];
                    echo '<option value="'.$uName.'">' . $uName . '</option>';
                }
                ?>
            </select>
            <br><br>
            <input type="date" class="input-block-level" placeholder="Date" name="date" required />
            <br><br>
            <input type="time" class="input-block-level" placeholder="Time" name="time" required />
            <br><br>
            <input type="text" class="input-block-level" placeholder="Name of Location" name="locationName" size="30" required />
            <br><br>
            <input type="decimal" class="input-block-level" placeholder="Latitude (Up to 8 Decimal Places)" name="latitude" size="30" required />
            <br><br>
            <input type="decimal" class="input-block-level" placeholder="Longitude (Up to 8 Decimal Places)" name="longitude" size="30" required />
            <br><br>
            <textarea name="event_des" placeholder="Description (not required)" maxlength="1000" rows="5" cols="40" class="input-block-level"></textarea>
            <br><br>
            <input type="text" class="input-block-level" placeholder="Contact Phone Number" name="phoneNo" size="30" maxlength="13" required />
            <br><br>
            <input type="text" class="input-block-level" placeholder="Contact Email" name="eventEmail" size="30" maxlength="50" required />
            <br><br>
            Privacy: &nbsp;
            <select name="privacy" class ="input-block-level">
                <option value="public">Public</option>
                <option value="private">Private</option>
                <option value="rso">RSO</option>
            </select>
            <br>
            <h6>Image for Event:</h6>
            <input type="file" name="event_image">
            <br>
            <button class="btn btn-large btn-primary" type="submit" name="btn-createevent">Create Event</button>
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