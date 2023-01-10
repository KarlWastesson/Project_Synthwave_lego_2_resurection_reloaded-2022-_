<!DOCTYPE html>
<html lang="en">

<head>
  <title>A Meaningful Page Title</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="helpPage.css">
  <link rel="stylesheet" href="grid.css">
  <link rel="stylesheet" href="helpPage.css">
</head>

<body>
  <div class="flexContainer">
    <div class="header">
      <?php include 'header.php'; ?>
    </div>
    <div class="bar">
      <?php include 'search.php'; ?>
    </div>

    <div class="result">
      <div class="row">
        <div class="content">
          <p class="title"> <strong> Hjälp </strong></p>
          Använd sökrutan och skriv ett namn eller id för en sats. Fulla namnet/id behövs ej, det går att söka via nyckelord.
        </div>
        <div class="content">
          <p class="title"> <strong> Om oss </strong></p>
          Denna webbsida är till för att visa upp ett projekt i kursen "Elektronisk publicering" på Linköpings universitet i Norrköping, Sverige.
          Syftet med projektet är att skapa en webbsida som innehåller en databas för lego satser.
          <br> <br> Tack.
          <br> Dasmit, Karl, Klas, Ramez.
        </div>
      </div>
    </div>
  </div>
</body>