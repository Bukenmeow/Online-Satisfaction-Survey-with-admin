<?php
include("../logics/config.php");
include('../logics/check_login.php');
include('../logics/checkRole.php');

$user_data = check_login($pdo);

if (!isAdmin()) {
    header('location: ../login.php');
    die();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch user data based on user_id
    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header('location: users.php');
        die();
    }
} else {
    header('location: users.php');
    die();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $birthday = $_POST['birthday'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST['category'];

    $sql = "UPDATE users SET username = :username, password = :password, first_name = :first_name, last_name = :last_name, email = :email, contact_number = :contact_number, address = :address, birthday = :birthday, category = :category WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':contact_number', $contact_number, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':category', $role, PDO::PARAM_STR);
    $stmt->execute();

    header('location: users.php');
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
            <main class="main edit-user-page" id="skip-target">
                <div class="container">
                    <h2 class="main-title m-5">Edit User</h2>
                    <div class="col-xl-8">
                        <div class="card mb-4">
                            <div class="card-header">Account Details</div>
                            <div class="card-body">
                                <form method="post">
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="username">Username</label>
                                            <input class="form-control" id="username" type="text" name="username"
                                                value="<?php echo htmlspecialchars($user['username']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="password">Password</label>
                                            <input class="form-control" id="password" type="password" name="password"
                                                value="<?php echo htmlspecialchars($user['password']); ?>">
                                        </div>
                                    </div>
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="first_name">First name</label>
                                            <input class="form-control" id="first_name" type="text" name="first_name"
                                                value="<?php echo htmlspecialchars($user['first_name']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="last_name">Last name</label>
                                            <input class="form-control" id="last_name" type="text" name="last_name"
                                                value="<?php echo htmlspecialchars($user['last_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="email">Email Address</label>
                                            <input class="form-control" id="email" type="text" name="email"
                                                value="<?php echo htmlspecialchars($user['email']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="contact_number">Contact Number</label>
                                            <input class="form-control" id="contact_number" type="number"
                                                name="contact_number"
                                                value="<?php echo htmlspecialchars($user['contact_number']); ?>">
                                        </div>
                                    </div>
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="address">Address</label>
                                            <input class="form-control" id="address" type="text" name="address"
                                                value="<?php echo htmlspecialchars($user['address']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputBirthday">Birthday</label>
                                            <input class="form-control" id="inputBirthday" type="date" name="birthday"
                                                value="<?php echo htmlspecialchars($user['birthday']); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="role">Role</label>
                                        <select class="form-control" id="role" name="category">
                                            <option value="user" <?php echo $user['category'] == 'user' ? 'selected' : ''; ?>>
                                                User</option>
                                            <option value="admin" <?php echo $user['category'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        </select>
                                        <br>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </form>
                            </div>
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