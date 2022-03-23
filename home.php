<?php

    session_start();

//    if (isset($_SESSION["newlyAddedTask"])) {
//        $testVar = $_SESSION["newlyAddedTask"];
//    }

//Connect to MySql database
    $servername = 'localhost';
    $username = 'phpAccess';
    $password = '1234';

    $conn = new mysqli($servername, $username, $password, 'tasks');

    $filteredState = false;
    $includeCloseIcon = false;

    //Retrive all tasks from database
    include "phpScripts/getTaskList.php";
    //Retrive all categories from database
    include "phpScripts/getTaskCategories.php";
    //Add any new tasks to database on POST
    include "phpScripts/addTask.php";

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    //If a category is selected, edit the list of tasks to render on page
    if ($_COOKIE["categorySearch"] !== "null") {
        $selectedCategory = $_COOKIE["categorySearch"];
        include "phpScripts/filterTasks.php";
        $filteredState = true;
        $includeCloseIcon = true;
       }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Layout</title>

    <link rel="stylesheet" href="styles.css">

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

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
                <div class="close-icon hidden">
                    <img src="assets/close-icon.svg" alt="close-icon" style="width: 75px">
                </div>
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