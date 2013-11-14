<?php
	include_once('connection.php');


	$html = "";
	 // page 1 
	 if (!(isset($pagenum)))
	 	{$pagenum = 1; }

		// turns dates into MySQL format 10/22/2013 into 2013-10-22 00:00:00
		$fromdate = date('Y-m-d H:i:s', strtotime(str_replace('-','/',$_POST['from_date'])));
		$todate = date('Y-m-d H:i:s', strtotime(str_replace('-','/',$_POST['to_date'])));
		if($todate = '1969-12-31 16:00:00')
			{$todate = '2513-12-31 16:00:00';}

	 //count the number of rows 
	// $query = "SELECT count(*) FROM leads where (first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%') AND (registered_datetime BETWEEN '$fromdate' AND '$todate');";
	// $countrecordsarray = fetchRecord($query);
	// $numberofrecords = intval($countrecordsarray["count(*)"]); // alternatively: $numberofrecords = mysql_num_rows($data) where data is the actual retrieved query, not just count;
	
	//maximum records per page 
	// $limitPerPage = 8;   // can set a different number
	// $lastpagenum = ceil($numberofrecords / $limitPerPage);

	 //first and last pages 
	 // if ($pagenum < 1) 
 	// 	{$pagenum = 1;} 
	 // elseif ($pagenum > $lastpagenum) 
 	// 	{$pagenum = $lastpagenum; }
	 
	 // run the query just for the tab
	 // $limit = 'LIMIT ' .($pagenum - 1) * $limitPerPage .',' .$limitPerPage;
	 // $query = "SELECT * FROM leads where (first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%') AND ( registered_datetime BETWEEN '$fromdate' AND '$todate' ) $limit;";
	 $query = "SELECT * FROM leads where (first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%') AND ( registered_datetime BETWEEN '$fromdate' AND '$todate' );";
	 $tab = fetchAll($query);
	 // var_dump($tab);
	 
	 // if page one  - no link to the previous or first page
	 // $pagination ="<div class='pagination'>";
	 // if ($pagenum != 1)  
	 // {
		//  $pagination .= "<a href='{$_SERVER['PHP_SELF']}?pagenum=1'> <<-First</a>";
		//  $previous = $pagenum-1;
		//  $pagination .= "<a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'><-Previous</a> "; 
	 // } 
 
	 //if last page -- no Next or Last links
	 // if ($pagenum != $lastpagenum) 
	 // {
		//  $next = $pagenum+1;
		//  $pagination .=  "<a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Next -></a> ";
		//  $pagination .= "<a href='{$_SERVER['PHP_SELF']}?pagenum=$lastpagenum'>Last ->></a> ";
	 // } 
	 // $pagination .="</div>";

	// create table
	$html .= "<table><thead><tr>";
	$html .= "<th>leads id</th>";
	$html .= "<th>first name</th>";
	$html .= "<th>last name</th>";
	$html .= "<th>registered date</th>";
	$html .= "<th>email</th>";
	$html .= "</tr></thead><tbody>";

	 foreach ($tab as $user) 
	 {
		$html .= "<tr>
			<td>{$user['leads_id']}</td>
			<td>{$user['first_name']}</td>
			<td>{$user['last_name']}</td>
			<td>{$user['registered_datetime']}</td>
			<td>{$user['email']}</td>
		</tr>";
	}

	 // close table
	 $html .= "</tbody></table>";

	//$data['pagination'] = $pagination;	
	$data['html'] = $html;
	echo json_encode($data);
	
 ?> 