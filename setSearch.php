<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <title>A Meaningful Page Title</title>

</head>

<body>
	<div>
        <div>
		<?php include 'search.php'; ?>	
		<?php  
		$SetID =  $_GET['set'];
		
		echo "<h2>Set of $SetID</h2>"; ?>		
			<table>
			<tbody>
			<tr><th>SetID</th><th>SetName</th>
			 <?php printTable(); ?>
			</tbody>
		</table>	
        </div>
    </div>
</body>
</html>





<?php


function printTable() {

$search = $_GET['set'];
$term =  "'%$search%'";

$con=mysqli_connect("mysql.itn.liu.se","lego","","lego");	//Lego is the db

$query = "SELECT Setname, SetID FROM sets
WHERE Setname LIKE $term OR SetID LIKE $term
";

$res = mysqli_query($con, $query);

while($row = mysqli_fetch_array($res)){
    
    $setID = $row['SetID'];
    $setName = $row['Setname'];
 
    $url 		= "";
	$prefix		= "http://weber.itn.liu.se/~stegu/img.bricklink.com/";

	
    print ("<tr>\n");
    print("<th><a href='setDetail.php?setID=$setID&setName=$setName'>$setID</a></th>");
	print("<th>$setName</th>");
	

}




mysqli_close($connection);
    
}



?>