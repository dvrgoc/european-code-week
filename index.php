<?php require_once 'config.php'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homepage</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-theme.css">
    <link rel="stylesheet" href="css/ecw.css">
</head>
<body class="container-fluid">
    <header class="container">
        <div class="row">
            <a class="logo" href="/" title="Logo">
                <img src="images/codeweekeu.png" alt="Europe Code Week" />
            </a>
        </div>
        <nav class="row">
            <ul class="nav nav-pills">
                <li class="active"><a href="#">Categories</a></li>
                <li><a href="#">Articles</a></li>
                <li><a href="#">Search</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">
        <div class="row">
            <sidebar class="col-sm-4">
                <ul>
                    <li><p>Parent Category</p></li>
                    <li>
                        <p>Parent Category</p>
                        <ul>
                            <li><p>Child Category</p></li>
                            <li><p>Child Category</p></li>
                        </ul>
                    </li>
                </ul>
<<<<<<< d26df3a0eae3f60d25cc5f59bef99ad83348a269
            </sidebar>
            <section class="col-sm-8">
                <p>It is October 19th, 2016, 10:29 AM</p>
            </section>
        </div>
=======
            </li>
        </ul>
    </sidebar>
    <main>
        <section>
            <p>It is <?php echo date("Y-m-d H:i:s") ?></p>
        </section>
>>>>>>> created config.php
    </main>
    <footer class="container">
        <p>European Code Week, Osijek, October 19th 2016</p>
        <p><a href="mailto:danijel.vrgoc@inchoo.net">danijel.vrgoc@inchoo.net</a></p>
    </footer>

    <script src="js/jquery-3.1.1.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>