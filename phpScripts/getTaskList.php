<?php
//RETRIEVES AND SORTS ALL TASKS ACCORDING TO COMPLETION STATUS
$getTasksSql = "SELECT * FROM taskslist";
$getTasksResult = $conn->query($getTasksSql);
$completeTasksList = [];
$completedTasksList = [];

while($row = $getTasksResult->fetch_assoc()) {
    if ($row["isComplete"] == 0) {
        $workingTask = array(
            "taskTitle" => $row["taskTitle"],
            "taskDate" => $row["taskDate"],
            "taskCategory" => $row["taskCategory"],
        );
        $completeTasksList[] = $workingTask;
    }else {
        $workingTask = array(
            "taskTitle" => $row["taskTitle"],
            "taskDate" => $row["taskDate"],
            "taskCategory" => $row["taskCategory"],
        );
        $completedTasksList[] = $workingTask;
    }

}
$_SESSION["completeTasksList"] = $completeTasksList;
$_SESSION["completedTasksList"] = $completedTasksList;

