<?php
include("logics/config.php");
include('logics/check_login.php');
include('logics/editDetails.php');
include('logics/checkRole.php');
include('logics/upload.php');
$user_data = check_login($pdo);

if (isAdmin()) {
    header('location: ../admin/index.php');
    die();
}
$sql = "SELECT * FROM users WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

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
                    <img styles="width=50px; height=50px;" class="img logo rounded-circle mb-5"
                        src="uploads/<?php echo $user_data['profile_picture']; ?>" alt="Profile Picture">
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
            <div class="container-xl px-4 mt-4">
                <nav class="nav nav-borders">
                    <a class="nav-link active ms-0" href="profile.php">Profile</a>
                    <a class="nav-link" href="security.php">Security</a>
                </nav>
                <hr class="mt-0 mb-4">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="card mb-4 mb-xl-0">
                            <div class="card-header">Profile Picture</div>
                            <div class="card-body text-center">
                                <?php if (!empty($user_data["profile_picture"])): ?>
                                    <img style="width:200px; height:200px;" class="img-account-profile rounded-circle mb-2"
                                        src="uploads/<?php echo $user_data['profile_picture']; ?>" alt="Profile Picture">
                                <?php else: ?>
                                    <img style="width:200px; height:200px;" class="img-account-profile rounded-circle mb-2"
                                        src="uploads/def.png" alt="Default Icon">
                                <?php endif; ?>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                                    <input class="form-control" type="file" name="profile_picture" id="profile_picture">
                                    <br>
                                    <button class="btn btn-primary" type="submit">Upload new image</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card mb-4">
                            <div class="card-header">Account Details</div>
                            <div class="card-body">
                                <form method="post" action="logics/update_profile.php">
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputUsername">Username</label>
                                        <input class="form-control" id="inputUsername" type="text" name="username"
                                            placeholder="Enter your username"
                                            value="<?php echo htmlspecialchars($user['username']); ?>">
                                    </div>
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="first_name">First name</label>
                                            <input class="form-control" id="first_name" type="text" name="first_name"
                                                placeholder="Enter your first name"
                                                value="<?php echo htmlspecialchars($user['first_name']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="last_name">Last name</label>
                                            <input class="form-control" id="last_name" type="text" name="last_name"
                                                placeholder="Enter your last name"
                                                value="<?php echo htmlspecialchars($user['last_name']); ?>">
                                        </div>
                                    </div>
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="email">Email Address</label>
                                            <input class="form-control" id="email" type="text" name="email"
                                                placeholder="Enter your email address"
                                                value="<?php echo htmlspecialchars($user['email']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="contact_number">Contact Number</label>
                                            <input class="form-control" id="contact_number" type="number"
                                                name="contact_number" placeholder="Enter your contact number"
                                                value="<?php echo htmlspecialchars($user['contact_number']); ?>">
                                        </div>
                                    </div>
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="address">Address</label>
                                            <input class="form-control" id="address" type="text" name="address"
                                                placeholder="Enter your complete address"
                                                value="<?php echo htmlspecialchars($user['address']); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputBirthday">Birthday</label>
                                            <input class="form-control" id="inputBirthday" type="date" name="birthday"
                                                placeholder="Enter your birthday"
                                                value="<?php echo htmlspecialchars($user['birthday']); ?>">
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Save changes</button>
                                </form>
                            </div>
                        </div>
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