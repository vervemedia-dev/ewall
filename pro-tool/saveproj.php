<?php
session_start();
include 'config.php';
$_SESSION['status'] = '';
// echo "<pre>";
// print_r($_POST);
// exit;
$id = $_POST["pr_id"];
$pro_title = $_POST["title"];
$cli_name = $_POST["cli_name"];
$hourly_check = $_POST["hourly_check"];
$task_hours = $_POST["task_hours"];
$start_date = $_POST["start_date"];
$sd = strtotime($start_date);
$end_date = $_POST["end_date"];
$ed = strtotime($end_date);
$assigned = $_POST["assigned"];
$handled = $_POST["handled"];
$members = $_POST["members"];
$status = $_POST["status"];
$statustext = $_POST["statustext"];
$percent = $_POST["percent"];
$remind = $_POST["remind"];
$ref_url = $_POST["ref_url"];
$time = time();

if($pro_title == ''){
	$_SESSION['msg'] .= 'Project Title is required';
	$_SESSION['status'] = 'error';
}

if($hourly_check == "on"){
	if($task_hours == ''){
		if(isset($_SESSION['msg'])) {
			$_SESSION['msg'] .= '<br>Specify the task hours';
		} else {
			$_SESSION['msg'] .= 'Specify the task hours';
		}
		$_SESSION['status'] = 'error';
	}
} else {
	if($ed < $sd) {
		if(isset($_SESSION['msg'])) {
			$_SESSION['msg'] .= '<br>Check your project End Date';
		} else {
			$_SESSION['msg'] .= 'Check your project End Date';
		}
		$_SESSION['status'] = 'error';
	}
}

if($percent != ''){
	if(!is_numeric($percent)){
		if(isset($_SESSION['msg'])) {
			$_SESSION['msg'] .= '<br>Project percentage should be numeric';
		} else {
			$_SESSION['msg'] .= 'Project percentage should be numeric';
		}
		$_SESSION['status'] = 'error';
	}
}

if($_SESSION['status'] == '') {
	
	if($_POST['submit'] == 'Add Project'){
		mysql_query("INSERT INTO projects (`pr_name`, `client_name`, `start_date`, `end_date`, `deadline_hours`, `percent`, `assigned`, `handled`, `members`, `ref_url`, `status`, `remind`, `created`, `updated`) VALUES ('$pro_title', '$cli_name', '$start_date', '$end_date', '$task_hours', '$percent', '$assigned', '$handled', '$members', '$ref_url', '$status', '$remind', '$time', '$time')");
		
		if($statustext) {
			$last_id = mysql_query("SELECT pr_no FROM projects ORDER BY pr_no DESC LIMIT 1");
			mysql_query("INSERT INTO project_status (`pr_no`, `status`, `comments`, `updated`) VALUES ('$last_id', '$status', '$statustext', '$time')");			
		}
		
		mysql_close($con);
		$_SESSION['msg'] = 'Project is now added successfully';
		$_SESSION['status'] = 'success';
		header("location:index.php");
	}
	
	if($_POST['submit'] == 'Update Project'){
		mysql_query("UPDATE projects SET pr_name = '$pro_title',
		client_name = '$cli_name',
		start_date = '$start_date',
		end_date = '$end_date',
		deadline_hours = '$task_hours',
		percent = '$percent',
		assigned = '$assigned',
		handled = '$handled',
		members = '$members',
		ref_url = '$ref_url',
		status = '$status',
		remind = '$remind',
		updated = '$time' WHERE pr_no = '$id'");
		if($statustext) {
			mysql_query("INSERT INTO project_status (`pr_no`, `status`, `comments`, `updated`) VALUES ('$id', '$status', '$statustext', '$time')");	
		}
		mysql_close($con);
		$_SESSION['msg'] = 'Project '.$pro_title.' updated successfully';
		$_SESSION['status'] = 'success';
		header("location:index.php");
	}
	
	if($_POST['submit'] == 'Cancel'){
		header("location:index.php");
	}
	
	if($_POST['submit'] == 'Delete'){	
		mysql_query("DELETE FROM projects WHERE pr_no = '$id'");
		mysql_close($con);
		$_SESSION['msg'] = 'Project '.$pro_title.' deleted successfully';
		$_SESSION['status'] = 'success';
		header("location:index.php");
	}
} else {
	$_SESSION['status'] = "error";
	header("location:addproj.php");
}
?>