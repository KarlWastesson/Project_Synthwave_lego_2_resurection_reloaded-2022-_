<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="styles.css">
    <title>A Meaningful Page Title</title>

</head>
<body>
<div class="flexContainer">
    <div class="header">
    <?php include 'header.html'; ?>	
    </div>

    <div class="bar">
    <form method="GET" action="setSearch.php"> 
		
    <?php include 'search.php'; ?>	
    </form>
    </div>
 
		<div class="result">
			<?php  
		$SetID =  $_GET['set'];
		
		echo "<h2>Set of $SetID</h2>"; ?>		
			<table class="tableSet ">
			<tbody>
			<tr><th>SetID</th><th>SetName</th><th>Image</th>
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
	$prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
 
    $url 		= "";
	
	$imagesearch = mysqli_query($con, "SELECT * FROM images WHERE (ItemTypeID='S' AND ItemID='".$setID."')");
	$imageinfo = mysqli_fetch_array($imagesearch);  

	$hasimg=FALSE;
				  
			   
			   if($imageinfo['has_gif'] !=0)
			   { // Använd GIF om JPG inte tillgägligt 
				 $hasimg=TRUE;
				 $filename = "S/$setID.gif";
			   }
			   else if($imageinfo['has_jpg'] !=0)
			   { // Använd JPG om den finns
				 $filename = "S/$setID.jpg";
				 $hasimg=TRUE;
			   }
			   else
			   { // Om ingen format finns skriv ut text 
				 $hasimg=FALSE;
				 $filename = "noimage_small.png";
			   }
			  
			   
			   


    print ("<tr>\n");
    print("<th><a href='setDetail.php?setID=$setID&setName=$setName'>$setID</a></th>");
	print("<th>$setName</th>");
	if($hasimg==TRUE)
	  print("<th><img src=\"$prefix$filename\" alt=\"NO image\"/></th>");
	else
	  print('<th><img src="'.$filename.'" alt="'.$ItemID.'"/></th>');




}




mysqli_close($con);
    
}



?>