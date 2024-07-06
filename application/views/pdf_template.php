<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            font-size: 14px;
        }

        h1,
        h2,
        h3 {
            color: #333;
        }
    </style>
</head>

<body>
    <h1><?php echo $title; ?></h1>
    <div>
        <?php echo $content; ?>
    </div>
</body>

</html>