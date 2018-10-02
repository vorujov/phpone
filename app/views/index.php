<!DOCTYPE html>
<html lang="<?= ACTIVE_LANG ?>">
<head>
    <?php 
        \Core\View::set("head.title", "PHPOne - Simple and flexible PHP 5.6+ MVC micro-framework");
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
    <h1>PHPOne - Simple and flexible PHP 5.6+ MVC micro-framework</h1>
    <p>Developed by <a href="https://github.com/vorujov" target="_blank">Vusal Orujov</a>.</p>
</body>
</html>