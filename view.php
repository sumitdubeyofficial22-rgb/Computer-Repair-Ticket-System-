<?php

require_once "config.php";


$search = trim($_GET["search"] ?? "");
$status = trim($_GET["status"] ?? "");


if ($search !== "") {

    $like = "%" . $search . "%";

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            id,
            customer_name,
            device_type,
            device_model,
            problem,
            priority,
            status,
            created_at
         FROM repair_tickets
         WHERE CAST(id AS CHAR) LIKE ?
         OR customer_name LIKE ?
         OR device_model LIKE ?
         OR device_type LIKE ?
         ORDER BY id DESC"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssss",
        $like,
        $like,
        $like,
        $like
    );

} elseif (
    in_array(
        $status,
        ["Pending", "In Progress", "Completed"],
        true
    )
) {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            id,
            customer_name,
            device_type,
            device_model,
            problem,
            priority,
            status,
            created_at
         FROM repair_tickets
         WHERE status = ?
         ORDER BY id DESC"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $status
    );

} else {

    $stmt = mysqli_prepare(
        $conn,
        "SELECT
            id,
            customer_name,
            device_type,
            device_model,
            problem,
            priority,
            status,
            created_at
         FROM repair_tickets
         ORDER BY id DESC"
    );
}


mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Repair Tickets</title>

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

        <a href="index.php">
            Home
        </a>

        <a href="view.php">
            View Tickets
        </a>

    </div>

</nav>


<main class="page">

    <h1>
        Repair Tickets
    </h1>


    <form
        class="search-box"
        method="get"
        action="view.php"
    >

        <input
            type="search"
            name="search"
            value="<?php
                echo htmlspecialchars(
                    $search,
                    ENT_QUOTES,
                    'UTF-8'
                );
            ?>"
            placeholder="Search ticket ID, customer, model..."
        >

        <button
            class="btn"
            type="submit"
        >
            Search
        </button>

        <a
            class="btn secondary"
            href="view.php"
        >
            Reset
        </a>

    </form>


    <div class="filters">

        <a href="view.php">
            All
        </a>

        <a href="view.php?status=Pending">
            Pending
        </a>

        <a href="view.php?status=In%20Progress">
            In Progress
        </a>

        <a href="view.php?status=Completed">
            Completed
        </a>

    </div>


    <div class="table-wrap">

        <table>

            <thead>

            <tr>

                <th>ID</th>

                <th>Customer</th>

                <th>Device</th>

                <th>Problem</th>

                <th>Priority</th>

                <th>Status</th>

                <th>Date</th>

                <th>Action</th>

            </tr>

            </thead>


            <tbody>


            <?php if (mysqli_num_rows($result) > 0): ?>


                <?php while ($row = mysqli_fetch_assoc($result)): ?>

                    <tr>

                        <td>
                            #<?php echo (int)$row["id"]; ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $row["customer_name"],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>
                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row["device_type"],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                            <br>

                            <small>

                                <?php
                                echo htmlspecialchars(
                                    $row["device_model"],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                            </small>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row["problem"],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row["priority"],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </td>


                        <td>

                            <span class="status">

                                <?php
                                echo htmlspecialchars(
                                    $row["status"],
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                            </span>

                        </td>


                        <td>

                            <?php
                            echo htmlspecialchars(
                                $row["created_at"],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </td>


                        <td>

                            <a
                                href="update.php?id=<?php
                                    echo (int)$row["id"];
                                ?>"
                            >
                                Update
                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>


            <?php else: ?>

                <tr>

                    <td colspan="8">
                        No tickets found.
                    </td>

                </tr>

            <?php endif; ?>


            </tbody>

        </table>

    </div>

</main>


</body>

</html>


<?php

mysqli_stmt_close($stmt);

mysqli_close($conn);

?>