<?php
				
session_start();
$session = $_SESSION['username'];
if($session == NULL){
	header("Location: login.php");
}
$dbh = new PDO('sqlite:CHSxlt.db') or die("cannot connect to database");
$user_query = $dbh->query("SELECT Id, FirstName, LastName, RoleId, DepartmentId FROM User WHERE Uname like '" . $session . "'");
while($user_array = $user_query->fetch(PDO::FETCH_ASSOC)){
	$user_id = $user_array['Id'];
	$user_first = $user_array['FirstName'];
	$user_last = $user_array['LastName'];
	$user_role = $user_array['RoleId'];
	$user_dept = $user_array['DepartmentId'];
}
$selected_date = NULL;
if (isset($_POST['date'])){
	$selected_date = $_POST['date'];
}

if (isset($_POST['tag_student'])){
	$selected_student_query = "SELECT TeacherId FROM Appointments WHERE StudentId = '" . $_POST['tag_student'] . "' AND Date like '" . $selected_date . "'";
	$verify_appointment = $dbh->query($selected_student_query);
	if($selected_student_array = $verify_appointment->fetch(PDO::FETCH_ASSOC)){
		echo"Student already tagged.";
	}
	else{
		$insert_sql = "INSERT INTO Appointments (TeacherId, StudentId, Date) VALUES (" . $user_id . ", '" . $_POST['tag_student'] . "', '" . $selected_date . "')";
		if($dbh->query($insert_sql)!=TRUE){
			echo "Error creating appointment";
		}
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
    width: 50%;
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<div class="header">
  <h1>Cedar High Tagging</h1>
</div>

<div class="topnav">
<h4><?php echo "Signed in as " . $user_first . " " . $user_last;?></h4>
</div>
<div>
	<p> </p>
	<form action="" method="post">
	<input type="date" name="date" id="date" value="<?php echo $selected_date; ?>">
	<input type="submit" value="Select Date">
</div>

<div class="row">
  <div class="column">
    <h2><?php if($user_role == 2){echo "Students to tag";} ?></h2>
	<td>
		<table>
			<tr>
				<td id="students">
				<?php
					$student_sql = "SELECT Id, FirstName, LastName FROM User WHERE RoleId=3";
					$student_array = array();
					$student_query = $dbh->query($student_sql);
					if($selected_date != NULL){
						if($user_role == 2){
							while($student_array = $student_query->fetch(PDO::FETCH_ASSOC)){
								$student_id = $student_array['Id'];
								$first = $student_array['FirstName'];
								$last = $student_array['LastName'];
								echo $first . ' ' . $last . ' <button type="submit" name="tag_student" value="' . $student_id . '" align="right"> Tag for ' . $selected_date . '</button><br><br>';
							}
						}
					}
					else{
						echo "Please select a date.";
					}
				?>
				</form>
				</td>
			</tr>
		</table>
	</td>
  </div>
  <div class="column">
    <h2>Appointments</h2>
    <td>
		<table>
			<tr>
				<td id="appointments">
				<?php
					if($selected_date != NULL){
						$appt_sql = "SELECT StudentId FROM Appointments WHERE TeacherId=". $user_id . " AND Date like '" . $selected_date . "'";
						$appt_array = array();
						$appt_query = $dbh->query($appt_sql);
						while($appt_array = $appt_query->fetch(PDO::FETCH_ASSOC)){
							$appt = $appt_array['StudentId'];
							$ridiculous_sql = "SELECT FirstName, LastName FROM User WHERE Id = '" . $appt . "'";
							$ridiculous_query = $dbh->query($ridiculous_sql);
							while($ridiculous_array = $ridiculous_query->fetch(PDO::FETCH_ASSOC)){
								$ridiculous_first = $ridiculous_array['FirstName'];
								$ridiculous_last = $ridiculous_array['LastName'];
								echo $ridiculous_first . " " . $ridiculous_last . "<br><br>";
							}
						}
					}
				?>
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
