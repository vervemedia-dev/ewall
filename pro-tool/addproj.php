<?php
session_start();
include 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Add Project | VerveMedia</title>

		<link href="css/vervemedia.css" rel="stylesheet" type="text/css" />
		<link type="image/x-icon" href="images/vervemedia.ico" rel="shortcut icon" />
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
		<script type="text/javascript" src="js/calendarDateInput.js"></script>
		<script type="text/javascript" src="js/addproj.js"></script>
	</head>
	<body>
		<div id="vervecontainer">
			<div id="contactheading">
				<div id="head-title">
					<p><a class="head" href="index.php" title="Home"><?php echo $site_name; ?></a></p>
				</div>
				<div id="head-user">
					<?php if(!isset($_SESSION['user'])){ ?>
				<div id="admin-area">
					<ul><li><a href="#dialog1" name="modal">Admin?</a></li></ul>
				</div>
				<div id="boxes">
					<!-- Start of Login Dialog -->  
					<div id="dialog1" class="window">
						<form action="admin.php" method="post">
						<div class="d-header">
							<input type="text" id="username" name="username" value="username" onclick="this.value=''"/><br/>
							<input type="password" id="password" name="password" value="password" onclick="this.value=''"/>    
						</div>
						<div class="d-blank"></div>
						<div class="d-login"><input type="image" value="Login" alt="Login" title="Login" src="images/login-button.png"/></div>
						</form>
					</div>
					<!-- End of Login Dialog --> 
					<div id="mask"></div>
				</div>
			<?php } else { ?>
				<div id="admin-area">
					<ul>
						<li><a href="addproj.php">Add New</a></li>
						<li><a href="logout.php">Sign out</a></li>
					</ul>
				</div>
			<?php } ?>
			
				</div>
				<div class="clear"></div>
			</div>
			<?php if($_SESSION['msg'] != '') { ?>
				<div id="msg" class="<?php echo $_SESSION['status']; ?>"><?php echo $_SESSION['msg']; ?></div>
			<?php $_SESSION['msg'] = ''; } ?>
			<form action="saveproj.php" method="POST" id="add-proj" name="addproj">
				<fieldset>
					<div>
						<label for="title">Project Title:</label><br>
						<input class="text" id="project-title" name="title" type="text" />
						<span id="nameInfo">What's the Project name?</span>
					</div>
					<div>
						<label for="cli_name">Client Name:</label><br>
						<input class="text" id="cli-name" name="cli_name" type="text" />
						<span id="clinameInfo">The one who gave us the project...</span>
					</div>
					<div>
						<input id="hourly-check" name="hourly_check" type="checkbox" />
						<label for="hourly_check">Hourly based</label>
					</div>
					<div class="task-hours">
						<input id="task-hours" name="task_hours" type="text" class="text" size="10"/>
						<span id="taskHourInfo">How long will be needed to completed..? Specify in hours.</span>
					</div>
					<div class="task-days">
						<div>
							<label for="start_date">Start Date:</label><br>
							<script>DateInput('start_date', true, 'DD-MON-YYYY')</script>
						</div>
						<div>
							<label for="end_date">End Date:</label><br>
							<script>DateInput('end_date', true, 'DD-MON-YYYY')</script>
							<span id="dayInfo"></span>
						</div>
					</div>
					<div class="no-date">
						<label for="assigned">Assigned To:</label><br>
						<select name="assigned">
							<option value="Srikanth">Srikanth</option>
							<option value="Ram">Ram</option>
							<option value="Solomon">Solomon</option>
						</select>
					</div>
					<div class="no-date">
						<label for="handled">Handled By:</label><br>
						<select name="handled">
							<option value="Anandh">Anandh</option>
							<option value="Manoj">Manoj</option>
							<option value="Jennifer">Jennifer</option>
							<option value="Bala">Bala</option>
						</select>
					</div>
					<div>
						<label for="members">Members:</label><br>
						<input class="text" id="members" name="members" type="text" />
						<span id="membersInfo">Team Members involved in this project. Ex: XXX, YYY, ZZZ</span>
					</div>
					<div class="no-date">
						<label for="handled">Status:</label><br>
						<select name="status">
							<option value="Open">Open</option>
							<option value="Closed">Closed</option>
							<option value="Held Off">Held Off</option>
							<option value="WCF">Waiting for Feedback</option>
							<option value="No Response">No Response</option>
							<option value="Cancelled">Cancelled</option>
						</select>
					</div>
					<div style="margin-bottom: 10px;">
						<label for="members">Status (in detail):</label><br>
						<textarea id="statustext" name="statustext" rows="4" cols="50" class="text"></textarea>
					</div>
					<div class="no-date">
						<label for="handled">Percentage:</label><br>
						<select name="percent">
							<option value="0">0%</option>
							<option value="10">10%</option>
							<option value="20">20%</option>
							<option value="30">30%</option>
							<option value="40">40%</option>
							<option value="50">50%</option>
							<option value="60">60%</option>
							<option value="70">70%</option>
							<option value="80">80%</option>
							<option value="90">90%</option>
							<option value="100">100%</option>
						</select>
					</div>
					<div class="remind">
						<label for="remind">Remind Me:</label><br>
						<input id="remind" name="remind" type="text" class="text" size="10"/>
						<span id="remindInfo">You will be highlighted in x days.</span>
					</div>
					<div>
						<label for="ref_url">Reference URL:</label><br>
						<input class="text" id="ref-url" name="ref_url" type="text" />
						<span id="refUrlInfo">Link to know more about this project...</span>
					</div>
					<div class="submit-btn">
						<input class="add-btn" id="form-submit" name="submit" type="submit" value="Add Project"/>
						<input class="close-btn" id="form-submit" name="submit" type="submit" value="Cancel"/>
					</div>
				</fieldset>
			</form>
		</div> <!--vervecontiner-->
		<div class="clear"></div>
		<div id="footer">
			<div id="copyright"><?php echo $footer_text; ?></div>
		</div>
	</body>
</html>
