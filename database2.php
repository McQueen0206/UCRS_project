<?PHP 
try {
    if($_SERVER['HTTP_HOST']=="localhost" )
	{
		$con = new PDO('mysql:host=localhost;dbname=ucrs', 'root', '');
	} else {
		
	}
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    die();
}
?>