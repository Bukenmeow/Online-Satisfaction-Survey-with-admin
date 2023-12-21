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
    <link rel="stylesheet" href="css/email.css" class="style">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
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

                <div class="container pb-mail-template1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <nav class="navbar navbar-default pb-mail-navbar">
                                    <div class="container-fluid">
                                        <!-- Brand and toggle get grouped for better mobile display -->
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                                <span class="sr-only">Toggle navigation</span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                            <a class="navbar-brand text-black" id="brand" href="#">Hello, <u>
                                                    <?php echo $user_data['first_name'] . " " . $user_data['last_name']; ?>
                                                </u></a>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                            <div class="row">
                                <div class="col-md-2" id="column-resize">
                                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <button id="btn_email" class="btn btn-danger" data-toggle="modal"
                                            data-target="#myModal">
                                            New E-mail
                                        </button>
                                        <div id="treeview">
                                        </div>
                                    </div>
                                    <!-- /.navbar-collapse -->
                                </div>
                                <div class="col-md-10">
                                    <div class="row" id="row_style">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-4 col-md-4">
                                                        <p id="inbox_parag">INBOX</p>
                                                    </div>
                                                    <div class="col-xs-8 col-md-8">
                                                        <div class="input-group">
                                                            <input type="text" name="" placeholder="Seach...."
                                                                class="form-control">
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-primary" type="button"
                                                                    tabindex="-1">
                                                                    <span class="fa fa-question fa-2x"
                                                                        area-hidden="true"></span>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-9 col-md-10">
                                                        <div class="btn-group">
                                                            <a data-toggle="dropdown" href="#"
                                                                class="btn btn-warning btn-md" aria-expanded="false">All
                                                                <i class="fa fa-angle-down "></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#">None</a></li>
                                                                <li><a href="#">Read</a></li>
                                                                <li><a href="#">Unread</a></li>
                                                            </ul>
                                                            <a href="#" class="btn btn-warning">
                                                                <i class=" fa fa-refresh fa-lg"></i>
                                                            </a>
                                                        </div>
                                                        <div class="btn-group">
                                                            <a data-toggle="dropdown" href="#"
                                                                class="btn btn-warning btn-md"
                                                                aria-expanded="false">More
                                                                <i class="fa fa-angle-down "></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#">Mark all as read</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3 col-md-2">

                                                        <div class="btn-group pull-right">
                                                            <a data-toggle="dropdown" href="#" class="btn btn-primary"
                                                                aria-expanded="false">
                                                                <i class="fa fa-cog"></i>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li><a href="#">Comfortable</a></li>
                                                                <li><a href="#">Cozy</a></li>
                                                                <li><a href="#">Compact</a></li>
                                                                <hr>
                                                                <li><a href="#">Configure inbox</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div id="grid"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal view -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h5>New message</h5>
                                                </div>
                                                <div class="col-md-8">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <p>To: </p>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" name="search" placeholder="Enter e-mail"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <p>Subject: </p>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input type="text" name="search" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-3">
                                                        <p>Message: </p>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <textarea class="form-control" rows="10"></textarea>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary pull-left" id="btn_file">
                                                <span class="fa fa-paperclip fa-2x"></span>
                                                <input type="file" id="file" style="display: none;" />
                                            </button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Send</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End of modal -->

                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $("#treeview").shieldTreeView({
                            dataSource: dataSrc
                        });

                        $.ajax({
                            url: 'fInc.php',
                            method: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                $("#grid").shieldGrid({
                                    dataSource: {
                                        data: data
                                    },
                                    sorting: {
                                        multiple: true
                                    },
                                    paging: {
                                        pageSize: 12,
                                        pageLinksCount: 10
                                    },
                                    selection: {
                                        type: "row",
                                        multiple: true,
                                        toggle: false
                                    },
                                    columns: [
                                        { field: "name", title: "Name", width: "10em" },
                                        { field: "email", title: "Email", width: "10em" },
                                        { field: "message", title: "Message", width: "20em" },
                                        { field: "date_created", title: "Date Created", width: "6em" }
                                    ]
                                });
                            }
                        });
                    })
                </script>
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
    <link rel="stylesheet" type="text/css"
        href="http://www.shieldui.com/shared/components/latest/css/light-bootstrap/all.min.css" />
    <script type="text/javascript"
        src="http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"></script>
    <script type="text/javascript" src="http://www.prepbootstrap.com/Content/data/emailData.js"></script>
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