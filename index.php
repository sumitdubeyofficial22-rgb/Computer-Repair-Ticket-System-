<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Computer Repair Ticket System</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav>

    <a class="brand" href="index.php">
        🔧 RepairDesk
    </a>

    <div>
        <a href="index.php">Home</a>
        <a href="#features">Features</a>
        <a href="view.php">View Tickets</a>
    </div>

</nav>


<main class="hero">

    <!-- LEFT SIDE -->

    <section class="hero-text">

        <p class="tag">
            🚀 DBMS UNIT 4 MINI PROJECT
        </p>

        <h1>
            Computer Repair
            <span>Ticket System</span>
        </h1>

        <p>
            Submit your computer or laptop repair request
            and track its service status easily.
        </p>


        <div class="hero-buttons">

            <a class="btn" href="#ticket-form">
                ➕ Create Repair Ticket
            </a>

            <a class="btn secondary" href="view.php">
                📋 View Tickets
            </a>

        </div>


        <div class="stats">

            <div>
                <h2 class="counter" data-target="100">0</h2>
                <p>Tickets</p>
            </div>

            <div>
                <h2 class="counter" data-target="50">0</h2>
                <p>Customers</p>
            </div>

            <div>
                <h2 class="counter" data-target="24">0</h2>
                <p>Support</p>
            </div>

        </div>

    </section>


    <!-- FORM -->

    <section class="card form-card" id="ticket-form">

        <div class="form-header">

            <h2>
                🛠 New Repair Ticket
            </h2>

            <p>
                Fill in the details below
            </p>

        </div>


        <form action="save.php" method="post" id="repairForm">


            <!-- CUSTOMER NAME -->

            <label for="customer_name">
                👤 Customer Name
            </label>

            <input
                type="text"
                id="customer_name"
                name="customer_name"
                maxlength="100"
                pattern="[A-Za-z .'-]{2,100}"
                placeholder="Enter your name"
                required
            >


            <!-- DEVICE TYPE -->

            <label for="device_type">
                💻 Device Type
            </label>

            <select
                id="device_type"
                name="device_type"
                required
            >

                <option value="">
                    Select device
                </option>

                <option>Laptop</option>

                <option>Desktop</option>

                <option>All-in-One</option>

                <option>Other</option>

            </select>


            <!-- DEVICE MODEL -->

            <label for="device_model">
                ⚙️ Device Model
            </label>

            <input
                type="text"
                id="device_model"
                name="device_model"
                maxlength="100"
                placeholder="Example: HP Pavilion"
                required
            >


            <!-- PROBLEM -->

            <label for="problem">
                📝 Problem Description
            </label>

            <textarea
                id="problem"
                name="problem"
                rows="4"
                maxlength="500"
                placeholder="Describe the problem..."
                required
            ></textarea>

            <div class="character-count">
                <span id="charCount">0</span>/500 characters
            </div>


            <!-- PRIORITY -->

            <label>
                ⚡ Priority
            </label>


            <div class="priority-container">

                <label class="priority-option low">

                    <input
                        type="radio"
                        name="priority"
                        value="Low"
                        required
                    >

                    🟢 Low

                </label>


                <label class="priority-option medium">

                    <input
                        type="radio"
                        name="priority"
                        value="Medium"
                    >

                    🟡 Medium

                </label>


                <label class="priority-option high">

                    <input
                        type="radio"
                        name="priority"
                        value="High"
                    >

                    🔴 High

                </label>

            </div>


            <!-- LIVE PREVIEW -->

            <div class="ticket-preview">

                <h3>
                    📄 Ticket Preview
                </h3>

                <p>
                    <strong>Name:</strong>
                    <span id="previewName">
                        Not entered
                    </span>
                </p>

                <p>
                    <strong>Device:</strong>
                    <span id="previewDevice">
                        Not selected
                    </span>
                </p>

                <p>
                    <strong>Priority:</strong>
                    <span id="previewPriority">
                        Not selected
                    </span>
                </p>

            </div>


            <button
                class="btn full"
                type="submit"
            >

                🚀 Submit Repair Request

            </button>


        </form>

    </section>

</main>


<!-- FEATURES -->

<section class="features" id="features">


    <div class="feature-card">

        <div class="feature-icon">
            ➕
        </div>

        <h3>
            Add Ticket
        </h3>

        <p>
            Store repair requests securely in MySQL.
        </p>

    </div>


    <div class="feature-card">

        <div class="feature-icon">
            🔎
        </div>

        <h3>
            Search Tickets
        </h3>

        <p>
            Find tickets by ID, customer, or device.
        </p>

    </div>


    <div class="feature-card">

        <div class="feature-icon">
            🔄
        </div>

        <h3>
            Update Status
        </h3>

        <p>
            Change ticket status as work progresses.
        </p>

    </div>


</section>


<!-- SCROLL TO TOP -->

<button id="scrollTop" title="Go to top">
    ↑
</button>


<script>

    /* CHARACTER COUNTER */

    const problem = document.getElementById("problem");

    const charCount = document.getElementById("charCount");

    problem.addEventListener("input", function () {

        charCount.textContent = problem.value.length;

    });


    /* LIVE TICKET PREVIEW */

    const customerName =
        document.getElementById("customer_name");

    const deviceType =
        document.getElementById("device_type");

    const priorityInputs =
        document.querySelectorAll(
            'input[name="priority"]'
        );


    customerName.addEventListener("input", function () {

        document.getElementById(
            "previewName"
        ).textContent =
            customerName.value || "Not entered";

    });


    deviceType.addEventListener("change", function () {

        document.getElementById(
            "previewDevice"
        ).textContent =
            deviceType.value || "Not selected";

    });


    priorityInputs.forEach(function (input) {

        input.addEventListener("change", function () {

            document.getElementById(
                "previewPriority"
            ).textContent =
                input.value;

        });

    });


    /* ANIMATED COUNTERS */

    const counters =
        document.querySelectorAll(".counter");


    counters.forEach(function (counter) {

        const target =
            Number(counter.dataset.target);

        let count = 0;

        const increment =
            Math.ceil(target / 100);


        const updateCounter = function () {

            count += increment;


            if (count < target) {

                counter.textContent = count;

                setTimeout(
                    updateCounter,
                    20
                );

            }

            else {

                counter.textContent =
                    target + "+";

            }

        };


        updateCounter();

    });


    /* SCROLL TO TOP */

    const scrollTop =
        document.getElementById("scrollTop");


    window.addEventListener(
        "scroll",
        function () {

            if (window.scrollY > 300) {

                scrollTop.style.display =
                    "block";

            }

            else {

                scrollTop.style.display =
                    "none";

            }

        }
    );


    scrollTop.addEventListener(
        "click",
        function () {

            window.scrollTo({

                top: 0,

                behavior: "smooth"

            });

        }
    );

</script>


</body>

</html>