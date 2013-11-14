<?php
	include_once('connection.php');

	$data = array();
	$limitPerPage = 5;
	$query = "SELECT count(*) FROM leads where first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%'";
	$totalarray = fetchRecord($query);
	$total = intval($totalarray["count(*)"]);
	$pages = ceil($total / $limitPerPage); // $lastpage
	

	// where $_POST['from_date'] is 11/01/2013
	// turns 11/01/2013 into 2013-11-01 00:00:00
	$fromdate = date('Y-m-d H:i:s', strtotime(str_replace('-','/',$_POST['from_date'])));
	$todate = date('Y-m-d H:i:s', strtotime(str_replace('-','/',$_POST['to_date'])));
	
	$html = "<div class='pagination'>";
	for ($page = 1; $page <= $pages; $page++) 
	{	

		$html .= "<form name='tabz' action='process.php?tab=".$page."' method='get'><a class='tabz id=".$page."' href='#".$page." '>| ".$page." </a></form>";
	}
	$html .= "</div>";				


	$html .="
		<table>
			<thead>
				<tr>
					<th>leads id</th>
					<th>first name</th>
					<th>last name</th>
					<th>registered date</th>
					<th>email</th>
				</tr>
			</thead>
			<tbody>";

	$html .= "<div id='".."' </div>"; 

	foreach ($users as $user) {
				$html .= "<tr>
					<td>{$user['leads_id']}</td>
					<td>{$user['first_name']}</td>
					<td>{$user['last_name']}</td>
					<td>{$user['registered_datetime']}</td>
					<td>{$user['email']}</td>
				</tr>";
			}
				
	$html .= "</tbody>
		</table>
		";

		$data['html'] = $html;
		echo json_encode($data);

function $records($tab)
{	
	$start = $tab*$limitPerPage;
	$query = "SELECT * FROM leads 
		WHERE (first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%') 
		AND ( registered_datetime BETWEEN '$fromdate' AND '$todate' )
		LIMIT $start, $limitPerPage";	
	$rows = fetchAll($query);
	return $rows;
}




?>

