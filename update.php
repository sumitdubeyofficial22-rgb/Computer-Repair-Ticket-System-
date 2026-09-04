<?php

require_once "config.php";


$id = filter_input(
    INPUT_GET,
    "id",
    FILTER_VALIDATE_INT
);


if (!$id) {
    exit("Invalid ticket ID.");
}


$message = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $new_status = trim(
        $_POST["status"] ?? ""
    );


    $allowed_statuses = [
        "Pending",
        "In Progress",
        "Completed"
    ];


    if (
        !in_array(
            $new_status,
            $allowed_statuses,
            true
        )
    ) {

        $message = "Invalid status.";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "UPDATE repair_tickets
             SET status = ?
             WHERE id = ?"
        );


        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $new_status,
            $id
        );


        if (mysqli_stmt_execute($stmt)) {

            $message = "Status updated successfully.";

        } else {

            $message = "Unable to update the ticket.";

        }


        mysqli_stmt_close($stmt);

    }

}


$stmt = mysqli_prepare(
    $conn,
    "SELECT
        id,
        customer_name,
        device_type,
        device_model,
        problem,
        priority,
        status
     FROM repair_tickets
     WHERE id = ?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


$ticket = mysqli_fetch_assoc($result);


if (!$ticket) {
    exit("Ticket not found.");
}

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Update Ticket</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>


<body>


<nav>

    <a
        class="brand"
        href="index.php"
    >
        🔧 RepairDesk
    </a>

    <div>

        <a href="view.php">
            Back to Tickets
        </a>

    </div>

</nav>


<main class="page narrow">

    <div class="card">

        <h1>
            Update Ticket #<?php
            echo (int)$ticket["id"];
            ?>
        </h1>


        <?php if ($message): ?>

            <div class="notice">

                <?php
                echo htmlspecialchars(
                    $message,
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>

            </div>

        <?php endif; ?>


        <p>

            <strong>
                Customer:
            </strong>

            <?php
            echo htmlspecialchars(
                $ticket["customer_name"],
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </p>


        <p>

            <strong>
                Device:
            </strong>

            <?php
            echo htmlspecialchars(
                $ticket["device_type"],
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

            -

            <?php
            echo htmlspecialchars(
                $ticket["device_model"],
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </p>


        <p>

            <strong>
                Problem:
            </strong>

            <?php
            echo htmlspecialchars(
                $ticket["problem"],
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </p>


        <p>

            <strong>
                Priority:
            </strong>

            <?php
            echo htmlspecialchars(
                $ticket["priority"],
                ENT_QUOTES,
                'UTF-8'
            );
            ?>

        </p>


        <form method="post">

            <label for="status">
                Change Status
            </label>


            <select
                id="status"
                name="status"
                required
            >

                <?php

                $statuses = [
                    "Pending",
                    "In Progress",
                    "Completed"
                ];

                foreach ($statuses as $s):

                ?>

                    <option
                        value="<?php
                            echo htmlspecialchars(
                                $s,
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>"
                        <?php
                        echo $ticket["status"] === $s
                            ? "selected"
                            : "";
                        ?>
                    >

                        <?php
                        echo htmlspecialchars(
                            $s,
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </option>

                <?php endforeach; ?>

            </select>


            <button
                class="btn full"
                type="submit"
            >
                Update Status
            </button>

        </form>

    </div>

</main>


</body>

</html>


<?php

mysqli_stmt_close($stmt);

mysqli_close($conn);

?>