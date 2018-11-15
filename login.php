<?php

session_start();

echo "
<!DOCTYPE html>

<html>
<head>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js' type='text/javascript'></script>
<script>
	function alertTest(){
		
		alert(document.getElementById('userText').value);
		alert(document.getElementById('passText').value);
		
	}
	
	function setCookie(){
		document.cookie = 'username=' + document.getElementById('userText').value;
		document.cookie = 'password=' + document.getElementById('passText').value;
		
	}
	
	function checkLogin(){
		var cookiesArray = document.cookie.split('; ');
		var firstTxtArray= cookiesArray[0].split('=');
		var secondTxtArray= cookiesArray[1].split('=');
		var testData = {
			un: firstTxtArray[1],
			pw: secondTxtArray[1]
		};
		$.post('checkLogin.php',testData);
	}
	
	
	
</script>
<style>



.loginbox{
	width: 320px;
	height: 320px;
	background: ;
	color: #000;
	top: 50%;
	left: 50%;
	position: absolute;
	transform: translate(-50%, -50%);
	box-sizing: border-box;
	padding: 20px 40px;
}

.loginbox p{
	maring: 0;
	padding: 0;
	font-weight: bold;
}




.loginbox input[type='text'], input[type='password']
{
	width: 100%;
	margin-bottom: 5px;
	border: none;
	border-bottom: 1px solid #fff;
	background: #fff:
	outline: none;
	height: 40px;
	color: #000;
	font-size: 16px;
	
}

.loginbox input[type='submit']
{
	border: none;
	outline: none;
	height: 40px;
	background: #4594FB;
	color: #fff;
	font-size: 18px;
	float:right;
	
}

.loginbox input[type='submit']:hover{
	cursor: pointer;
}

.loginbox a{
	text-decoration: none;
	font-size: 12px;
	line-height: 20px;
	color: #4594FB;
	margin-top: 80px
}

.loginbox a:hover{
	cursor: pointer;
}

</style>

<body style='background-color:darkred'>
<div class='loginbox'>
<form action= 'login.php' method='post'>
  
  <input type='text' placeholder='Enter Username' name='username' id='userText'>
  <input type='password' placeholder='Enter Password' name='password' id='passText'>
  <input type='submit' name='' value='Login' id='loginTxt'>
  <a href='#'> Forgot password?</a><br>
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
					$result = $query->fetch(PDO::FETCH_ASSOC);
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
						echo "<script> alert('The username/password are incorrect');</script>";
					}
	
	
	
	
	
}
	
?>
