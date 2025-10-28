<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <!--<link rel="stylesheet" href="css/style.css">-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/settings.style.css">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 600, 'GRAD' 0, 'opsz' 80;
        }

        #toggleIcon {
            font-variation-settings: 'FILL' 0, 'wght' 600, 'GRAD' 0, 'opsz' 48;
            cursor: pointer;
            transition: color 0.2s, transform 0.5s;
            font-size: 40px;
        }

        #toggleIcon:hover {
            color: red;
        }

    </style>
</head>

<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    ?>

    <div class="content">
        <h1 class="titleSettings">
            Einstellungen
        </h1>
        <hr>
        <div class="WholeLanguageBox">
            <p class="languageTranslate">
                Language:
                <div id="google_translate_element"></div>
            </p>
        </div>
        <hr>
        <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <script>
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'de'
                }, 'google_translate_element');
            }
        </script>

        <div class="WhiteDarkMode">
            <p id="WhirkMode">
                Dunkelmodus:
            </p>

            <span id="toggleIcon" onclick="toggleText()">
                <!-- Initially, show the toggle_off icon -->
                <svg class="FirstToggleIcon" xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                    <!-- SVG path for toggle_off -->
                    <path id="toggleOffPath" d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-60h400q75 0 127.5-52.5T860-480q0-75-52.5-127.5T680-660H280q-75 0-127.5 52.5T100-480q0 75 52.5 127.5T280-300Zm-1.059-79Q321-379 350.5-408.441t29.5-71.5Q380-522 350.559-551.5t-71.5-29.5Q237-581 207.5-551.559t-29.5 71.5Q178-438 207.441-408.5t71.5 29.5ZM480-480Z" />
                </svg>
            </span>
            <p id="IsItOn">
                Aus
            </p>
        </div>

        <hr>
        <div class="UserAccount">
            Feld selektieren
        </div>
        <hr>
    </div>
    <script>
        function toggleText() {
            const toggleIcon = document.getElementById("toggleIcon");
            const toggleOnPath = "M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-60h400q75 0 127.5-52.5T860-480q0-75-52.5-127.5T680-660H280q-75 0-127.5 52.5T100-480q0 75 52.5 127.5T280-300Zm400.941-79Q723-379 752.5-408.441t29.5-71.5Q782-522 752.559-551.5t-71.5-29.5Q639-581 609.5-551.559t-29.5 71.5Q580-438 609.441-408.5t71.5 29.5ZM480-480Z";
            const toggleOffPath = "M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-60h400q75 0 127.5-52.5T860-480q0-75-52.5-127.5T680-660H280q-75 0-127.5 52.5T100-480q0 75 52.5 127.5T280-300Zm-1.059-79Q321-379 350.5-408.441t29.5-71.5Q380-522 350.559-551.5t-71.5-29.5Q237-581 207.5-551.559t-29.5 71.5Q178-438 207.441-408.5t71.5 29.5ZM480-480Z";

            // Get the current path of the icon
            const currentPath = toggleIcon.querySelector("path").getAttribute("d");

            if (currentPath === toggleOnPath) {
                // Change the icon to toggle_off
                toggleIcon.innerHTML = `<svg class="FirstToggleIcon" xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                                            <path d="${toggleOffPath}" />
                                        </svg>`;
            } else {
                // Change the icon to toggle_on
                toggleIcon.innerHTML = `<svg class="FirstToggleIcon" xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                                            <path d="${toggleOnPath}" />
                                        </svg>`;
            }

            // Add a class to the SVG element to keep it scaled(1.3) after click
            toggleIcon.firstElementChild.classList.add("ClickedToggleIcon");
        }
    </script>
        <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>
</body>

</html>
