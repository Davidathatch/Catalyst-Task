<?php

    $getCategoryTasks = "SELECT * FROM taskslist WHERE taskCategory=\"" . $selectedCategory . "\"";
    $getCategoryTasksResult = $conn->query($getCategoryTasks);
    $completeTasksList = [];
    $completedTasksList = [];

    while($row = $getCategoryTasksResult->fetch_assoc()) {

        if ($row["isComplete"] == 0) {
            $workingTask = array(
                "taskTitle" => $row["taskTitle"],
                "taskDate" => $row["taskDate"],
                "taskCategory" => $row["taskCategory"],
            );
            $completeTasksList[] = $workingTask;
        } else {
            $workingTask = array(
                "taskTitle" => $row["taskTitle"],
                "taskDate" => $row["taskDate"],
                "taskCategory" => $row["taskCategory"],
            );
            $completedTasksList[] = $workingTask;
        }
    }

    $getSelectionNameSql = "SELECT categoryName FROM taskcategories WHERE id=\"" . $selectedCategory . "\"";
    $getSelectionNameResult = $conn->query($getSelectionNameSql);
    $completeCateList = array();
    while($row = $getSelectionNameResult->fetch_assoc()) {
        $completeCateList[$selectedCategory] = $row["categoryName"];
    }

 ?>
