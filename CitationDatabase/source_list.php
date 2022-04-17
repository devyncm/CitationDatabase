<?php
   // Connect to the database

   if (!include('connect.php')) {
      die('error finding connect file');
   }

   $dbh = ConnectDB();
?>

<html>
<head>
<title>Source List</title>
</head>
<body>

<h1>Source List</h1>

<?php
   $sql = "CALL melend53.displaySources();";
   $stmt = $dbh->prepare($sql);
   $stmt->execute();

   echo "List of sources:<ol>";
   foreach($stmt->fetchAll() as $source)
   {
	echo "<li>" . $source['Title'] . " (published: "
	    . $source['Date Published'] . ", primary author: "
	    . $source['Primary Author'] . ", source type: "
	    . $source['Source Type'] . ")<br>";

	switch($source['Source Type'])
	{
		case "journal":
		    echo "Journal title: " . $source['Journal Title'] 
			. (empty($source['Volume']) ? "" : 
			    ", vol. " . $source['Volume'])
   			. (empty($source['Issue']) ? "" :
			    ", issue " . $source['Issue']) . "</li>\n";
			break;
		case "book":
		    echo "ISBN: " . $source['ISBN'] 
			. ", publisher: " . $source['Publisher']
			. "</li>\n";
		    break;
		case "web site":
		    echo "URL: " . $source['URL'] 
			. ", accessed on " . $source['Date Accessed']
			. "</li>\n";
		    break;
		default:
		    echo "error</li>\n";
	}
   }
   echo "</ol>\n";

   echo $stmt->rowCount() . " sources retrieved.";
?>
</body>
</html>
