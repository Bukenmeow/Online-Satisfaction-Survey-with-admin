<?php
include("logics/config.php");
include('logics/check_login.php');
include('logics/checkRole.php');
$user_data = check_login($pdo);

if (isAdmin()) {
    header('location: ../admin/index.php');
    die();
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>OSMS - Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/userstyle.css">
    <link rel="stylesheet" href="styles/table.css" class="style">
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <?php if (!empty($user_data["profile_picture"])): ?>
                    <img class="img logo rounded-circle mb-5" src="uploads/<?php echo $user_data['profile_picture']; ?>"
                        alt="Profile Picture">
                <?php else: ?>
                    <img class="img logo rounded-circle mb-5" src="uploads/def.png" alt="Default Icon">
                <?php endif; ?>
                <h3>
                    <?php echo $user_data['first_name'] . " " . $user_data['last_name']; ?>
                </h3>
                <ul class="list-unstyled components mb-5">
                    <li>
                        <a href="user.php">Home</a>
                    </li>
                    <li>
                        <a href="profile.php">Profile</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact Us!</a>
                    </li>
                    <li>
                        <a href="logics/logout.php">Logout</a>
                    </li>
                </ul>

                <div class="footer">
                    <p>
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved <i class="icon-heart" aria-hidden="true"></i>
                    </p>
                </div>

            </div>
        </nav>
        <div id="content" class="p-4 p-md-5">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <a type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </a>
                    <a class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </a>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="user.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.php">Contact Us</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logics/logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="container">
                <h2 class="main-title">Home</h2>
                <div class="row stat-cards">
                    <div class="col-md-6 col-xl-6">
                        <article class="stat-cards-item">
                            <div class="stat-cards-icon primary">
                                <i data-feather="bar-chart-2" aria-hidden="true"></i>
                            </div>
                            <div class="stat-cards-info">
                                <a href="surveyDash.php">
                                    <button type="button" class="btn btn-primary row"
                                        data-mdb-ripple-init>Survey</button>
                                </a>
                            </div>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <article class="stat-cards-item">
                            <div class="stat-cards-icon primary">
                                <i data-feather="bar-chart-2" aria-hidden="true"></i>
                            </div>
                            <div class="stat-cards-info">
                                <a href="IndicatorDash.php">
                                    <button type="button" class="btn btn-primary row"
                                        data-mdb-ripple-init>Indicator</button>
                                </a>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>