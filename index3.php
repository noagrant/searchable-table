<?php include_once('connection.php');  ?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Ajax Searchable Table</title>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.8.16/jquery-ui.js"></script>
	<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="path/to/Zebra_Pagination/public/css/zebra_pagination.css" type="text/css">  <!-- pagination -->
	<style type="text/css">
		h1 {color: #2D76B5}
		h2, th {color: #6399C5}
		th {text-align: left; text-decoration: underline;}
		label {font-weight: bold;}
		.container{width:960px; margin:0 auto; font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", "Helvetica" ; overflow: auto;}
		.smaller {font-size:0.9em; margin-top: -10px; padding-left: 80px}
		.pagination {float: left;}
		#results {overflow: auto;}
	</style>
	<!-- jQuery / Ajax -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('.date').datepicker();  // jQuery for date picking
			$('#name').keyup(function(){
				$("#searchform").submit();
			});
			$("#searchform").submit(function(){
				$.post(
					$(this).attr('action'),
					$(this).serialize(),
					function(data){
						$('#results').html(data.pagination);
						$('#results').append(data.html);					
					},
					"json"
				);
				return false;
			});
		});
	</script>
</head>
<body>
	<div class="container">
		<h1>Searchable Table</h1> 
		<form id="searchform" action="process.php" method="post">
			<label for "name">Name: </label>
			<input type="text" name="name" id="name">
			<label for "from_date">From: </label>
			<input type="text" name="from_date" id="from_date" class="date">
			<label for "to_date">To: </label>
			<input type="text" name="to_date" id="to_date" class="date">
			<input type="submit" value="SEARCH">
		</form> 
		<div id ="results">
			<div class="results"></div>
		</div>
	</div><!-- directions -->
	</div><!-- wrapper -->
</body>
</html>




<!-- Please follow the leads ajax example as outlined in the video but 
1. modify it so that the table updates when the from date, to date is changed.  
Once this is done, 
2.  (use mysql limit function to get data for different page - http://php.about.com/od/mysqlcommands/g/Limit_sql.htm)
SELECT * FROM `your_table` LIMIT starting_point, number_of_records; 

$fromdate = date('Y-m-d H:i:s', strtotime(str_replace('-','/',$_POST['from_date'])));


where $_POST['from_date'] is 11/01/2013

turns 11/01/2013 into 2013-11-01 00:00:00

-->