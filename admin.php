<?php
				
session_start(); //starts the session and gets the username from the login page, or if they didn't login, redirects them to the login page.
$session = $_SESSION['username'];
if($session == NULL){
	header("Location: login.php");
}
if($session != "admin"){
	header("Location: login.php");
}
//connects to the database.
$dbh = new PDO('sqlite:CHSxlt.db') or die("cannot connect to database");
//creates the query that grabs information related to the user.
$user_query = $dbh->query("SELECT Id, FirstName, LastName, RoleId, DepartmentId FROM User WHERE Uname like '" . $session . "'");
while($user_array = $user_query->fetch(PDO::FETCH_ASSOC)){
	$user_id = $user_array['Id'];
	$user_first = $user_array['FirstName'];
	$user_last = $user_array['LastName'];
	$user_role = $user_array['RoleId'];
	$user_dept = $user_array['DepartmentId'];
}


	if (isset($_POST['delete_user'])){
		try{
			
			$del_sql = "DELETE FROM User WHERE Id='".$_POST['delete_user']."'";
			$dbh->exec($del_sql);
		}
		catch(PDOException $e){
			echo $del_sql . "<br>" . $e->getMessage();
		}
	}

	if(isset($_POST['create_user'])){
		$first_name = $_POST['fName'];
		$last_name = $_POST['lName'];
		$email = $_POST['email'];
		$user_name = $_POST['uName'];
		$id = $_POST['user_type'];
		if($id==2){
			$department=$_POST['department'];
		}
		try{
		$user_insert = $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($id==3){
			$sql = "INSERT INTO USER (FirstName, LastName, Email, Uname, Pword, RoleId, DepartmentId) VALUES ('".$first_name."', '".$last_name."', '".$email."', '".$user_name."', '".$user_name."', '".$id."', 10)";
		}
		else{
			$sql = "INSERT INTO USER (FirstName, LastName, Email, Uname, Pword, RoleId, DepartmentId) VALUES ('" .$first_name."', '".$last_name."', '".$email."', '".$user_name."', '".$user_name."', '".$id."', '".$department."')";
		}
		$dbh->exec($sql);
	}
	catch(PDOException $e){
		echo $sql . "<br>" . $e->getMessage();
	}
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Cedar High Tagging</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    box-sizing: border-box;
}

body {
  margin: 0;
}

/* Style the header */
.header {
    background-color: #f1f1f1;
    padding: 20px;
    text-align: center;
}

/* Style the top navigation bar */
.topnav {
    overflow: hidden;
    background-color: #333;
}

/* Style the topnav links */
.topnav a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
    background-color: #ddd;
    color: black;
}

/* Create two equal columns that floats next to each other */
.column {
    float: left;
    width: 25%;
    padding: 15px;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width:600px) {
    .column {
        width: 100%;
    }
}
</style>
</head>
<body>
<div class="header">
  <h1>Cedar High Tagging</h1>
</div>

<div class="topnav">
<h4><?php echo "Signed in as " . $user_first . " " . $user_last;?></h4>
</div>

<div class="row">
	<div class="column">
		<h2>Students</h2>
		<td>
			<table>
				<tr>
					<td id="students">
					<form action='' method='post'>
						<?php
							
							$student_sql = "SELECT Id, FirstName, LastName, Email FROM User WHERE RoleId=3";
							$student_array = array();
							$student_query = $dbh->query($student_sql);
								while($student_array = $student_query->fetch(PDO::FETCH_ASSOC)){
									$student_id = $student_array['Id'];
									$student_first = $student_array['FirstName'];
									$student_last = $student_array['LastName'];
									$student_email = $student_array['Email'];
									echo $student_first.' '.$student_last.' <button type="submit" name="delete_user" value="'.$student_id.'"" align="right">Delete</button><br> <br>' ;
								}
						?>
						</form>
					</td>
				</tr>
			</table>
		</td>
	  </div>
	  <div class="column">
    <h2>Create new Student</h2>
	<td>
		<table>
			<tr>
				<td id="students">
				<!-- form that gets the information for the new user action specifies the page, and method=post means we are posting this information to the indicated page.-->
				<form action="createUser.php" method="post"> <!--password the same as username-->
				<input type="text" placeholder = "Enter First Name" name="fName" id="fName" required><br>
				<input type="text" placeholder = "Enter Last Name" name="lName" id="lName" required><br>
				<input type="text" placeholder = "Email (Optional)" name="email" id="email"><br>
				<input type="text" placeholder = "Enter User Name" name="uName" id="uName" required><br><br>
				<input type="hidden" name="user_type" value="3"> <!-- this is a hidden variable that indicates what kind of user it is, 3 means student in this case-->
				
				<input type="submit" name ="create_user" value="Submit Student">
				
				</form>
				</td>
			</tr>
		</table>
	</td>
  </div>
	  <div class="column">
    <h2>Create new Teacher</h2>
	<td>
		<table>
			<tr>
				<td id="teacher">
					<form action="createUser.php" method="post"> <!--password the same as username-->
				<input type="text" placeholder = "Enter First Name" name="fName" id="fName" required><br>
				<input type="text" placeholder = "Enter Last Name" name="lName" id="lName" required><br>
				<input type="text" placeholder = "Email (Optional)" name="email" id="email"><br>
				<input type="text" placeholder = "Enter User Name" name="uName" id="uName" required><br>
				<select name="department">
					<option disabled selected>Select Department</option>
					<option value="2">CTE</option>
					<option value="3">English</option>
					<option value="4">Fine Arts</option>
					<option value="5">Foreign Language</option>
					<option value="6">Math</option>
					<option value="7">PE</option>
					<option value="8">Science</option>
					<option value="9">Social Science</option>
				</select> <br> <br>
				<input type="hidden" name="user_type" value="2">
				<input type="submit" name="create_user" value="Submit Teacher">
				</form>
				</td>
			</tr>
		</table>
	</td>
  </div>
  
  <div class="column">
    <h2>Teachers</h2>
    <td>
		<table>
			<tr>
				<td id="Teacher">
					<form action='' method='post'>
						<?php
							$teacher_sql = "SELECT Id, FirstName, LastName, Email, DepartmentId FROM User WHERE RoleId=2";
							$teacher_array = array();
							$teacher_query = $dbh->query($teacher_sql);
							while($teacher_array = $teacher_query->fetch(PDO::FETCH_ASSOC)){
								$teacher_id = $teacher_array['Id'];
								$teacher_first = $teacher_array['FirstName'];
								$teacher_last = $teacher_array['LastName'];
								$teacher_email = $teacher_array['Email'];
								$teacher_department = $teacher_array['DepartmentId'];
								echo $teacher_first . ' ' . $teacher_last . ' <button type="submit" name="delete_user" value="'.$teacher_id.'"" align="right">Delete</button><br> <br>' ;
							} 			
						?>
					</form>
				</td>
				
			</tr>
		</table>
	</td>
  </div>
</div>

</body>
<script text>
function alert(var value){
	alert(value);
}
</script>
</html>
