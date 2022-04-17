<?php
   // Connect to the database

   if (!include('connect.php')) {
      die('error finding connect file');
   }

   $dbh = ConnectDB();
?>

<html>
<head>
<title>Citation Analyzer</title>
</head>
<body>

<h1>Citation Analyzer</h1>
<?php
   $sql = "CALL melend53.getStatistics();";
   $stmt = $dbh->prepare($sql);
   $stmt->execute();

   foreach($stmt->fetchAll() as $row)
   {
	   echo "Journal count: " . $row['Journal Count'] . "<br>";
	   echo "Book count: " . $row['Book Count'] . "<br>";
	   echo "Website count: " . $row['Website Count'] . "<br>";
   }

?>
</body>
</html>
