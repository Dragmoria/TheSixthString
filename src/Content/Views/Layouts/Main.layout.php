
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empty Page</title>
</head>
<body>
    <header>
        <?php include VIEWS_PATH . 'Partials/Header.partial.php' ?>
    </header>

    <main>
        <?php echo $content; ?>
    </main>

    <footer>
        <?php include VIEWS_PATH . 'Partials/Footer.partial.php'; ?>
    </footer>
</body>
</html>
