<?php 
session_start(); 
include 'config.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Projects Tracker | VerveMedia</title>

		<link href="css/vervemedia.css" rel="stylesheet" type="text/css" />
		<link href="css/jquery.cluetip.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="../css/slider.css" type="text/css" media="screen" />
		<link type="image/x-icon" href="images/vervemedia.ico" rel="shortcut icon" />
		
		<style type="text/css" title="currentStyle">
			@import "data_tables/media/css/demo_page.css";
			@import "data_tables/media/css/demo_table.css";
		</style>
		<script type="text/javascript" language="javascript" src="data_tables/media/js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="data_tables/media/js/jquery.dataTables.js"></script>
		<script type="text/javascript" language="javascript" src="js/jquery.cluetip.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				// $('#proj-list').dataTable();

				$('#proj-list').dataTable( {
					"iDisplayLength": 50,
					"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]
				} );
				
				$('a.basic').cluetip({sticky: true, closePosition: 'title', arrows: true});
				$('a.basic-status').cluetip({sticky: true, closePosition: 'title', arrows: true});

				//select all the a tag with name equal to modal
				$('a[name=modal]').click(function(e) {
					//Cancel the link behavior
					e.preventDefault();

					//Get the A tag
					var id = $(this).attr('href');

					//Get the screen height and width
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();

					//Set heigth and width to mask to fill up the whole screen
					$('#mask').css({'width':maskWidth,'height':maskHeight});

					//transition effect		
					$('#mask').fadeIn(1000);	
					$('#mask').fadeTo("slow",0.8);	

					//Get the window height and width
					var winH = $(window).height();
					var winW = $(window).width();

					//Set the popup window to center
					$(id).css('top',  winH/2-$(id).height()/2);
					$(id).css('left', winW/2-$(id).width()/2);

					//transition effect
					$(id).fadeIn(2000); 
				});

				//if close button is clicked
				$('.window .close').click(function (e) {
					//Cancel the link behavior
					e.preventDefault();

					$('#mask').hide();
					$('.window').hide();
				});		

				//if mask is clicked
				$('#mask').click(function () {
					$(this).hide();
					$('.window').hide();
				});			

				$(window).resize(function () {
					var box = $('#boxes .window');

					//Get the screen height and width
					var maskHeight = $(document).height();
					var maskWidth = $(window).width();

					//Set height and width to mask to fill up the whole screen
					$('#mask').css({'width':maskWidth,'height':maskHeight});

					//Get the window height and width
					var winH = $(window).height();
					var winW = $(window).width();

					//Set the popup window to center
					box.css('top',  winH/2 - box.height()/2);
					box.css('left', winW/2 - box.width()/2);
				});
			});
		</script>
		
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
			<?php
				// DB connections
				$result = mysql_query("SELECT * FROM projects ORDER BY end_date DESC");
			?>
			<table id="proj-list">
			<thead>
				<tr>
					<th>Proj No</th>
					<th>Project Title</th>
					<th>Status</th>
					<th>Start Date</th>
					<th>Assinged To</th>
					<th>Handled By</th>
					<th>Time Left</th>
					<th>Percentage</th>
					<?php if(isset($_SESSION['user'])){ ?>
					<th>Actions</th>
					<?php } ?>
				</tr>
			</thead>
			<?php
			while($row = mysql_fetch_array($result)) { $pro_id = $row['pr_no']; ?>
			<tr class="<?php echo get_color_status($row['start_date'], $row['end_date'], $row['status']); ?>">
				<td class="<?php echo get_light_status($row['status']); ?>"><?php echo $row['pr_no']; ?></td>
				<!-- <td class="<?php echo get_light_status($row['status']); ?>"><?php echo get_color_status($row['start_date'], $row['end_date'], $row['status']); ?></td> -->
				<td><a class="basic" title="<?php echo $row['pr_name']; ?>" href="pro-details.php?id=<?php echo $row['pr_no']; ?>" rel="pro-details.php?id=<?php echo $row['pr_no']; ?>"><?php echo $row['pr_name']; ?></a></td>
				<?php 
				$pro_status = mysql_fetch_object(mysql_query("SELECT * FROM project_status WHERE pr_no = '$pro_id' LIMIT 1"));
				if($pro_status->status_id != '') { ?>
					<td class="status-comment"><a class="basic-status" title="<?php echo $row['pr_name']; ?>" href="pro-status.php?id=<?php echo $row['pr_no']; ?>" rel="pro-status.php?id=<?php echo $row['pr_no']; ?>"><?php echo $row['status']; ?></a></td>
				<?php } else { ?>
					<td class="status"><?php echo $row['status']; ?></td>
				<?php }  ?>
				<td><?php echo $row['start_date']; ?></td>
				<td><?php echo $row['assigned']; ?></td>
				<td><?php echo $row['handled']; ?></td>
				<td><?php echo ($row['status']=="Open") ? days_left($row['start_date'], $row['end_date'], $row['deadline_hours']):"---"; ?></td>
				<td width=200 style="padding:none"><hr style="color:#BFFFC5; background-color:#BFFFC5; height:15px; border:none;margin:0;position: relative;" align="left" width=<?php echo $row['percent']; ?>% /><span class="percent"><?php echo $row['percent']; ?>%</span></td>
				<?php if(isset($_SESSION['user'])){ ?>
				<td class="edit-action"><a class="edit-btn" href="editproj.php?projid=<?php echo $row['pr_no']; ?>">edit</a></td>
				<?php } ?>
			</tr>
			<?php } ?>
			</table>
		</div> <!--vervecontiner-->
		<div class="clear"></div>
		<div id="footer">
			<div id="copyright"><?php echo $footer_text; ?></div>
		</div>
	</body>
</html>

<?php 
function days_left($start_date, $end_date, $hours) {
	if($hours == 0) {
		$sd = strtotime($start_date);
		$ed = strtotime($end_date);
		$today = strtotime(date('Y-m-d'));
		if($sd > $today) {
			$diff = $sd - $today;
			$days= floor($diff/(60*60*24));
			if($days > 0) {
				if($days == 1) {
					return $days.' Day to commence';
				} else {
					return $days.' Days to commence';
				}
			}
		} else {
			$diff = $ed - $today;
			$days= floor($diff/(60*60*24));
			$hours= floor($diff/(60*60));
			if($days > 1) {
				return $days.' Days';
			} else if($days >= 0) {
				if($hours == 0) {
					return 'Today Deadline';
				} else {
					return $hours.' Hours';
				}
			} else {
				return 'Exceeded';
			}
		}
		
	} else {
		return $hours.' Hours';
	}
}

function get_light_status($status) {
	if($status == 'No Response') {
		return "light";
	}
	return null;
}

function get_color_status($start_date, $end_date, $status) {
	if($status == "No Response" || $status == "WCF") {
		$color = "red";
		return $color;
	} else if($status == "Closed"){
		$color = "green";
		return $color;
	}  else if($status == "Cancelled" || $status == "Held Off"){
		$color = "brown";
		return $color;		
	} else {
		$sd = strtotime($start_date);
		$ed = strtotime($end_date);
		$today = strtotime(date('Y-m-d'));
		if($sd > $today) {
			$diff = $sd - $today;
			$days= floor($diff/(60*60*24));
			if($days > 0) {
				return 'white';
			} else if($days == 0) {
				return 'blue';
			}
		} else {
			$diff = $ed - $today;
			$days= floor($diff/(60*60*24));
			$hours= floor($diff/(60*60));
			if($days > 1) {
				return 'blue';
			} else if($days == 1) {
				return 'yellow';
			} else if($days >= 0) {
				return 'red';
			} else {
				return 'red blink';
			}
		}
	}
}
	
?>