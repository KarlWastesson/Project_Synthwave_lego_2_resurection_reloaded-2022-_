<!DOCTYPE html>
<html lang="en">
<head>
    <title>A Meaningful Page Title</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="helpPage.css">
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
            echo "<h2 style='color:white'>Result of $SetID</h2>";
            ?>
        </div>
        <div class="grid-container">
            <?php printTable(); ?>
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
    if (empty($search)) {
        $limit = 5;
    } else {
        $limit = 30;
    }
    $con = mysqli_connect("mysql.itn.liu.se", "lego", "", "lego");

    $query = buildSqlQuery($term, $limit);
    $res = mysqli_query($con, $query);

    while ($row = mysqli_fetch_array($res)) {
        $setID = $row['SetID'];
        $setName = $row['Setname'];
        $setNameNoChar = preg_replace("/[^a-zA-z0-9]/", "+", $row['Setname']);
        $image = fetchImage($con, $setID);
        //första print skapar hela "divven" sen pushas allt därefter.
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

function buildSqlQuery($term, $limit)
{
    return "SELECT Setname, SetID FROM sets WHERE Setname LIKE $term OR SetID LIKE $term LIMIT $limit";
}

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