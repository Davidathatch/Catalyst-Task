<?php

    if(isset($_POST["newTaskTitle"])){
        $validateTitleSql = "SELECT * FROM taskslist WHERE taskTitle=\"" . $_POST["newTaskTitle"] . "\"";
        $validationResult = $conn->query($validateTitleSql);

        echo array_search("Misc", $completeCateList);
        if($_POST["newTaskTitle"] != substr(print_r($validationResult->fetch_assoc()["taskTitle"]), 0, -1)) {
            $postTitle = $_POST["newTaskTitle"];
            $postCategory = array_search($_POST["newTaskCategory"], $completeCateList);
            $addTaskSql = "INSERT INTO taskslist (taskTitle, taskCategory, isComplete) VALUES (\"" . $postTitle . "\", \"". $postCategory . "\", 0)";
            $conn->query($addTaskSql);
            header("Refresh:0");
        }
    }
//    unset($_POST)
?>
