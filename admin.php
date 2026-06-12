<?php

include 'db.php';

$result = $conn->query(
    "SELECT * FROM orders ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial, sans-serif;
}

body{
background:#f4f4f4;
padding:20px;
}

h1{
text-align:center;
margin-bottom:20px;
color:#333;
}

table{
width:100%;
border-collapse:collapse;
background:white;
box-shadow:0 0 10px rgba(0,0,0,0.1);
}

th{
background:#ff5722;
color:white;
padding:12px;
text-align:center;
}

td{
padding:12px;
border-bottom:1px solid #ddd;
text-align:center;
vertical-align:top;
}

tr:hover{
background:#f9f9f9;
}

.items{
text-align:left;
line-height:1.6;
}

.total{
font-weight:bold;
color:green;
}

.delete-btn{
background:red;
color:white;
padding:6px 10px;
text-decoration:none;
border-radius:5px;
font-size:14px;
}

.delete-btn:hover{
background:darkred;
}

@media(max-width:768px){

table{
font-size:14px;
}

th,td{
padding:8px;
}

}

</style>

</head>

<body>

<h1>🍔 Food Ordering Admin Dashboard</h1>

<table>

<tr>
<th>Order ID</th>
<th>Customer</th>
<th>Items</th>
<th>Total</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

$items = json_decode($row['items'], true);

$itemList = "";

if(is_array($items)){

foreach($items as $item){

$name = $item['name'] ?? 'Item';

$qty = $item['qty'] ?? 1;

$itemList .= $name . " x " . $qty . "<br>";

}

}

?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= htmlspecialchars($row['customer_name']); ?></td>

<td class="items">
<?= $itemList; ?>
</td>

<td class="total">
₹<?= $row['total_price']; ?>
</td>

<td>
<?= $row['created_at']; ?>
</td>

<td>

<a class="delete-btn"
href="delete_order.php?id=<?= $row['id']; ?>"
onclick="return confirm('Delete this order?')">

Delete

</a>

</td>

</tr>

<?php

}

} else {

?>

<tr>

<td colspan="6">
No Orders Found
</td>

</tr>

<?php

}

?>

</table>

</body>
</html>