<?php
include("../logics/config.php");
include('../logics/check_login.php');
include('../logics/checkRole.php');
$user_data = check_login($pdo);

if (!isAdmin()) {
    header('location: ../login.php');
    die();
}

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
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">OSMS Admin Panel</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="fas fa-bars"></i></button>
        <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
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
                <h2 class="main-title m-5">Survey</h2>
                <div class="row stat-cards">
                    <div class="col-md-6 col-xl-6">
                        <h1 class="sign-up__title">Survey Overview</h1>
                        <article class="stat-cards-item">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Questionnaires</th>
                                        <th>Choices</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT id, question_text, choices FROM questions";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['question_text'] . "</td>";
                                        echo "<td>" . $row['choices'] . "</td>";
                                        echo "<td>";
                                        echo "<form action='delete_survey.php' method='post'>";
                                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                                        echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <h1 class="sign-up__title">Configure Survey</h1>
                        <article class="stat-cards-item">

                            <form action="add_survey.php" method="post">
                                <label class="form-label-wrapper">
                                    <p class="form-label">Questionnaire</p>
                                    <textarea class="form-control" id="questionnaire" name="questionnaire" cols="100"
                                        aria-placeholder="Write your question" rows="4" required></textarea>
                                </label>
                                <label class="form-label-wrapper">
                                    <p class="form-label">Choices</p>

                                    <input class="form-input" type="text" name="choices" id="choices"
                                        placeholder="Write the choices separated by comma" required>
                                </label>
                                <button class="form-btn primary-default-btn transparent-btn">Add</button>
                            </form>
                        </article>
                    </div>
                </div>
                <h2 class="main-title m-5">Indicators</h2>
                <div class="row stat-cards">
                    <div class="col-md-6 col-xl-6">
                        <h1 class="sign-up__title">Indicator Overview</h1>
                        <article class="stat-cards-item">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Questionnaires</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT id, question_text FROM indicator_questions";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['question_text'] . "</td>";
                                        echo "<td>";
                                        echo "<form action='delete_indicator.php' method='post'>";
                                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                                        echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                                        echo "</form>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </article>
                    </div>
                    <div class="col-md-6 col-xl-6">
                        <h1 class="sign-up__title">Configure Indicator</h1>
                        <article class="stat-cards-item">

                            <form action="add_indicator.php" method="post">
                                <label class="form-label-wrapper">
                                    <p class="form-label">Questionnaire</p>
                                    <textarea class="form-control" id="indicator_questions" name="indicator_questions"
                                        cols="100" aria-placeholder="Write your question" rows="4" required></textarea>
                                </label>
                                <p class="form-label"></p>
                                <button class="form-btn primary-default-btn transparent-btn">Add</button>
                            </form>
                        </article>
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