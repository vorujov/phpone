<!DOCTYPE html>
<html lang="<?= ACTIVE_LANG ?>">
<head>
    <?php 
        \Core\View::set("head.title", "Page not found!");
        include 'partials/head.php'; 
    ?>
    <style>
        body {
            max-width: 400px;
            margin: 50px auto;
            padding: 0 20px;

            font-family: monospace;
            color: #000;
        }

        h1 {
            font-size: 18px;
            line-height: 24px;
        }

        p {
            font-size: 12px;
            line-height: 14px;
            color: #567;
        }

        a {
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>404 - Not Found</h1>
    <p>This page doesn't exists.</p>
</body>
</html>