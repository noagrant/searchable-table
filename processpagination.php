<?php
	include_once('connection.php');


	 // page 1 
	 if (!(isset($pagenum))) 
	 	$pagenum = 1; 

	// turns dates into MySQL format 10/22/2013 into 2013-10-22 00:00:00
	$fromdate = date('Y-m-d H:i:s', strtotime(str_replace('-','/',$_POST['from_date'])));
	$todate = date('Y-m-d H:i:s', strtotime(str_replace('-','/',$_POST['to_date'])));

	 //count the number of rows 
	$query = "SELECT count(*) FROM leads where (first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%') AND ( registered_datetime BETWEEN '$fromdate' AND '$todate' )";
	$countrecordsarray = fetchRecord($query);
	$numberofrecords = intval($countrecordsarray["count(*)"]); // alternatively: $numberofrecords = mysql_num_rows($data) where data is the actual retrieved query, not just count;
	
	//maximum records per page 
	$limitPerPage = 8;   // can set a different number
	$lastpagenum = ceil($numberofrecords / $limitPerPage);

	 //first and last pages 
	 if ($pagenum < 1) 
 		$pagenum = 1; 
	 elseif ($pagenum > $lastpagenum) 
 		$pagenum = $lastpagenum; 
	 
	 // run the query just for the tab
	 $limit = 'LIMIT ' .($pagenum - 1) * $limitPerPage .',' .$limitPerPage;
	 $query = "SELECT count(*) FROM leads where (first_name LIKE '{$_POST['name']}%' OR last_name LIKE '{$_POST['name']}%') AND ( registered_datetime BETWEEN '$fromdate' AND '$todate' ) $limit";
	 $tab = fetchAll($query);
	 
	 // if page one  - no link to the previous or first page
	 $pagination ="<div class='pagination'>";
	 if ($pagenum != 1)  
	 {
		 $pagination .= " <a href='{$_SERVER['PHP_SELF']}?pagenum=1'> <<-First</a>";
		 $previous = $pagenum-1;
		 $pagination .= " <a href='{$_SERVER['PHP_SELF']}?pagenum=$previous'> <-Previous</a> "; 
	 } 

	 //if last page -- no Next or Last links
	 if ($pagenum != $lastpagenum) 
	 {
		 $next = $pagenum+1;
		 $pagination .=  " <a href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Next -></a> ";
		 $pagination .= " <a href='{$_SERVER['PHP_SELF']}?pagenum=$lastpagenum'>Last ->></a> ";
	 } 
	 $pagination .="</div>"

	 // create table
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

	 // Display results
	 while($users = mysql_fetch_array( $tab )) 
	 { 
		 foreach ($users as $user) {
			$html .= "<tr>
				<td>{$user['leads_id']}</td>
				<td>{$user['first_name']}</td>
				<td>{$user['last_name']}</td>
				<td>{$user['registered_datetime']}</td>
				<td>{$user['email']}</td>
			</tr>";
			}
	 }

	 // close table
	 $html .= "</tbody>
		</table>
		";

	$data['pagination'] = $pagination;	
	$data['html'] = $html;
	echo json_encode($data);

 ?> 