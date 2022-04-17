<?php 
   // Connect to the database
   
   if (!include('connect.php')) {
      die('error finding connect file');
   }
   
   $dbh = ConnectDB();
?>

<html>
<head>
<title>Paper Info</title>
</head>

<body>

<?php

   if (!isset($_GET["paper_id"]))
   {
      echo "Paper ID not set.";
   }
   else
   {
	echo "<h1>Paper Info</h1>";

	$paper_id = $_GET["paper_id"];
	$sql = "SELECT title ";
	$sql .= "FROM melend53.paper ";
	$sql .= "WHERE paper_id = ?;";
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(1, $paper_id, PDO::PARAM_INT);
	$stmt->execute();

	foreach($stmt->fetchAll() as $row)
	{
		echo "Title: <b>" . $row['title'] . "</b><br>";
	}
	
	$sql = "SELECT melend53.age(?) AS 'age';";
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(1, $paper_id, PDO::PARAM_INT);
	$stmt->execute();

	foreach($stmt->fetchAll() as $row)
	{
		echo "Age: " . $row['age'] . " days old<br>";
	}

	$sql = "SELECT s.title, s.date_published, 
			IFNULL(CONCAT(w.first_name, ' ', 
			w.last_name), o.name) AS 'Primary Author' ";
	$sql .= "FROM melend53.paper p ";
	$sql .= "JOIN melend53.citation c USING (paper_id) ";
	$sql .= "JOIN melend53.source s USING (source_id) ";
	$sql .= "JOIN melend53.author a ON 
			(s.primary_author_id = a.author_id) ";
	$sql .= "LEFT JOIN melend53.organization o USING (author_id) ";
	$sql .= "LEFT JOIN melend53.writer w USING (author_id) ";
	$sql .= "WHERE p.paper_id = ? ";
	$sql .= "ORDER BY s.title;";
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(1, $paper_id, PDO::PARAM_INT);
	$stmt->execute();

	echo "<br>Sources:<ol>";
	foreach($stmt->fetchAll() as $source)
	{
		echo "<li>" . $source['title'] . " (published: " 
			. $source['date_published'] . ", primary author: "
			. $source['Primary Author'] . ")</li>\n";
	}
	echo "</ol>\n";

	echo $stmt->rowCount() . " sources retrieved.";
   }
?>

</body>
</html>
