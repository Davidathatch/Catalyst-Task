<?php

    $servername = 'localhost';
    $username = 'phpAccess';
    $password = '1234';

    $conn = new mysqli($servername, $username, $password, 'tasks');

    require "phpScripts/getTaskCetegories.php";

    if($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['selectedTask'])) {
        echo $_POST['taskAction'];
        if ($_POST['taskAction'] === 'true') {
            $completeSQL = "UPDATE taskslist SET isComplete = 1 WHERE taskTitle = \"" . $_POST['selectedTask'] . "\";";
            $conn->query($completeSQL);

        }elseif($_POST['taskAction'] === 'false') {
            $completeSQL = "UPDATE taskslist SET isComplete = 0 WHERE taskTitle = \"" . $_POST['selectedTask'] . "\";";
            $conn->query($completeSQL);
        }
    }

    if (isset($_POST['taskNameAdd'])) {
        $_SESSION["newlyAddedTask"] = null;
        $validateTitleSql = "SELECT * FROM taskslist WHERE taskTitle=\"" . $_POST["taskNameAdd"] . "\"";
        $validationResult = $conn->query($validateTitleSql);

        $postTitle = $_POST["taskNameAdd"];
        $postCategory = array_search($_POST["taskCategoryAdd"], $completeCateList);
        $addTaskSql = "INSERT INTO taskslist (taskTitle, taskCategory, isComplete) VALUES (\"" . $postTitle . "\", \"". $postCategory . "\", 0)";
        $conn->query($addTaskSql);

        $_SESSION["newlyAddedTask"] = array(
            "taskName" => $postTitle,
            "taskCategory" => $postCategory,
        );
        echo $_POST['taskNameAdd'] . " " . $_POST['taskCategoryAdd'] . " " . $_POST['taskNotesAdd'];
    }

?>