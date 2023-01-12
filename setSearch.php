<!DOCTYPE html>
<html lang="en">
<head>
    <title>En betydelserik sidtitel</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="grid.css">
    <link rel="stylesheet" href="headerBar.css">
</head>
<body>
    <div class="flexContainer">
        <div class="header">
            <?php include 'header.php'; ?>
        </div>
        <div class="bar">
            <?php include 'search.php'; ?>
            <?php
            $SetID =  $_GET['set'];
            $search = trim($_GET['set']);
            $term = "'%" . $search . "%'";
            // checks if search is empty and outputs an error message if it is.
            if (empty($search)) {
                $limit = 0;
                echo "<h2 id='error'> Vänligen ange en giltig sökterm. </h2>";
            } else {
                echo "<h2 id='res' >Resultat för: $SetID</h2>";
            }
           
            ?>
        </div>
        <div class="grid-container">
        <?php    
        if(!empty($search)){
            printTable();
        }
            ?>
        </div>
        <div class="footer">
        <p>LEGO, the LEGO logo, the Minifigure, and the Brick and Knob configurations are trademarks of ©2022 The LEGO Group of Companies. NDLCKO COMPANY NAME has no affiliation with ©2022 The LEGO Group or any of its subsidiaries.</p>
        </div>
    </div>
</body>
</html>

<?php

function printTable()
{
    //remove whitespace!
    $search = trim($_GET['set']);
    $term = "'%" . $search . "%'";
    //Some sort of limiter needs to be smarter
    $limit = 30;
    $con = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");
    $query = buildSqlQuery($term, $limit);
    $res = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($res)) {
        //Saves the data in variables
        $setID = $row['SetID'];
        $setName = $row['Setname'];
        //Remove extra characters from the name and whitespaces between words      
        $setNameNoChar = preg_replace("/[^a-zA-z0-9]/", "+", $row['Setname']);
        $image = fetchImage($con, $setID);
        //Build the grid with relevant information.
        print("<a href='setDetail.php?setID=$setID&setName=$setNameNoChar&setPicture=$image'>");
        print("<p>$setName</p>");
        print("<p>$setID</p>");

        if ($image) {
            print("<img src=\"$image\" alt=\"Image\"></a>");
        } else {
            print("<img src=\"noimage_small.png\" alt=\"NO image\"></a>");
        }
    }
    mysqli_close($con);
}
//Function that returns query to DB
function buildSqlQuery($term, $limit)
{   
    return "SELECT Setname, SetID FROM sets WHERE Setname LIKE $term OR SetID LIKE $term LIMIT $limit";
}
//Hämtar rätt bild om det är gif eller jpg stor eller liten.
function fetchImage($con, $setID)
{
    $imagesearch = mysqli_query($con, "SELECT images.has_gif, images.has_jpg, images.has_largegif, images.has_largejpg FROM images WHERE images.ItemID=$setID");
    $imageinfo = mysqli_fetch_array($imagesearch);
    $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";

    if ($$imageinfo['has_largegif'] || $imageinfo['has_largejpg']) {

        if ($imageinfo['has_largegif']) {
            return "$prefix/SL./$setID.gif";
        } else {
            return "$prefix/SL/$setID.jpg";
        }
    } else if ($imageinfo['has_gif'] ||  $imageinfo['has_jpg']) {

        if ($imageinfo['has_gif']) {
            return "$prefix/S/$setID.gif";
        } else {
            return "$prefix/S/$setID.jpg";
        }
    }

    // Om ingen format finns returnera NULL
    return null;
}

?>