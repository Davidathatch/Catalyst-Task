<?php

    $servername = 'localhost';
    $username = 'phpAccess';
    $password = '1234';

    $conn = new mysqli($servername, $username, $password, 'tasks');

    $filteredState = false;

    include "phpScripts/getTaskList.php";
    include "phpScripts/getTaskCetegories.php";
    include "phpScripts/addTask.php";

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


    if ($_COOKIE["categorySearch"] !== "null") {
        $selectedCategory = $_COOKIE["categorySearch"];
        include "phpScripts/filterTasks.php";
        $filteredState = true;
    }

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

<?php include "local/taskCompose.php" ?>

<div class="flexColumn">
    <header <?php if($filteredState == true) { ?>class="filter-shrink"<?php } ?>>
        <div class="categories-container">
            <div class="category">
                <?php include "local/categoryHeader.php" ?>
            </div>
            <div class="category-gradient" <?php if ($filteredState == true) { ?> style="display: none" <?php } ?>></div>
        </div>
    </header>
    <div class="task-previews <?php if ($filteredState == true) {?> filter-grow <?php } ?>">
        <div class="task-preview-container" style="width: 90vw; <?php if ($filteredState == true) {?>height: 100%;<?php }?>">
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