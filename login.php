<!DOCTYPE html>

<html>
<head>
<script>
	function alertTest(){
		
		alert(document.getElementById("userText").value);
		alert(document.getElementById("passText").value);
		
	}
	
	function setCookie(){
		document.cookie = "username=" + document.getElementById("userText").value;
		document.cookie = "password=" + document.getElementById("passText").value;
		alert(document.cookie);
	}
	
	function getCookie(){
		var cookiesArray = document.cookie.split("; ");
		alert(cookiesArray[0]);
		alert(cookiesArray[1]);
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




.loginbox input[type="text"], input[type="password"]
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

.loginbox input[type="submit"]
{
	border: none;
	outline: none;
	height: 40px;
	background: #4594FB;
	color: #fff;
	font-size: 18px;
	float:right;
	
}

.loginbox input[type="submit"]:hover{
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

<body style="background-color:darkred" onload="getCookie()">
<div class="loginbox">
<form method="get">
  
  <input type="text" placeholder="Enter Username" name="username" id="userText">
  <input type="password" placeholder="Enter Password" name="password" id="passText">
  <input type="submit" name="" value="Login" id="loginTxt" onclick="setCookie()">
  <a href="#"> Forgot password?</a><br>
</form>
</div>
</body>
</head>
</html>
