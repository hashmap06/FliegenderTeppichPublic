<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Messages</title>
    <link rel="stylesheet" href="css\Dashboard\readMessages.css">
</head>
<body>
    <?php
    $currentPage2 = basename($_SERVER['PHP_SELF']);
    $currentPage = 'dashboard.startmenu.php';
    include('../templates/includes/sidenavbar.php');
    include('../src/db/database_handler/fetchMessages.comment.php');
    ?>
    <?php
    
    if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
        // Display this HTML code if the 'CustomerID' session variable is set
        ?>
        <div class="content">
            <div class="MessagesDashboard">
                <h1>Nachrichten</h1>
                <table class="EmailTable">
                    <tr>
                        <th>Benutzername</th>
                        <th>Nachrichteninhalt</th>
                        <th>Erstellungsdatum</th>
                    </tr>

                    <?php
                        $fetchComment = new FetchComment();
                        $fetchComment->fetchAndDisplayMessages();
                    ?>
                </table>
            </div>
        </div>
        <?php
    }
    ?>
</body>
</html>
