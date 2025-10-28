<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css\Dashboard\ChartStyles.css">
</head>
<body>
    <?php
    $currentPage2 = basename($_SERVER['PHP_SELF']);
    $currentPage = 'dashboard.startmenu.php';
    include('../templates/includes/sidenavbar.php');
    ?>
    <?php
    
    if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
        // Display this HTML code if the 'CustomerID' session variable is set
        ?>
            <div class="OberesBannerDashboard">
                <div class="GreetingText"> <h1> Hi, <?php echo $_SESSION['username']; ?>! </h1></div>
            </div>
            <div class="UsableSpace">
                <canvas id="clicksChart" style="width: 100%; height: 55vh;"></canvas>
            </div>
        <?php

    
    }
    ?>
    <script src="js/dashboard/dashboard.script.js"></script>
    <script src="js/dashboard/dashboard.clickChart.js"></script>
</body>
</html>