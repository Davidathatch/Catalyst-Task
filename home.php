<?php

    $servername = 'localhost';
    $username = 'phpAccess';
    $password = '1234';

    $conn = new mysqli($servername, $username, $password, 'tasks');

    echo print_r($_COOKIE);

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_COOKIE["check"])) {
        $completeSQL = "UPDATE taskslist SET isComplete = 1 WHERE taskTitle = \"" . $_COOKIE["check"] . "\";";
        $conn->query($completeSQL);
    }
    if (isset($_COOKIE["uncheck"])) {
        $incompleteSQL = "UPDATE taskslist SET isComplete = 0 WHERE taskTitle = \"" . $_COOKIE["uncheck"] . "\";";
        $conn->query($incompleteSQL);
    }
    if (isset($_COOKIE["categorySearch"])) {
        echo $_COOKIE["categorySearch"];
    }

    include "phpScripts/getTaskList.php";

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    include "phpScripts/getTaskCetegories.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Layout</title>

    <link rel="stylesheet" href="styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&display=swap" rel="stylesheet">
</head>
<body>
<div class="flexColumn">
    <header>
        <div class="categories-container">
            <div class="category">
                <?php include "local/categoryHeader.php" ?>
            </div>
            <div class="category-gradient"></div>
        </div>
    </header>
    <div class="task-previews">
        <div class="task-preview-container" style="height: 55vh; width: 90vw">
                <?php include "local/taskPreview.php" ?>
                <?php include "local/completeTaskPreview.php" ?>
        </div>
    </div>

</div>

<div class="quick-add-button" style="background: #566373">
    <div class="center" style="height: 100%">
        <img src="assets/yuhAsset%202.svg" alt="plus">
    </div>
</div>

<script src="app.js">
</script>

</body>
</html>