<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/Dashboard/LeftNavBar.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@500&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">

</head>
<body>
    <?php
    include('navbar.php');
    ?>

    <?php
    
    if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
        // Display this HTML code if the 'CustomerID' session variable is set
        ?>

        <!--OFFICIAL SIDENAVBAR CODE:-->
        <div class="vertical-navbar">
            <ul>
                <div class="titleContainer">
                    <div id="dashBoardTitleLeft">
                        <h2>Dashboard</h2>
                    </div>
                </div>
                <hr>
                <li><a href="dashboard.startmenu.php" <?php echo ($currentPage2 === 'dashboard.startmenu.php') ? 'class="active"' : ''; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m787-145 28-28-75-75v-112h-40v128l87 87Zm-587 25q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v268q-19-9-39-15.5t-41-9.5v-243H200v560h242q3 22 9.5 42t15.5 38H200Zm0-120v40-560 243-3 280Zm80-40h163q3-21 9.5-41t14.5-39H280v80Zm0-160h244q32-30 71.5-50t84.5-27v-3H280v80Zm0-160h400v-80H280v80ZM720-40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Z"/></svg>
                    Übersicht Grafik
                </a></li>
                <li><a href="dashboard.messages.php" <?php echo ($currentPage2 === 'dashboard.messages.php') ? 'class="active"' : ''; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160H160Zm320-280L160-640v400h640v-400L480-440Zm0-80 320-200H160l320 200ZM160-640v-80 480-400Z"/></svg>
                    Nachrichten
                </a></li>
                <li><a href="dashboard.addBook.php" <?php echo ($currentPage2 === 'dashboard.addBook.php') ? 'class="active"' : ''; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
                    Buch hinzufügen
                </a></li>
                <li><a href="dashboard.payment.php" <?php echo ($currentPage2 === 'dashboard.payment.php') ? 'class="active"' : ''; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z"/></svg>
                    Zahlungen
                </a></li>
                <li><a href="dashboard.blog.php" <?php echo ($currentPage2 === 'dashboard.blog.php') ? 'class="active"' : ''; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>                    
                    Blog-Artikel schreiben
                </a></li>
                <li><a href="dashboard.delete_account.php" <?php echo ($currentPage2 === 'dashboard.delete_account.php') ? 'class="active"' : ''; ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>                    
                    Benutzerkonten löschen
                </a></li>
            </ul>
        </div>
    
        <?php

    }
    if (isset($_SESSION['CustomerID']) && !isset($_SESSION['Admin'])) {
        ?>
        <div>Entschuldigung <?php echo $_SESSION['username']; ?>, sie haben kein Zugang zu dieser Seite.</div>
        <a href="logout.php">Logout</a>
        <?php
    }
    else if (!isset($_SESSION['CustomerID']) && !isset($_SESSION['Admin'])) {
        // Display this HTML code if the 'CustomerID' session variable is not set
        ?>
        <div class="not_allowed_log_in">Bitte melden Sie sich an, um auf den Inhalt zuzugreifen: <a href="login2.php"> Anmelden</a></div>
        <?php
    }
    ?>
</body>

</html>