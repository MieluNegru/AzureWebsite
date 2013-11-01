<!DOCTYPE html>
<html>
	<head>
		<title>Search</title>
	</head>
	<body>
		<form method="GET" action="search.php">
			Search users: <input type="text" name="search_query"/> 
			<input type="submit" value="Search"/>
		</form>
		
<?php 
	$host = "eu-cdbr-azure-west-b.cloudapp.net";
    $user = "b96b54a376a231";
    $pwd = "4b5adca2";
    $db = "gabrielucldb";
    try {
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e){
        die(var_dump($e));
    }
    // Insert registration info
    if(!empty($_GET)) {
		try {
			$search = trim($_GET['search_query']).'%';
			$sql_select = "SELECT * FROM registration_tbl WHERE name LIKE ?";
			$stmt = $conn->prepare($sql_select);
			$stmt->bindParam(1, $search, PDO::PARAM_STR, 20);
			$stmt->execute();
		}
		catch (Exception $e) {
			die(var_dump($e));
		}
			$registrants = $stmt->fetchAll(); 
			$regNo = count($registrants);
			if ($regNo > 0) {
				echo "<h2>".$regNo." users found</h2>";
				echo "<table>";
				echo "<tr><th>Name</th>";
				echo "<th>Email</th>";
				echo "<th>Date</th>";
				echo "<th>Company Name<th></tr>";
				foreach($registrants as $registrant) {
					echo "<tr><td>".$registrant['name']."</td>";
					echo "<td>".$registrant['email']."</td>";
					echo "<td>".$registrant['date']."</td>";
					echo "<td>".$registrant['company_name']."</td></tr>";            
				}
				echo "</table>";
			}
			else {
				echo "<h3>No users with specified name found.</h3>";
			}
	}
?>
	</body>
</html>