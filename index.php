
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jade Delight 2</title>
<script src="js/main.js"></script>
<link rel="stylesheet" href="main.css">
</head>

<body>
<script language="javascript">
	function MenuItem(name, cost)
{
	this.name = name;
	this.cost=cost;
}

menuItems = new Array(
	new MenuItem("Chicken Chop Suey", 4.5),
	new MenuItem("Sweet and Sour Pork", 6.25),
	new MenuItem("Shrimp Lo Mein", 5.25),
	new MenuItem("Moo Shi Chicken", 6.5),
	new MenuItem("Fried Rice", 2.35)
);
</script>
<?php

function makeSelect($name, $minRange, $maxRange)
{
	$t = "<select name='" . $name . "' size='1'>";
	for ($j=$minRange; $j<=$maxRange; $j++)
	   $t .= "<option>" . $j . "</option>";
	   $t .= "</select>"; 
	return $t;
}
?>

<h1 class="banner">Welcome to John Cena's restaurant!</h1>

<h1>Jade Delight 2</h1>

<form
	method = "post"
	action = "newtab.php"
	onsubmit="return validate()">

<p>First Name: <input type="text" name='fname' /></p>

<p>Last Name*:  <input type="text" name='lname' /></p>

<p id ="street" style="display:none;">Street: <input type="text" name='street' /></p>

<p id = "city" style="display:none;">City: <input type="text"  name='city' /></p>

<p>Phone*: <input type="text"  name='phone' /></p>

<p name="deliveryradio" onchange="displayForm();"> 
	<input type="radio"  name="p_or_d" id= "pickup" value = "pickup" checked="checked"/>Pickup  
	<input type="radio"  name='p_or_d' id= "delivery" value = 'delivery'/>
	Delivery
</p>

<table border="0" cellpadding="3" onchange="updateItems();">
  <tr >
    <th>Select Item</th>
    <th>Item Name</th>
    <th>Cost Each</th>
    <th>Total Cost</th>
  </tr>

<?php

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

$count = 0;
while($row = $result->fetch_array()) 
{
	$type = $row;
	echo "<tr><td>";
	echo makeSelect("quan" . $count, 0, 10);
	echo "</td><td>" . $type["name"] . "</td>";
	echo "<td> $ " . number_format($type["price"],2,'.','') . "</td>";
	echo "<td>$<input type='text' name='cost[]'/></td></tr>";
	$count++;
}
  //close the connection	
  $conn->close();
  ?>
</table>
<p>Subtotal: 
   $<input type="text"  name='subtotal' id="subtotal" />
</p>
<p>Mass tax 6.25%:
  $ <input type="text"  name='tax' id="tax" />
</p>
<p>Total: $ <input type="text"  name='total' id="total" />
</p>

<input type = "submit" value = "Submit Order" />

</form>
</body>
</html>