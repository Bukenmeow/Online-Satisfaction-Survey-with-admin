<?php
include("../logics/config.php");
include('../logics/check_login.php');
include('../logics/checkRole.php');
$user_data = check_login($pdo);

if (!isAdmin()) {
    header('location: ../login.php');
    die();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM inquiries ORDER BY date_created DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

$countSql = "SELECT COUNT(*) as messageCount FROM inquiries";
$countStmt = $pdo->prepare($countSql);
$countStmt->execute();

// Fetch the count
$messageCount = $countStmt->fetchColumn();
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
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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
                <br><br><br>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-3 col-md-2">
                        </div>
                        <div class="col-sm-9 col-md-10">
                        </div>
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-sm-3 col-md-2">
                            <ul class="nav nav-pills nav-stacked">
                                <li class="active">
                                    <a href="#">
                                        <span class="badge pull-right">
                                            <?php echo $messageCount; ?>
                                        </span> Inbox
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-9 col-md-10">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab"><span
                                            class="glyphicon glyphicon-inbox">
                                        </span>Suggestions</a></li>

                            </ul>
                            <!-- Messages -->
                            <?php
                            if ($messages) {
                                foreach ($messages as $message) {
                                    $messageId = $message['id']; // Assuming there's a unique identifier like 'id' in your 'inquiries' table
                            
                                    echo '<a href="message_details.php?id=' . $messageId . '" class="list-group-item">';
                                    echo '<div class="checkbox">';
                                    echo '<label>';
                                    echo '<input type="checkbox">';
                                    echo '</label>';
                                    echo '</div>';
                                    echo '<span class="glyphicon glyphicon-star-empty"></span><span class="name" style="min-width: 120px; display: inline-block;">' . ($message["email"] !== null ? htmlspecialchars($message["email"]) : '') . '</span>';
                                    echo '<span class="">' . ($message["name"] !== null ? htmlspecialchars($message["name"]) : '') . '</span>';
                                    echo '<span class="text-muted" style="font-size: 11px;">' . ($message["message"] !== null ? htmlspecialchars($message["message"]) : '') . '</span>';
                                    echo '<span class="badge">' . ($message["date_created"] !== null ? htmlspecialchars($message["date_created"]) : '') . '</span>';
                                    echo '</span>';
                                    echo '</a>';
                                }
                            } else {
                                // If no messages are found
                                echo '<div class="list-group-item">';
                                echo '<span class="text-center">No messages found.</span>';
                                echo '</div>';
                            }
                            ?>
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
    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Message Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Display name, email, date_created, and message here -->
                    <p><strong>Name:</strong> <span id="modalName"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>Date Created:</strong> <span id="modalDate"></span></p>
                    <p><strong>Message:</strong> <span id="modalMessage"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="deleteMessageBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>