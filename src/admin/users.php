<?php
include("../logics/config.php");
include('../logics/check_login.php');
include('../logics/checkRole.php');
$user_data = check_login($pdo);

if (!isAdmin()) {
    header('location: ../login.php');
    die();
}

$sql = "SELECT * FROM users WHERE category = 'user'";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.min.css">
    <link rel="stylesheet" href="" class="style">
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
                <div class="row">
                    <div class="col-lg-screen">
                        <div class="users-table table-wrapper">
                            <h2 class="main-title m-5">Registered Users</h2>
                            <table class="posts-table">
                                <thead>
                                    <tr class="users-table-info">
                                        <th>User ID</th>
                                        <th>
                                            <label class="users-table__checkbox ms-20">
                                                Profile Picture
                                            </label>
                                        </th>
                                        <th>First name</th>
                                        <th>Last name</th>
                                        <th>Email</th>
                                        <th>Date Registered</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>
                                                <?php echo htmlspecialchars($user['user_id']); ?>
                                            </td>
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
                                                <?php echo htmlspecialchars($user['email']); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($user['date_registered']); ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success"
                                                    onclick="redirectToEditPage(<?php echo $user['user_id']; ?>)">Edit</button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="showConfirmButton(this, <?php echo $user['user_id']; ?>)">Delete</button>
                                                <button type="button" class="btn btn-danger" style="display: none;"
                                                    onclick="deleteUser(<?php echo $user['user_id']; ?>)">Confirm</button>
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
    <script>
        function redirectToEditPage(userId) {
            window.location.href = 'edit_user.php?user_id=' + userId;
        }
        function showConfirmButton(deleteButton, userId) {
            // Get the next sibling element, which is the confirm button
            var confirmButton = deleteButton.nextElementSibling;

            // Show the confirm button
            confirmButton.style.display = 'inline-block';

            // Set the user id to delete on the confirm button
            confirmButton.setAttribute('data-user-id', userId);
        }

        function deleteUser(userId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('user_id=' + encodeURIComponent(userId));

            xhr.onload = function () {
                if (xhr.status == 200) {
                    location.reload();
                } else {
                    console.error('Error deleting user:', xhr.responseText);
                }
            };
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>