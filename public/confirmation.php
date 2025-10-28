<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');
    ?>
    <!--<div class="content">
        <div class="searchBar">
            <input type="search" class="searchField" placeholder="Suchen ...">
            <button class="searchIcon">
                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0z" fill="none"/>
                    <path d="M15.5 14h-.79l-.28-.27C16.41 12.61 17 11.11 17 9.5 17 5.91 14.09 3 10.5 3S4 5.91 4 9.5 6.91 16 10.5 16c1.61 0 3.11-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-5 0C8.01 14 6 11.99 6 9.5S8.01 5 10.5 5 15 7.01 15 9.5 12.99 14 10.5 14z"/>
                </svg>
            </button>
        </div> 
    </div>-->
    
    <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 200 200">
  <!-- Background -->
  <rect width="100%" height="100%" fill="#2F5D80" />

  <!-- Flying Carpet -->
  <path d="M30,120 Q100,50 170,120 Z" fill="#D6A756" />

  <!-- Book -->
  <rect x="70" y="50" width="60" height="80" rx="10" fill="#FFFFFF" />

  <!-- Book Pages -->
  <rect x="75" y="55" width="50" height="70" rx="8" fill="#F5F5F5" />
  <line x1="75" y1="95" x2="125" y2="95" stroke="#C2C2C2" stroke-width="2" />

  <!-- Text: FliegenderTeppichVerlag -->
  <text x="50%" y="150" font-family="Arial, sans-serif" font-size="14" text-anchor="middle" fill="#FFFFFF">FliegenderTeppichVerlag</text>
</svg>


    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>
</body>
</html>
