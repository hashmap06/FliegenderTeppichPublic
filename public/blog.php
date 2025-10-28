<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/blog/blog.style.css">
</head>

<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/navbar.php');

    echo '<div class="content"><h1>Hier ist mein Blog</h1><hr class="chief-hr-line">';

    // Read and display blog posts
    $content = file_get_contents('../src/db/blog/blog_posts.txt');
    // Verwendung eines regulären Ausdrucks, um flexibel auf das Trennzeichen zu reagieren
    $blogPosts = preg_split('/\n\s*---\s*\n/', $content);

    foreach ($blogPosts as $post) {
        // Entfernen von führenden und nachfolgenden Whitespaces
        $post = trim($post);
        if (!empty($post)) {
            // Trennung des Titels vom Inhalt
            list($title, $content) = explode("\n", $post, 2);
            echo "<div class='blog-article'>";
            echo "<h2>" . $title . "</h2>"; // Ausgabe des Titels
            echo $content; // Ausgabe des Inhalts
            echo "</div>";
        }
    }


    echo '</div>';
    $currentPage = basename($_SERVER['PHP_SELF']);
    include('../templates/includes/footer.php');
    ?>
</body>

</html>