<!--
    Här har vi vår searchbar 
-->
<form method="GET" action="setSearch.php">
    <?php echo "<input class='searchbar' type='text' name='set' placeholder='Sök efter legosatser...' value='" . $_GET['set'] . "'>"; ?>
</form>