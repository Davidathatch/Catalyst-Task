<?php
for($i=0; $i < sizeof($completedTasksList); $i++){
    ?>

    <div class="task-preview task-preview-complete">
        <div class="task-preview-body">
            <div class="preview-heading-container">
                <h3 class="task-preview-heading"><strong><?php echo $completedTasksList[$i]["taskTitle"] ?></strong></h3>
                <h4 class="task-preview-date"><i><?php echo $completedTasksList[$i]["taskDate"] ?></i></h4>
                <h5 class="task-preview-category"><i><?php echo $completeCateList[$completedTasksList[$i]["taskCategory"]] ?></i></h5>
            </div>
            <p class="task-preview-desc">Lorem ipsum blah blah stuff stuff... see more-></p>
        </div>
        <form action="home.php" method="post">
            <div class="task-preview-checkbox">
                <input type="checkbox" name="task-preview-input" class="task-preview-input" checked>
                <div class="custom-checkbox"></div>
            </div>
        </form>
    </div>

    <?php
}
?>
