<?php
session_start();
session_regenerate_id(true);

// Set the header to skip the Ngrok browser warning
header('ngrok-skip-browser-warning: true');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="..\css\navbar\navbar.css">
    <link rel="stylesheet" href="..\css\navbar\sliding-menu.css">
    <link rel="stylesheet" href="..\css\navbar\search-bar.css">
    <link rel="stylesheet" href="..\css\navbar\LoginDropDown.css">
    <link rel="stylesheet" href="css\reset.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rubik+Iso&family=Ubuntu&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@500&display=swap">
    <link rel="icon" type="image/png" href="../img/png icons/FliegenderTeppich-logo1.png">
</head>

<body>
    <header>
        <div class="navbar">
            <div class="logo"><a href="index.php">
                    <img src="..\img\png icons\FliegenderTeppich-logo1.png" alt="" style="width: 75px; margin: 5px;">

                </a>
            </div>
            <div class="lol">
                <button class="burger-button-animated" id="hauptnavigation">
                    <span class="line first-line"> </span>
                    <span class="line second-line"> </span>
                    <span class="line third-line"> </span>
                </button>
            </div>

            <div id="ClickSpaceMenu">

            </div>

            <ul class="links">
                <?php
                if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
                    echo '<li><a href="dashboard.startmenu.php" ' . ((isset($currentPage) && $currentPage === 'dashboard.startmenu.php') ? 'class="active"' : '') . '>Dashboard</a></li>';
                }
                ?>
                <li><a href="index.php" <?php echo (isset($currentPage) && $currentPage === 'index.php') ? 'class="active"' : ''; ?>>Startseite</a></li>
                <li><a href="shop.php" <?php echo (isset($currentPage) && $currentPage === 'shop.php') ? 'class="active"' : ''; ?>>Shop</a></li>
                <li><a href="blog.php" <?php echo (isset($currentPage) && $currentPage === 'blog.php') ? 'class="active"' : ''; ?>>Blog</a></li>
                <li><a href="cart.php" <?php echo (isset($currentPage) && $currentPage === 'cart.php') ? 'class="active"' : ''; ?>>Einkaufswagen</a></li>
                <li><a href="contact.php" <?php echo (isset($currentPage) && $currentPage === 'contact.php') ? 'class="active"' : ''; ?>>Kontakt</a></li>
                <li class="UniqueLoginHover">
                    <?php
                    if (isset($_SESSION["username"])) {
                        /*echo '<a class="UniqueLoginHover" href="logout.php">Abmelden</a>';*/
                    } else {
                        echo '<a class="UniqueLoginHover' . (isset($currentPage) && $currentPage === 'login.php' ? ' active' : '') . '" href="login.php">Konto erstellen</a>';
                    }
                    ?>
                </li>
                <li class="Anmelden_Abmelden">
                    <div class="Anmelden_Abmelden_Hover">
                        <div class="LoginIcon">
                            <?php
                            if (isset($_SESSION['username'])) {
                                echo '<a href="logout.php"><img id="loginImage" src="../img/png icons/Login icon.png" alt="LoginIcon"></a>';
                            } else {
                                echo '<img id="loginImage" src="../img/png icons/Logout icon.png" alt="LogoutIcon">';
                            }
                            ?>
                        </div>
                        <?php
                        if (isset($_SESSION['CustomerID'])) {
                            //show "Abmelden"
                            echo '<a class="AN_ABmelden" href="logout.php">Abmelden</a>';
                        } else {
                            // User is not logged in, show "Anmelden"
                            echo '<a class="AN_ABmelden" onclick="OpenLoginMenu()">Anmelden</a>';
                        }
                        ?>
                    </div>
                    <div class="formDropDown">
                        <!-- Add a form element here -->
                        <form method="post" action="..\db\database_handler\login.inc.php">
                            <div class="container">
                                <label for="uname"><b>Benutzername</b></label>
                                <input type="text" placeholder="Benutzernamen eingeben" name="uname" required>

                                <label for="psw"><b>Passwort</b></label>
                                <input type="password" placeholder="Passwort eingeben" name="psw" required>

                                <button class="btn btn-background-slide" type="submit" name="submit">Anmelden</button>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <div class="StayRotated">
                        <a href="account.php" class="dropdown-trigger" onclick="toggleDropdown()">
                            <div id="settingsIcon" class="settings-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                                    <path d="m388-80-20-126q-19-7-40-19t-37-25l-118 54-93-164 108-79q-2-9-2.5-20.5T185-480q0-9 .5-20.5T188-521L80-600l93-164 118 54q16-13 37-25t40-18l20-127h184l20 126q19 7 40.5 18.5T669-710l118-54 93 164-108 77q2 10 2.5 21.5t.5 21.5q0 10-.5 21t-2.5 21l108 78-93 164-118-54q-16 13-36.5 25.5T592-206L572-80H388Zm92-270q54 0 92-38t38-92q0-54-38-92t-92-38q-54 0-92 38t-38 92q0 54 38 92t92 38Zm0-60q-29 0-49.5-20.5T410-480q0-29 20.5-49.5T480-550q29 0 49.5 20.5T550-480q0 29-20.5 49.5T480-410Zm0-70Zm-44 340h88l14-112q33-8 62.5-25t53.5-41l106 46 40-72-94-69q4-17 6.5-33.5T715-480q0-17-2-33.5t-7-33.5l94-69-40-72-106 46q-23-26-52-43.5T538-708l-14-112h-88l-14 112q-34 7-63.5 24T306-642l-106-46-40 72 94 69q-4 17-6.5 33.5T245-480q0 17 2.5 33.5T254-413l-94 69 40 72 106-46q24 24 53.5 41t62.5 25l14 112Z" />
                                </svg>
                            </div>
                        </a>

                        <ul class="dropdown-menu" id="dropdownMenu">
                            <li><a href="contact.php#fname">Support kontaktieren</a></li>
                            <li><a href="account.php#titleSection">Benutzerkonto</a></li>
                            <li><a href="#website_info">Website-Informationen</a></li>
                        </ul>
                    </div>
                </li>
                <!--<li><a href="settings.php"><div class="settings-icon"><span class="material-symbols-outlined">settings</span></div></a></li>-->
                <!--<li><a href="404.php" <?php echo (isset($currentPage) && $currentPage === '404.php') ? 'class="active"' : ''; ?>>404 Not Found</a></li>-->
            </ul>
        </div>
    </header>

    <div class="sliding-menu" id="SlidingContent">

        <div class="slidinginsidecontent">
            <ul>
                <li>
                    <a href="index.php"><img src="..\img\png icons\House-icon.png">Startseite</a>
                </li>
                <li>
                    <a href="about-me.php"><img src="..\img\png icons\info icon.png">Über mich</a>
                </li>
                <li>
                    <a href="blog.php"><img src="..\img\png icons\comment icon.png">Blog</a>
                </li>
            </ul>
            <hr>
            <h1>Bücher &amp; E-Bücher</h1>
            <ul>
                <li>
                    <a id="sidemenu-startpractice" href="shop.php"><img src="..\img\png icons\book icon.png">Shop</a>
                </li>
                <li>
                    <a href="cart.php"><img src="..\img\png icons\shopping cart.png">Einkaufswagen</a>
                </li>
            </ul>
            <hr>
            <h1>Hilfe &amp; Einstellungen</h1>
            <ul>
                <li>
                    <a href="contact.php"><img src="..\img\png icons\contact page.png">Kontakt</a>
                </li>
                <li>
                    <a href="account.php"><img src="..\img\png icons\account icon.png">Benutzerkonto</a>
                </li>
                <!--<li>
                        <a href="settings.php" id="sidemenu-livegame"><img src="..\img\png icons\settings icon.png">Settings</a>
                    </li>-->

                <?php
                if (!isset($_SESSION['CustomerID'])) {
                ?>
                    <li>
                        <a href="login2.php"><img src="..\img\png icons\Login icon.png">Anmelden</a>
                    </li>
                <?php
                } else {
                ?>
                    <li>
                        <a href="logout.php"><img src="..\img\png icons\Logout icon.png">Abmelden</a>
                    </li>

                    <li>
                        <a href="account.php"><img src="..\img\png icons\edit-icon.png">Konto bearbeiten</a>
                    </li>
                <?php
                }
                ?>
            </ul>

            <?php
            if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
            ?>
                <hr>
                <h1>Admin-Dashboard</h1>

                <ul>
                    <li>
                        <a href="../dashboard.startmenu.php"><img src="..\img\png icons\menu2 icon.png">Startmenü</a>
                    </li>
                    <li>
                        <a href="../dashboard.messages.php"><img src="..\img\png icons\unreadMail icon.png">Nachrichten</a>
                    </li>
                    <li>
                        <a href="../dashboard.addBook.php"><img src="..\img\png icons\addBoxIcon.png">Buch hinzufügen</a>
                    </li>
                    <li>
                        <a href="../dashboard.blog.php"><img src="..\img\png icons\pen-icon.png">Blog Artikel schreiben</a>
                    </li>
                    <li>
                        <a href="../dashboard.payment.php"><img src="..\img\png icons\shopping cart.png">Zahlungen</a>
                    </li>
                    <li>
                        <a href="../dashboard.delete_account.php"><img src="..\img\png icons\delete-icon.png">Benutzerkonto löschen</a>
                    </li>
                </ul>
            <?php
            }
            ?>


        </div>
    </div>
    </div>
    <script>
        const stayRotatedDiv = document.querySelector(".StayRotated");
        const settingsIcon = document.getElementById("settingsIcon");
        const dropdownMenu = document.getElementById("dropdownMenu");

        stayRotatedDiv.addEventListener("mouseenter", () => {
            settingsIcon.classList.add("rotate");
        });

        stayRotatedDiv.addEventListener("mouseleave", () => {
            if (!dropdownMenu.classList.contains("show")) {
                settingsIcon.classList.remove("rotate");
            }
        });

        settingsIcon.addEventListener("click", () => {
            dropdownMenu.classList.toggle("show");
        });

        dropdownMenu.addEventListener("mouseleave", () => {
            dropdownMenu.classList.remove("show");
            settingsIcon.classList.remove("rotate");
        });
    </script>

    <script src="../js/navbar.script.js"></script>

</body>

</html>
