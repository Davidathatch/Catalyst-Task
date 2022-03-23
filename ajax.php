<?php

    //Connect to MySQL server
    $servername = 'localhost';
    $username = 'phpAccess';
    $password = '1234';

    $conn = new mysqli($servername, $username, $password, 'tasks');

    //Included list of all task categories: "$completeCateList";
    require "phpScripts/getTaskCategories.php";

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //When task preview checkbox is clicked, update the task in the database
    if (isset($_POST['selectedTask'])) {
        echo $_POST['selectedTask'];
        if ($_POST['taskAction'] === 'true') {
            $completeSQL = "UPDATE taskslist SET isComplete = 1 WHERE taskTitle = \"" . $_POST['selectedTask'] . "\";";
            $conn->query($completeSQL);

        }elseif($_POST['taskAction'] === 'false') {
            $completeSQL = "UPDATE taskslist SET isComplete = 0 WHERE taskTitle = \"" . $_POST['selectedTask'] . "\";";
            $conn->query($completeSQL);
        }
    }

    //When new task is submitted, update in database and return info about task in JSON format
    if (isset($_POST['taskNameAdd'])) {
        session_start();
        $validateTitleSql = "SELECT * FROM taskslist WHERE taskTitle=\"" . $_POST["taskNameAdd"] . "\"";
        $validationResult = $conn->query($validateTitleSql);
        $postTitle = $_POST["taskNameAdd"];
        $postCategory = array_search($_POST["taskCategoryAdd"], $_SESSION["completeCateList"]);
        $addTaskSql = "INSERT INTO taskslist (taskTitle, taskCategory, isComplete) VALUES (\"" . $postTitle . "\", \"". $postCategory . "\", 0)";
        if (!$conn->query($addTaskSql)) {
            echo "Error: " . $conn->error;
        }else {
            echo json_encode(
                array(
                    'postTitle' => $postTitle,
                    'postCategory' => $_SESSION["completeCateList"][$postCategory],
                )
            );
        }
    }

    if (isset($_POST["filterCategory"])) {
        $categoryKey = array_search($_POST["filterCategory"] ,$_SESSION["completeCateList"]);
        $getCategoryTasks = "SELECT * FROM taskslist WHERE taskCategory=\"" . $categoryKey . "\";";
        $getCategoryTasksResult = $conn->query($getCategoryTasks);
        $filteredTaskList = array();

        while ($row = $getCategoryTasksResult->fetch_assoc()) {
            $taskMetaArray = array(
                "taskTitle" => $row["taskTitle"],
                "taskCategory" => $_POST["filterCategory"],
                "taskDate" => $row["taskDate"],
                "isComplete" => $row["isComplete"]
            );
            $filteredTaskList[] = $taskMetaArray;
        }
        echo json_encode($filteredTaskList);
    }

    if (isset($_POST["resetFeed"])) {
        $categoryListSql = "SELECT * FROM categorylist";
    }

?>
