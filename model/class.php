<?php

error_reporting(E_ALL);

include_once 'connection.php';


/* ======= FUNCTIONS  =========== */

function systemUrl($path){
	$baseUrl ="http://www.skygroup.com.ph";
	return $basePath =$baseUrl . "/trainingsystem/".$path;
}

function pageTitle($title){
	return "<title>Training Management System | ".$title .  "</title>";
}

function redirect($page){
	echo "<script type=text/javascript>window.location.href='$page';</script>";
}


/* ======= CLASS =========== */
class User{

	private $username, $password;
	public  $error_msg;

	public function __construct(){
		$this->db = new connection();
		$this->db=$this->db->dbConnect();
	}

	public function getUserDetails($username,$password){
		$this->username= $username;
		$this->password=$password;

	}

	public function verifyUser($url){
		$sql = "SELECT * FROM login WHERE log_un=? AND log_pw=? LIMIT 1";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(1,$this->username,PDO::PARAM_STR);
		$stmt->bindParam(2,$this->password,PDO::PARAM_STR);
		$stmt->execute();

		if($stmt->rowCount()==1){
			while($rows=$stmt->fetch(PDO::FETCH_OBJ)){
				$this->error_msg = "";
				session_start();
				$_SESSION['tmsSucessfullLogin']=TRUE;
				$_SESSION['tmsFullname']=$rows->log_fn;
				$_SESSION['tmsUsername']=$rows->log_un;
				$_SESSION['tmsAuthorization']=$rows->log_au;
				$_SESSION['tmsPicture']=$rows->log_pic;
				header('location:'. $url);
				}
			}else{
				$this->error_msg = "<h4><strong><img src='img/system/error.png' height='35px' width='auto'> Error : username or password.</strong></h4>";
			}
		}
}#endClass


