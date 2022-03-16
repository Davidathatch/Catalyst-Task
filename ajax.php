<?php

    $servername = 'localhost';
    $username = 'phpAccess';
    $password = '1234';

    $conn = new mysqli($servername, $username, $password, 'tasks');

    require "phpScripts/getTaskCategories.php";

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

?>
