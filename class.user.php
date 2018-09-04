<?php
date_default_timezone_set('Etc/UTC');
require_once 'dbconfig.php';
class USER
{
    private $conn;
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
    public function lasdID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }
    public function register($uname,$email,$upass,$code)
    {
        try
        {
            $password = md5($upass);
            $stmt = $this->conn->prepare("INSERT INTO users(userName,userEmail,userPass,tokenCode)
                                                VALUES(:user_name, :user_mail, :user_pass, :active_code)");
            $stmt->bindparam(":user_name",$uname);
            $stmt->bindparam(":user_mail",$email);
            $stmt->bindparam(":user_pass",$password);
            $stmt->bindparam(":active_code",$code);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

    public function registerStudent($userID, $university)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO userstudent(userID, university) 
              VALUES (:userID, :university)");
            $stmt->bindparam(":userID",$userID);
            $stmt->bindparam(":university",$university);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert student into the database.");
            echo $ex->getMessage();
        }
    }

    public function registerSuperAdmin($userID)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO usersuperadmin(userID) 
              VALUES (:userID)");
            $stmt->bindparam(":userID",$userID);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert super admin into the database.");
            echo $ex->getMessage();
        }
    }

    public function registerAdmin($userID)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO useradmin(userID) 
              VALUES (:userID)");
            $stmt->bindparam(":userID",$userID);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert useradmin into the database.");
            echo $ex->getMessage();
        }
    }

    public function ownsRSO($userID, $RSOId)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO owns(userID,RSOId)
             VALUES(:userID,:RSOId)");
            $stmt->bindparam(":userID", $userID);
            $stmt->bindparam(":RSOId", $RSOId);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            die("Wasn't able to insert ownsRSO into the database.");

        }
    }

    public function makeRSO($RSOName, $RSODescription, $membersNo)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO rso(RSOName,RSODescription,membersNo)
             VALUES(:RSOName,:RSODescription,:membersNo)");
            $stmt->bindparam(":RSOName", $RSOName);
            $stmt->bindparam(":RSODescription", $RSODescription);
            $stmt->bindparam(":membersNo", $membersNo);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            die("Wasn't able to insert rso into the database.");

        }
    }

    public function RSOcreator($userID, $RSOId)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO makes(userID,RSOId)
             VALUES(:userID,:RSOId)");
            $stmt->bindparam(":userID", $userID);
            $stmt->bindparam(":RSOId", $RSOId);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            die("Wasn't able to insert makesRSO into the database.");

        }
    }

    public function joinRSO($userID, $RSOId)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO joins(userID,RSOId)
             VALUES(:userID,:RSOId)");
            $stmt->bindparam(":userID", $userID);
            $stmt->bindparam(":RSOId", $RSOId);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            die("Wasn't able to insert joinsRSO into the database.");

        }
    }

    public function leaveRSO($userID, $RSOId)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM joins WHERE userID=:userID AND RSOId=:RSOId");
            $stmt->bindparam(":userID", $userID);
            $stmt->bindparam(":RSOId", $RSOId);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            die("Wasn't able to insert joinsRSO into the database.");

        }
    }

    public function updateRSONumber($RSOId, $membersNo)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE rso SET
             membersNo=:membersNo WHERE RSOId=:RSOId");
            $stmt->bindparam(":RSOId", $RSOId);
            $stmt->bindparam(":membersNo", $membersNo);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            die("Wasn't able to insert update members count into the database.");

        }
    }

    public function makeEvent($eventName,$category,$eventDescription,$time,$date,$phoneNo,$eventEmail,$privacy,$locationName,$latitude,$longitude,$eventImage,$uName)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO event(eventName,category,eventDescription,time,date,phoneNo,eventEmail,privacy,locationName,latitude,longitude,eventImage,uName)
             VALUES(:eventName,:category,:eventDescription,:time,:date,:phoneNo,:eventEmail,:privacy,:locationName,:latitude,:longitude,:eventImage,:uName)");
            $stmt->bindparam(":eventName",$eventName);
            $stmt->bindparam(":category",$category);
            $stmt->bindparam(":eventDescription",$eventDescription);
            $stmt->bindparam(":time",$time);
            $stmt->bindparam(":date",$date);
            $stmt->bindparam(":phoneNo", $phoneNo);
            $stmt->bindparam(":eventEmail", $eventEmail);
            $stmt->bindparam(":privacy", $privacy);
            $stmt->bindparam(":locationName", $locationName);
            $stmt->bindparam(":latitude", $latitude);
            $stmt->bindparam(":longitude", $longitude);
            $stmt->bindparam(":eventImage", $eventImage);
            $stmt->bindparam(":uName", $uName);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert event into the database.");
            echo $ex->getMessage();
        }

    }

    public function makePublicEvent($eventId)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO publicevent(eventId) 
              VALUES (:eventId)");
            $stmt->bindparam(":eventId",$eventId);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert event into the database.");
            echo $ex->getMessage();
        }

    }

    public function makePrivateEvent($eventId)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO privateevent(eventId) 
              VALUES (:eventId)");
            $stmt->bindparam(":eventId",$eventId);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert event into the database.");
            echo $ex->getMessage();
        }

    }

    public function makeRSOEvent($eventId)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO rsoevent(eventId)
             VALUES(:eventId)");
            $stmt->bindparam(":eventId",$eventId);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert event into the database.");
            echo $ex->getMessage();
        }
    }

    public function makeComment($commentString)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO commentinfo(commentString)
             VALUES(:commentString)");
            $stmt->bindparam(":commentString", $commentString);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            die("Wasn't able to insert comment info into the database.");

        }
    }

    public function comments($userID, $commentId, $eventId)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO comments(userID, commentId, eventId)
             VALUES(:userID, :commentId, :eventId)");
            $stmt->bindparam(":userID", $userID);
            $stmt->bindparam(":commentId", $commentId);
            $stmt->bindparam(":eventId", $eventId);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            die("Wasn't able to insert comments into the database.");

        }
    }

    public function approvePublicEvent($eventId, $userID)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO approvespub(eventId, userID)
             VALUES(:eventId, :userID)");
            $stmt->bindparam(":eventId",$eventId);
            $stmt->bindparam(":userID",$userID);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert public event approval into the database.");
            echo $ex->getMessage();
        }
    }

    public function approvePrivateEvent($eventId, $userID)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO approvespriv(eventId, userID)
             VALUES(:eventId, :userID)");
            $stmt->bindparam(":eventId",$eventId);
            $stmt->bindparam(":userID",$userID);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert private event approval into the database.");
            echo $ex->getMessage();
        }
    }

    public function deleteEvent($eventId)
    {
        try{
            $stmt = $this->conn->prepare("DELETE FROM event WHERE eventId=:eventId");
            $stmt->bindparam(":eventId",$eventId);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert private event approval into the database.");
            echo $ex->getMessage();
        }
    }

    public function hostEvent($userID, $eventId)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO hosts(userID,eventId) 
              VALUES (:userID,:eventId)");
            $stmt->bindparam(":userID",$userID);
            $stmt->bindparam(":eventId",$eventId);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex) {
            die("Wasn't able to insert host event into the database.");
            echo $ex->getMessage();
        }
    }

    public function login($email,$upass)
    {
        try
        {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id"=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() == 1)
            {
                if($userRow['userStatus']=="Y")
                {
                    if($userRow['userPass']==md5($upass))
                    {
                        $_SESSION['userSession'] = $userRow['userID'];
                        return true;
                    }
                    else
                    {
                        header("Location: index.php?error");
                        exit;
                    }
                }
                else
                {
                    header("Location: index.php?inactive");
                    exit;
                }
            }
            else
            {
                header("Location: index.php?error");
                exit;
            }
        }
        catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }
    public function is_logged_in()
    {
        if(isset($_SESSION['userSession']))
        {
            return true;
        }
    }

    public function is_superadmin()
    {
        $adminCheck = $this->conn->prepare("SELECT * FROM usersuperadmin WHERE userID = :user_id");
        $adminCheck->execute(array(":user_id"=>$_SESSION['userSession']));
        $row2 = $adminCheck->fetch(PDO::FETCH_ASSOC);

        if($adminCheck->rowCount() > 0)
        {
            return true;
        }

    }

    public function is_admin()
    {
        $adminCheck = $this->conn->prepare("SELECT * FROM useradmin WHERE userID = :user_id");
        $adminCheck->execute(array(":user_id"=>$_SESSION['userSession']));
        $row2 = $adminCheck->fetch(PDO::FETCH_ASSOC);

        if($adminCheck->rowCount() > 0)
        {
            return true;
        }

    }

    public function makeUni($uni_name, $uni_loc, $uni_des, $stu_num, $uni_im)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO universityprofile(name,location,description,studentNo,image)
              VALUES(:uni_name, :uni_loc, :uni_des, :stu_num, :uni_im)");
            $stmt->bindparam(":uni_name",$uni_name);
            $stmt->bindparam(":uni_loc",$uni_loc);
            $stmt->bindparam(":stu_num",$stu_num);
            $stmt->bindparam(":uni_des",$uni_des);
            $stmt->bindparam(":uni_im", $uni_im);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex)
        {
            die("Wasn't able to insert university profile into the database.");
            echo $ex->getMessage();
        }

    }

    public function createUni($uni_name, $userID)
    {
        try{
            $stmt = $this->conn->prepare("INSERT INTO creates(name,userID)
              VALUES(:uni_name, :userID)");
            $stmt->bindparam(":uni_name",$uni_name);
            $stmt->bindparam(":userID",$userID);
            $stmt->execute();
            return $stmt;
        }
        catch(PDOException $ex)
        {
            die("Wasn't able to insert into the creates table in the database.");
            echo $ex->getMessage();
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
    }
    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }
    function send_mail($email,$message,$subject)
    {
        require 'PHPMailerAutoload.php';
        $mail = new PHPMailer; // fill in your email information here
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->Host       = 'mail.notdevin.com';
        $mail->Port       = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth   = true;
        $mail->Username="_mainaccount@notdevin.com";
        $mail->Password="PJQ_E_sc3y07";
        $mail->AddAddress($email);
        $mail->SetFrom('NoReply@Group6.com','Group 6');
        $mail->AddReplyTo('NoReply@Group6.com','Group 6');
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        if (!$mail->send()){
            echo "Mailer Error: " .$mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
}
