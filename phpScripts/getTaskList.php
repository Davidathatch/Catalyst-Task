<?php
//GETS ALL TASKS THAT ARE INCOMPLETE AND ADDS THEM TO READABLE ARRAY (completeTasksList)
$getTasksSql = "SELECT * FROM taskslist WHERE isComplete=0";
$getTasksResult = $conn->query($getTasksSql);
$completeTasksList = [];

while($row = $getTasksResult->fetch_assoc()) {
    $workingTask = array(
        "taskTitle" => $row["taskTitle"],
        "taskDate" => $row["taskDate"],
        "taskCategory" => $row["taskCategory"],
    );
    $completeTasksList[] = $workingTask;
}

//GETS ALL TASKS THAT ARE COMPLETE AND ADDS THEM TO READABLE ARRAY (completedTasksList)
$getCompletedTasksSql = "SELECT * FROM taskslist WHERE isComplete=1";
$getCompletedTasksResult = $conn->query($getCompletedTasksSql);
$completedTasksList = [];

while($row = $getCompletedTasksResult->fetch_assoc()) {
    $workingTask = array(
        "taskTitle" => $row["taskTitle"],
        "taskDate" => $row["taskDate"],
        "taskCategory" => $row["taskCategory"],
    );
    $completedTasksList[] = $workingTask;
}
?>
