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
		$SetID =  $_GET['setID'];
		$SetName =  $_GET['setName'];
		
		echo "<h2>Set of $SetID $SetName</h2>"; ?>		
			<table class="tableDetail">
			<tbody>
			<tr><th>Setname</th><th>SetID</th><th>Quantity</th><th>File name</th><th>Picture</th><th>Color</th><th>Part name</th></tr>
			 <?php printTable(); ?>
			</tbody>
		</table>	
	</div>	
</div>
</body>

</html>


<?php

function printTable() {
	$SetID =  $_GET['setID'];
	$connection=mysqli_connect("mysql.itn.liu.se","lego","","lego");	//Lego is the db
		
	$sql = "SELECT inventory.quantity, inventory.ItemTypeID, inventory.ItemID, inventory.ColorID, images. has_gif, images.has_jpg, colors.Colorname, parts.Partname, inventory.SetID, sets.Setname ".
			"FROM inventory ".
			"JOIN images ON inventory.ItemTypeID = images.ItemTypeID AND inventory.ItemID = images.ItemID AND inventory.ColorID = images.ColorID ".
			"JOIN colors ON inventory.ColorID = colors.ColorID ".
			"JOIN parts ON inventory.ItemID = parts.PartID ".
			"JOIN sets ON inventory.SetID = sets.SetID ".
			"WHERE inventory.SetID = $SetID"; //filter
			

	$result = mysqli_query($connection, $sql);


	while ($row = mysqli_fetch_array($result)) {

			$setName 	= $row['SetID']; 
			$setID 		= $row['Setname'];
			
			$quantity   = $row['quantity']; //cap Q
			$itemTypeID = $row['ItemTypeID']; //little middle t
			$itemID     = $row['ItemID'];
			$colorID    = $row['ColorID'];
			$has_gif    = $row['has_gif'];
			$has_jpg    = $row['has_jpg'];
			$colorname  = $row['Colorname'];
			$partname   = $row['Partname'];
			$url 		= "";
			$prefix		= "http://weber.itn.liu.se/~stegu/img.bricklink.com/";
	
		if ($has_gif == 1) {
			$url = $itemTypeID . "/" . $colorID . "/" . $itemID . ".gif";
		} else if ($has_jpg == 1) {
			$url = $itemTypeID . "/" . $colorID . "/" . $itemID . ".jpg";
		}
		//rows ctrl D
		print ("<tr>\n");
		print("<th>".$setName."</th>\n");
		print("<th>".$setID."</th>\n");
		print("<th>".$quantity."</th>\n");
		print("<th>".$url."</th>\n");
		print("<th><image src=".$prefix.$url."></image></th>\n");
		print("<th>".$colorname."</th>\n");
		print("<th>".$partname."</th>\n");
		print ("</tr>");
			
	}  
		
		mysqli_close($connection);
}
?>