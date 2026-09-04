<?php

require_once "config.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}


$customer_name = trim($_POST["customer_name"] ?? "");
$device_type = trim($_POST["device_type"] ?? "");
$device_model = trim($_POST["device_model"] ?? "");
$problem = trim($_POST["problem"] ?? "");
$priority = trim($_POST["priority"] ?? "");


$allowed_devices = [
    "Laptop",
    "Desktop",
    "All-in-One",
    "Other"
];

$allowed_priorities = [
    "Low",
    "Medium",
    "High"
];


if (
    strlen($customer_name) < 2 ||
    strlen($customer_name) > 100 ||
    !preg_match("/^[A-Za-z .'-]+$/", $customer_name) ||
    !in_array($device_type, $allowed_devices, true) ||
    strlen($device_model) < 1 ||
    strlen($device_model) > 100 ||
    strlen($problem) < 1 ||
    strlen($problem) > 500 ||
    !in_array($priority, $allowed_priorities, true)
) {
    exit("Invalid input. Please enter valid information.");
}


$sql = "INSERT INTO repair_tickets
        (customer_name, device_type, device_model, problem, priority, status)
        VALUES (?, ?, ?, ?, ?, 'Pending')";


$stmt = mysqli_prepare($conn, $sql);


if (!$stmt) {
    exit("Unable to save the ticket.");
}


mysqli_stmt_bind_param(
    $stmt,
    "sssss",
    $customer_name,
    $device_type,
    $device_model,
    $problem,
    $priority
);


if (mysqli_stmt_execute($stmt)) {

    $ticket_id = mysqli_insert_id($conn);

} else {

    exit("Unable to save the ticket.");

}


mysqli_stmt_close($stmt);
mysqli_close($conn);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Ticket Submitted</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body>

<div class="success-box">

    <div class="success-icon">
        ✓
    </div>

    <h1>
        Repair Ticket Submitted
    </h1>

    <p>
        Your ticket has been saved successfully.
    </p>

    <h2>
        Ticket ID: #<?php echo (int)$ticket_id; ?>
    </h2>

    <a
        class="btn"
        href="view.php"
    >
        View Tickets
    </a>

    <a
        class="btn secondary"
        href="index.php"
    >
        Create Another
    </a>

</div>

</body>

</html>