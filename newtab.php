<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jade Delight 2</title>
<script src="js/main.js"></script>
<link rel="stylesheet" href="main.css">
</head>

<body>

<h1 class="banner">Welcome to John Cena's restaurant!</h1>

<h1>Details of your order here:</h1>
<?php

extract($_POST);

$server = "sql208.epizy.com";
$userid = "epiz_29733964";
$pw = "FsapAZ4Q9vGiA";
$db= "epiz_29733964_JadeDelight";

// Create connection
$conn = new mysqli($server, $userid, $pw );

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

//select the database
$conn->select_db($db);

//run a query
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

for ($i = 0; $i < 5; $i++) {
    $row = $result->fetch_array();
    $type = $row;
    if ($_POST["quan" . $i] > 0) {
        echo "You bought " . $_POST["quan" . $i] . " " . $type["name"] . " for a total of $" . $_POST["cost"][$i] . "<br>";
    }
}

$conn->close();

date_default_timezone_set("America/New_York");
$currtime = time();
$deliverance = "";
if ($_POST["p_or_d"] == "pickup") {
    $deliverance = "ready for pickup";
    $currtime = $currtime + (60 * 15);
}
else {
    $deliverance = "delivered";
    $currtime = $currtime + (60 * 30);
}

echo "<br>" . "Subtotal: $" . number_format($_POST["subtotal"] ,2,'.','') . "<br>";

echo "<br>" . "Tax: $" . number_format($_POST["tax"] ,2,'.','') . "<br>";

echo "<br>" . "Total: $" . number_format($_POST["total"] ,2,'.','') . "<br>";

echo "<br>" . "Your order will be " . $deliverance . " at " . date("g:i A", $currtime) . "<br>";

if ($_POST["p_or_d"] == "delivery") {
    echo "<br>" . "Our waiter will drop off the order at " . $_POST["street"] . ", " . $_POST["city"] . "<br>";
}


mail("tdaytonmohl@gmail.com", "Your order details from John Cena's Restaurant", 
"Thank you for your order!\n
Order total: $" . number_format($_POST["total"] ,2,'.',''). "\n
Your order will be " . $deliverance . " at " . date("g:i A", $currtime) . "\n" . 
($_POST["p_or_d"] == "delivery") ? "" : "Your order is scheduled to be delivered at " . $_POST["street"] . ", " . $_POST["city" . ".\n"])



?>
</body>