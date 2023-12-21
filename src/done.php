<?php
include("logics/config.php");
include('logics/check_login.php');
include('logics/editDetails.php');
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
    <title>OSMS - Profile</title>
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
                            <li class="nav-item">
                                <a class="nav-link" href="user.php">Home</a>
                            </li>
                            <li class="nav-item active">
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
            <div class="vh-100 d-flex justify-content-center align-items-center">
                <div class="card col-md-4 bg-white shadow-md p-5">
                    <div class="mb-4 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                            fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                        </svg>
                    </div>
                    <div class="text-center">
                        <h1>Thank You !</h1>
                        <p>We've already recorded the survey. Logout and comeback another day </p>
                        <form action="logics/logout.php" method="post">
                            <button type="submit" class="btn btn-outline-success">Logout</button>
                        </form>
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