<?php
include("logics/config.php");
include('logics/check_login.php');
include('logics/checkRole.php');
$user_data = check_login($pdo);

if (isAdmin()) {
    header('location: ../admin/index.php');
    die();
}



$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$sql = "SELECT id, question_text, choices FROM questions";
$stmt = $pdo->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


$query = "SELECT * FROM survey_responses WHERE user_id = ?";
$stmt1 = $pdo->prepare($query);
$stmt1->execute([$userID]);

$result1 = $stmt1->fetch();

if ($result1) {
    header('Location: failed.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($userID !== null) {
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'question_') !== false) {
                $questionId = str_replace('question_', '', $key);
                $selectedChoice = $value;

                $insertSql = "INSERT INTO survey_responses (user_id, question_id, selected_choice) VALUES (:user_id, :question_id, :selected_choice)";
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
                $insertStmt->bindParam(':question_id', $questionId, PDO::PARAM_INT);
                $insertStmt->bindParam(':selected_choice', $selectedChoice, PDO::PARAM_STR);
                $insertStmt->execute();
            }
        }
        header("Location: done.php");
        exit();
    } else {
        echo "User not logged in or invalid user ID.";
    }
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
            <?php
            if ($result) {
                ?>
                <h2>Survey Questions</h2>
                <form method="post">
                    <table>
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Choices</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($result as $row) {
                                $questionId = $row['id'];
                                $questionText = $row['question_text'];
                                $choices = explode(",", $row['choices']);

                                echo "<tr>";
                                echo "<td>$questionText</td>";
                                echo "<td>";

                                foreach ($choices as $choice) {
                                    echo "<label><input type='radio' required name='question_$questionId' value='$choice'>$choice</label><br>";
                                }

                                echo "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <label for="suggestions">Suggestions:</label>
                    <textarea name="suggestions" rows="5"></textarea>
                    <button type="submit" value="Submit">Submit</button>
                </form>

                <?php
            } else {
                echo "No questions found in the database.";
            }
            ?>

        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>