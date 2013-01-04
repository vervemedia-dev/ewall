<link href="css/vervemedia.css" rel="stylesheet" type="text/css" />
<?php
include 'config.php';
if(isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
	$pro_id = $_REQUEST['id'];
}
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

if (strpos($ref_url, 'http://') === false) {
    $ref_url = 'http://'.$ref_url;
}

function we_stand($start_date, $end_date, $hours) {
	if($hours == 0) {
		$sd = strtotime($start_date);
		$ed = strtotime($end_date);
		$today = strtotime(date('Y-m-d'));
		if($sd > $today) {
			return '0';
		} else {
			$diff1 = $today - $sd;
			$top = floor($diff1/(60*60*24));
			$diff2 = $ed - $sd;
			$bottom= floor($diff2/(60*60*24));
			$stand_percent = round(($top/$bottom)*100);
			if($stand_percent > 100) {
				return 100;
			} else {
				return $stand_percent;
			}
		}		
	} else {
		return '0';
	}
}

if($deadline_hours == 0) {
	$diff = strtotime(date('Y-m-d')) - strtotime($start_date);
	$stand = floor($diff/(60*60*24));

	switch ($stand) {
		case 1:
			$stand = $stand.'st';
			break;
		case 2:
			$stand = $stand.'nd';
			break;
		case 3:
			$stand = $stand.'rd';
			break;
		default:
			$stand = $stand.'th';
			break;
	}

	$diff = strtotime($end_date) - strtotime($start_date);
	$total = floor($diff/(60*60*24));
}

$output = '<div class="content-box vertical-space item-meta-attributes">
      <table cellspacing="0" cellpadding="0" border="0" id="item_attributes">
        <tbody>
				<tr>
            <td class="attr-name">Client Name</td>
            <td class="attr-detail">'.$client_name.'</td>
          </tr>';
if ($deadline_hours == 0) {
         $output .= '<tr>
            <td class="attr-name">Start Date</td>
            <td class="attr-detail">'.$start_date.'</td>
          </tr>
          <tr>
            <td class="attr-name">End Date</td>
            <td class="attr-detail">'.$end_date.'</td>
          </tr>';
					 $output .= '<tr>
            <td class="attr-name">No of Days</td>
            <td class="attr-detail">'.$total.'</td>
          </tr>
					<tr>
            <td class="attr-name">We Stand on</td>
            <td class="attr-detail">'.$stand.' day</td>
          </tr>
					<tr>
            <td class="attr-name">We stand here</td>
            <td class="attr-detail" width="150" style="padding:0px; border: 1px solid;"><hr style="color:#BFFFC5; background-color:#BFFFC5; height:28px; border:none; margin:0; position:relative;" align="left" width='.we_stand($start_date, $end_date, $deadline_hours).'% ></td>
          </tr>';
					} else {
          $output .= '<tr>
					<td class="attr-name">Hours Required</td>
            <td class="attr-detail">'.$deadline_hours.'</td>
          </tr>';
					}
         $output.= '
					<tr>
            <td class="attr-name">Status</td>
            <td class="attr-detail">'.$status.'</td>
          </tr>
          <tr>
            <td class="attr-name">Members Involved</td>
            <td class="attr-detail">'.$members.'</td>
          </tr>
          <tr>
            <td class="attr-name">Handled By</td>
            <td class="attr-detail">'.$handled.'</td>
          </tr>
          <tr>
            <td class="attr-name">Assigned To</td>
            <td class="attr-detail">'.$assigned.'</td>
          </tr>
          <tr>
            <td class="attr-name">Documentation</td>
            <td class="attr-detail"><a href="'.$ref_url.'" target="_blank">Click here</a></td>
          </tr>
        </tbody>
      </table>
    </div>';
// $output = 'Project Name: '.$title.'<br>';
// $output .= 'Client Name: '.$client_name;
echo $output;
?>