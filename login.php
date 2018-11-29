<?php
// starts the session and creates the html page.
session_start();

echo "
<!DOCTYPE html>

<html>
<head>
<script>
	function adminAlert(){
		alert('Please contact your admin for assistance in reseting your password');
	}
</script>
<style>
.image {
	display: flex;
	margin-top: auto;
    margin-left: auto;
    margin-right: auto;
}

.loginbox{
	width: 35%;
	height: 35%;
	color: #000;
	top: 50%;
	left: 50%;
	position: absolute;
	transform: translate(-50%, -50%);
	//box-sizing: border-box;
	padding: 2%;
	padding-top: 15%
}


.loginbox input[type='text'], input[type='password']
{
	width: 98%;
	margin-bottom: 4%;
	border: none;
	//border-bottom: 5px solid #fff;
	background: #fff:
	outline: none;
	color: #000;
	font-size: 90%;
	padding-bottom: 3%;
	padding-top: 3%;
	padding-left: 2%;

	
	
}

.loginbox input[type='submit']
{
	border: none;
	outline: none;
	background: #4594FB;
	color: #fff;
	font-size: 90%;
	float:right;
	border-radius: 10%;
	padding-bottom: 3%;
	padding-top: 3%;
	padding-right: 10%;
	padding-left: 10%;

	
}

.loginbox input[type='submit']:hover{
	cursor: pointer;

}

.loginbox a{
	text-decoration: none;
	font-size: 75%;
	line-height: 0%;
	color: #4594FB;
	margin-top: 0%;
}

.loginbox a:hover{
	cursor: pointer;
}


</style>

<body style='background-color:#990000'>
<img src='barelogo.png' style='width:35%;height:25%;' class='image' >
<div class='loginbox'>
<form action= 'login.php' method='post'>
  
  <input type='text' placeholder='Enter Username' name='username' id='userText'>
  <input type='password' placeholder='Enter Password' name='password' id='passText'>
  <input type='submit' name='' value='Login' id='loginTxt'>
  <a href='#' onClick='adminAlert()'> Forgot password?</a><br>
</form>
</div>
</body>
</head>
</html>
";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$username = $_POST["username"];
	$password = $_POST["password"];
	$_SESSION['username'] = $username;
	
	$dbh = new PDO('sqlite:CHSxlt.db') or die("cannot connect to database");
					$sql = "SELECT Pword,RoleId FROM User WHERE Uname = '".$username."'";
					$query = $dbh->query($sql);
					if($result = $query->fetch(PDO::FETCH_ASSOC)){
						$loginOkay = strcasecmp($result["Pword"], $password);
						
						if($loginOkay==0){
							if($result["RoleId"]!=1){
								header("Location: index.php");
							}
							else{
								header("Location: admin.php");
							}
							
						}
						else{
							echo "<script> alert('The password is incorrect');</script>";
						}
					}
					else{
						echo "<script> alert('The username is invalid');</script>";
					}
	
	
	
	
	
}
	
?>
