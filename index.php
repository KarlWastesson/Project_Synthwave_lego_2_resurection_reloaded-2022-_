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
 
			
</div>   
   
</body>
</html>
