<!DOCTYPE html>
<html lang="en">

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
		
		echo "<h2>Result of $SetID</h2>"; ?>		
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
    //remove whitespace!
    $search = trim($_GET['set']);
    $term = "'%".$search."%'";
    //Some sort of limiter needs to be smarter
    if(empty($search)) {
        $limit = 5;
     }
     else
     {
        $limit = 20;
     }
   
  

    $con = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

    $query = buildSqlQuery($term, $limit);
    $res = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($res)) {
        $setID = $row['SetID'];
        $setName = $row['Setname'];
        $image = fetchImage($con, $setID);

        print ("<tr>\n");
        print("<th><a href='setDetail.php?setID=$setID&setName=$setName&setPicture=$image'>$setID</a></th>");
        print("<th>$setName</th>");

        if ($image) {
            print("<th><img src=\"$image\" alt=\"NO image\"/></th>");
        } else {
            print('<th><img src="noimage_small.png" alt="NO image"/></th>');
        }
    }
	mysqli_close($con);
}

function buildSqlQuery($term, $limit) {
    return "SELECT Setname, SetID FROM sets WHERE Setname LIKE $term OR SetID LIKE $term LIMIT $limit";
}

function fetchImage($con, $setID) {
    $imagesearch = mysqli_query($con, "SELECT images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg FROM images WHERE images.ItemID=$setID");
    $imageinfo = mysqli_fetch_array($imagesearch);
    $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";

    if ($ $imageinfo['has_largegif'] || $imageinfo['has_largejpg']){
    
        if($imageinfo['has_largegif']){
            return "$prefix/SL./$setID.gif"; 
             
        }
        else{
            return "$prefix/SL/$setID.jpg";
        }
    }
    else if( $imageinfo['has_gif'] ||  $imageinfo['has_jpg']){
        
        if($imageinfo['has_gif']){
           return "$prefix/S/$setID.gif";
        }
        else{
            return "$prefix/S/$setID.jpg";
        }
    }

    // Om ingen format finns returnera NULL
    return null;
}

?>