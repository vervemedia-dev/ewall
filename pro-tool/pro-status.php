<link href="css/vervemedia.css" rel="stylesheet" type="text/css" />
<?php
include 'config.php';
if(isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
	$pro_id = $_REQUEST['id'];
}
$result = mysql_query("SELECT * FROM project_status WHERE pr_no = '$pro_id' ORDER BY updated DESC");
$i = 1;
$output = '<table cellspacing="0" cellpadding="0" border="0" id="item_attributes">
        <tbody>
				<thead>
					<th>No</th>
					<th>Status</th>
					<th>Comments</th>
					<th>Updated on</th>
				</thead>
				';
while($row = mysql_fetch_array($result)) { 
	$status = $row['status'];
	$comments = $row['comments'];
	$updated = $row['updated'];
	$output .= '<tr>
            <td class="attr-name">'.$i.'</td>
            <td class="attr-name">'.$status.'</td>
            <td class="attr-name">'.$comments.'</td>
            <td class="attr-name">'.date("d/M/Y", $updated).'</td>
          </tr>';
	$i++;
}

$output .= '</tbody>
      </table>';

echo $output;
?>