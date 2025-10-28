<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Blog Messages</title>
    <link rel="stylesheet" href="css\blog\blog_write_page_form.css">
    <script src="https://cdn.tiny.cloud/1/90rb0dz8s4e1yx689c1c1c1ebe17yix5heockrzm5epz3fbt/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#blogContent',
            height: 800,
            setup: function(editor) {
                editor.on('change', function() {
                    tinymce.triggerSave(); // Save the TinyMCE content to the original textarea
                });
            },
            plugins: 'a11ychecker advcode advlist lists link checklist autolink autosave code',
            toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | outdent indent | link',
            toolbar_mode: 'floating',
        });
    </script>
</head>

<body>
    <?php
    $currentPage2 = basename($_SERVER['PHP_SELF']);
    $currentPage = 'dashboard.startmenu.php';
    include('../templates/includes/sidenavbar.php');

    ?>
    <?php

    if (isset($_SESSION['CustomerID']) && isset($_SESSION['Admin'])) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            date_default_timezone_set('Europe/Berlin');
            $dateTime = date('Y-m-d H:i:s');

            $blogTitle = $_POST["blogTitle"];  // not sanitizing inputs with strip_tags()
            $blogContent = $_POST["blogContent"]; // not sanitizing inputs with strip_tags()

            // Append to file
            $blogEntry = $blogTitle . "\n" . $blogContent . "\n" .
                "<span class='date-time'>Geschrieben am: " . $dateTime . "</span>" .
                "\n---\n";
            file_put_contents('../src/db/blog/blog_posts.txt', $blogEntry, FILE_APPEND);
        }
    ?>
        <div class="content">
            <div class="write_blog_dashboard">
                <form id="blogForm" action="dashboard.blog.php" method="POST">
                    <label for="blogTitle">Title:</label>
                    <input type="text" id="blogTitle" name="blogTitle" required>

                    <label for="blogContent">Content:</label>
                    <textarea id="blogContent" name="blogContent" rows="45" required></textarea>

                    <button type="submit" id="submitBlog">Post Blog</button>
                </form>
            </div>
        </div>
    <?php
    }
    ?>
</body>
<script>
    document.getElementById('blogForm').addEventListener('submit', function(e) {
        tinymce.triggerSave();
        const title = document.getElementById('blogTitle').value;
        const content = document.getElementById('blogContent').value;

        if (!title || !content) {
            alert('Please fill in all fields');
            return;
        }
    });
</script>