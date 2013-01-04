<?php
session_start();
include 'config.php';
if(isset($_REQUEST['projid']) && $_REQUEST['projid'] != '') {
	$pro_id = $_REQUEST['projid'];
}
// DB connections
$result = mysql_query("SELECT * FROM projects WHERE pr_no = '$pro_id'");
while($row = mysql_fetch_array($result)) { 
	$pr_id = $row['pr_no'];
	$title = $row['pr_name'];
	$client_name = $row['client_name'];
	$start_date = $row['start_date'];
	$end_date = $row['end_date'];
	$deadline_hours = $row['deadline_hours'];
	$percent = $row['percent'];
	$assigned = $row['assigned'];
	$handled = $row['handled'];
	$members = $row['members'];
	$ref_url = $row['ref_url'];
	$status = $row['status'];
	$remind = $row['remind'];
}
$last_status = mysql_fetch_object(mysql_query("SELECT * FROM project_status WHERE pr_no = '$pro_id' ORDER BY status_id DESC"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Edit Project | VerveMedia</title>

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
			<form action="saveproj.php" method="POST" id="add-proj" name="editproj">
				<input name="pr_id" type="hidden" value="<?php echo $pr_id; ?>"/>
				<fieldset>
					<div>
						<label for="title">Project Title:</label><br>
						<input class="text" id="project-title" name="title" type="text" value="<?php echo $title; ?>"/>
						<span id="nameInfo">What's the Project name?</span>
					</div>
					<div>
						<label for="cli_name">Client Name:</label><br>
						<input class="text" id="cli-name" name="cli_name" type="text" value="<?php echo $client_name; ?>" />
						<span id="clinameInfo">The one who gave us the project...</span>
					</div>
					<div>
						<input id="hourly-check" name="hourly_check" type="checkbox" <?php if($deadline_hours!=0){ ?> checked="on" <?php } ?> />
						<label for="hourly_check">Hourly based</label>
					</div>
					<div class="task-hours">
						<input id="task-hours" name="task_hours" type="text" class="text" size="10" value="<?php echo $deadline_hours; ?>" />
						<span id="taskHourInfo">How long will be needed to completed..? Specify in hours.</span>
					</div>
					<div class="task-days">
						<div>
							<label for="start_date">Start Date:</label><br>
							<script>DateInput('start_date', true, 'DD-MON-YYYY', '<?php echo $start_date; ?>')</script>
						</div>
						<div>
							<label for="end_date">End Date:</label><br>
							<script>DateInput('end_date', true, 'DD-MON-YYYY', '<?php echo $end_date; ?>')</script>
							<span id="dayInfo"></span>
						</div>
					</div>
					<div class="no-date">
						<label for="assigned">Assigned To:</label><br>
						<select name="assigned">
							<option value="Srikanth" <?php echo $assigned == "Srikanth" ? "selected" : ""; ?>>Srikanth</option>
							<option value="Ram" <?php echo $assigned == "Ram" ? "selected" : ""; ?>>Ram</option>
							<option value="Solomon" <?php echo $assigned == "Solomon" ? "selected" : ""; ?>>Solomon</option>
						</select>
					</div>
					<div class="no-date">
						<label for="handled">Handled By:</label><br>
						<select name="handled">
							<option value="Anandh" <?php echo $handled == "Anandh" ? "selected" : ""; ?>>Anandh</option>
							<option value="Manoj" <?php echo $handled == "Manoj" ? "selected" : ""; ?>>Manoj</option>
							<option value="Jennifer" <?php echo $handled == "Jennifer" ? "selected" : ""; ?>>Jennifer</option>
							<option value="Bala" <?php echo $handled == "Bala" ? "selected" : ""; ?>>Bala</option>
						</select>
					</div>
					<div>
						<label for="members">Members:</label><br>
						<input class="text" id="members" name="members" type="text" value="<?php echo $members; ?>" />
						<span id="membersInfo">Team Members involved in this project. Ex: XXX, YYY, ZZZ</span>
					</div>
					<div class="no-date">
						<label for="handled">Status:</label><br>
						<select name="status">
							<option value="Open" <?php echo $status == "Open" ? "selected" : ""; ?>>Open</option>
							<option value="Closed" <?php echo $status == "Closed" ? "selected" : ""; ?>>Closed</option>
							<option value="Held Off" <?php echo $status == "Held Off" ? "selected" : ""; ?>>Held Off</option>
							<option value="WCF" <?php echo $status == "WCF" ? "selected" : ""; ?>>Waiting for Feedback</option>
							<option value="No Response" <?php echo $status == "No Response" ? "selected" : ""; ?>>No Response</option>
							<option value="Cancelled" <?php echo $status == "Cancelled" ? "selected" : ""; ?>>Cancelled</option>
						</select>
					</div>
					<div style="margin-bottom: 10px;">
						<label for="members">Status (in detail):</label><br>
						<textarea id="statustext" name="statustext" rows="4" cols="50" class="text"></textarea>
						<?php if($last_status->comments) { ?>
						<br><span id="laststatus">Last Status: <?php echo $last_status->comments.'<br>Updated on: '.date('d/M/Y', $last_status->updated); ?></span><br>
						<?php } ?>
					</div>
					<div class="no-date">
						<label for="handled">Percentage:</label><br>
						<select name="percent">
							<option value="0" <?php echo $percent == "0" ? "selected" : ""; ?>>0%</option>
							<option value="10" <?php echo $percent == "10" ? "selected" : ""; ?>>10%</option>
							<option value="20" <?php echo $percent == "20" ? "selected" : ""; ?>>20%</option>
							<option value="30" <?php echo $percent == "30" ? "selected" : ""; ?>>30%</option>
							<option value="40" <?php echo $percent == "40" ? "selected" : ""; ?>>40%</option>
							<option value="50" <?php echo $percent == "50" ? "selected" : ""; ?>>50%</option>
							<option value="60" <?php echo $percent == "60" ? "selected" : ""; ?>>60%</option>
							<option value="70" <?php echo $percent == "70" ? "selected" : ""; ?>>70%</option>
							<option value="80" <?php echo $percent == "80" ? "selected" : ""; ?>>80%</option>
							<option value="90" <?php echo $percent == "90" ? "selected" : ""; ?>>90%</option>
							<option value="100" <?php echo $percent == "100" ? "selected" : ""; ?>>100%</option>
						</select>
					</div>
					<div class="remind">
						<label for="remind">Remind Me:</label><br>
						<input id="remind" name="remind" type="text" class="text" size="10" value="<?php echo $remind; ?>" />
						<span id="remindInfo">You will be highlighted in x days.</span>
					</div>
					<div>
						<label for="ref_url">Reference URL:</label><br>
						<input class="text" id="ref-url" name="ref_url" type="text" value="<?php echo $ref_url; ?>" />
						<span id="refUrlInfo">Link to know more about this project...</span>
					</div>
					<div class="submit-btn">
						<input class="upd-btn" id="form-submit" name="submit" type="submit" value="Update Project"/>
						<input class="del-btn" id="form-submit" name="submit" type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete?')"/>
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
