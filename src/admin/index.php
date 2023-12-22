<?php
include("../logics/config.php");
include('../logics/check_login.php');
include('../logics/checkRole.php');
$user_data = check_login($pdo);

if (!isAdmin()) {
    header('location: ../login.php');
    die();
}




$sql = "SELECT COUNT(*) as user_count FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$userCount = $stmt->fetchColumn();

$sql1 = "SELECT COUNT(DISTINCT user_id) as indicator_count FROM indicator_responses";
$stmt1 = $pdo->prepare($sql1);
$stmt1->execute();
$indicatorCount = $stmt1->fetchColumn();


$sql2 = "SELECT COUNT(DISTINCT user_id) as survey_count FROM survey_responses";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute();
$surveyCount = $stmt2->fetchColumn();


$totalCount = $indicatorCount + $surveyCount;


$sql3 = "SELECT * FROM users WHERE date_registered >= DATE(NOW()) - INTERVAL 7 DAY";
$stmt3 = $pdo->prepare($sql3);
$stmt3->execute();

$newUsers = $stmt3->fetchAll(PDO::FETCH_ASSOC);




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>OSMS - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.html">OSMS Admin Panel</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </div>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="../logics/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Get Started!</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-gauge"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="survey.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-comments"></i></div>
                            Survey
                        </a>
                        <a class="nav-link" href="users.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            Users
                        </a>
                        <a class="nav-link" href="inquiries.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-circle-question"></i></div>
                            Inquires
                        </a>
                        <a class="nav-link" href="../logics/logout.php">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $user_data['first_name'] . " " . $user_data['last_name']; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main class="main users chart-page" id="skip-target">
                <div class="container">
                    <h2 class="main-title">Dashboard</h2>
                    <div class="row stat-cards">
                        <div class="col-md-6 col-xl-6">
                            <article class="stat-cards-item">
                                <div class="stat-cards-icon primary">
                                    <i data-feather="bar-chart-2" aria-hidden="true"></i>
                                </div>
                                <div class="stat-cards-info">
                                    <p class="stat-cards-info__num">Survey Answered</p>
                                    <p class="stat-cards-info__title">
                                        <?php echo "Total unique users who answered surveys: " . $totalCount; ?>
                                    </p>
                                    <p class="stat-cards-info__progress">
                                        <span class="stat-cards-info__profit success">
                                            <i data-feather="trending-up" aria-hidden="true"></i>Ongoing
                                        </span>
                                        OSMS
                                    </p>
                                </div>
                            </article>
                        </div>
                        <div class="col-md-6 col-xl-6">
                            <article class="stat-cards-item">
                                <div class="stat-cards-icon primary">
                                    <i data-feather="bar-chart-2" aria-hidden="true"></i>
                                </div>
                                <div class="stat-cards-info">
                                    <p class="stat-cards-info__num">Users Registered</p>
                                    <p class="stat-cards-info__title">
                                        <?php echo "Total registered users: " . $userCount; ?>
                                    </p>
                                    <p class="stat-cards-info__progress">
                                        <span class="stat-cards-info__profit success">
                                            <i data-feather="trending-up" aria-hidden="true"></i>Ongoing
                                        </span>
                                        OSMS
                                    </p>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-screen">
                        <div class="users-table table-wrapper">
                            <h2 class="main-title m-5">New Users (Past 7 Days)</h2>
                            <table class="posts-table">
                                <thead>
                                    <tr class="users-table-info">
                                        <th></th>
                                        <th>Profile Picture</th>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th>Date Registered</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($newUsers as $user): ?>

                                        <tr>
                                            <td></td>
                                            <td>
                                                <label class="users-table__checkbox">
                                                    <div class="categories-table-img">
                                                        <picture>
                                                            <source
                                                                srcset="../uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>"
                                                                type="image/webp">
                                                            <img src="../uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>"
                                                                alt="Profile Picture">
                                                        </picture>
                                                    </div>
                                                </label>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($user['first_name']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($user['last_name']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($user['date_registered']); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="./plugins/chart.min.js"></script>
    <script src="plugins/feather.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/elescript.js"></script>
</body>

</html>