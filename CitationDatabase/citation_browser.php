<?php
   // Connect to the database

   if (!include('connect.php')) {
      die('error finding connect file');
   }

   $dbh = ConnectDB();
?>

<html>
<head>
<title>Citation Browser</title>
</head>
<body>

<h1>Citation Browser</h1>

<form action="paper_info.php" method="get">

<h2>Choose a paper.</h2>
<select id='paper_id' name='paper_id'>

<?php
   // Prepare the SQL for paper id and title
   $sql = "SELECT DISTINCT paper_id, title ";
   $sql .= "FROM melend53.paper ";
   $sql .= "ORDER BY title;";
   $stmt = $dbh->prepare($sql);
   $stmt->execute();

   // Loop through the rows to find all the values for paper title
   foreach($stmt->fetchAll() as $row) {
	   echo '<option value="' . $row['paper_id'] . '">'. $row['title'] . '</option>\n';
   }
?>

</select>

<p><input type='submit' value='Submit'></p>
</form>
</body>
</html>
