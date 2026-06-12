<?php

include 'db.php';

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$name = $data['customer_name'];

$items = json_encode(
    $data['items']
);

$total = $data['total_price'];

$sql = "INSERT INTO orders
(
customer_name,
items,
total_price
)

VALUES
(
'$name',
'$items',
'$total'
)";

if ($conn->query($sql)) {

    echo json_encode([
        "message" => "✅ Order Placed Successfully"
    ]);

} else {

    echo json_encode([
        "message" => "❌ Database Error"
    ]);

}

?>