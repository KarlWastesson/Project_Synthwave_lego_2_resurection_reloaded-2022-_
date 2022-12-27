<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="helpPage.css">
	<link rel="stylesheet" href="grid.css">
	<title>A Meaningful Page Title</title>

</head>

<body>
	<div class="flexContainer">
		<div class="header">
			<?php include 'header.php'; ?>
		</div>
		<div class="bar">
			<?php include 'search.php'; ?>
		</div>
		<div class="photoCardDetail">
			<?php
			$SetID =  $_GET['setID'];
			$SetName =  $_GET['setName'];
			$SetPicture =  $_GET['setPicture'];

			if ($SetPicture) {
				echo ("<img src=\"$SetPicture\" alt=\"Image\">");
			} else {
				echo ("<img src='noimage_small.png' alt='NO image'>");
			}

			echo ("<h1>Set of $SetID $SetName</h1>");
			?>
		</div>
		<div class="result">
			<table class="tableDetail" id="partTable">
				<tbody>
					<tr>

						<th>Picture</th>
						<th>Color</th>
						<th>Part name</th>
					</tr>
					<?php printTable($searchArg);


					?>
				</tbody>
			</table>


		</div>
	</div>
</body>

</html>


<?php

function printTable($arg)
{

	$SetID =  $_GET['setID'];
	$connection = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");	//Lego is the db

	$sql = "SELECT inventory.Quantity, inventory.ItemTypeID, inventory.ItemID, 
	inventory.ColorID, colors.Colorname, parts.Partname, images.has_gif, 
	images.has_jpg, images.has_largegif, images.has_largejpg

	FROM inventory
	INNER JOIN parts
		ON inventory.ItemID = parts.PartID
	INNER JOIN colors
		ON inventory.ColorID = colors.ColorID
	INNER JOIN images
		ON inventory.ItemID = images.ItemID
		AND inventory.ColorID = images.ColorID
	WHERE inventory.SetID = '$SetID'
		AND inventory.ItemTypeID = 'P'
	
	ORDER BY inventory.ItemID";



	$result = mysqli_query($connection, $sql);



	while ($row = mysqli_fetch_array($result)) {

		$quantity   = $row['Quantity'];
		$itemTypeID = $row['ItemTypeID']; //little middle t
		$itemID     = $row['ItemID'];
		$colorID    = $row['ColorID'];
		$has_gif    = $row['has_gif'];
		$has_jpg    = $row['has_jpg'];
		$colorname  = $row['Colorname'];
		$partname   = $row['Partname'];
		$url 		= "+";
		$prefix		= "http://weber.itn.liu.se/~stegu/img.bricklink.com/";

		if ($has_gif == 1) {
			$url = $itemTypeID . "/" . $colorID . "/" . $itemID . ".gif";
		} else if ($has_jpg == 1) {
			$url = $itemTypeID . "/" . $colorID . "/" . $itemID . ".jpg";
		}
		//rows ctrl D
		print("<tr >\n");
		print("<th>" . $quantity . "</th>\n");
		print("<th><img src=\"$prefix$url\" alt='Part image'></th>\n");
		print("<th>" . $colorname . "</th>\n");
		print("<th>" . $partname . "</th>\n");
		print("</tr>");
	}
	mysqli_close($connection);
}

?>