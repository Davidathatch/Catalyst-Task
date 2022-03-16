<?php
echo $_SESSION["newlyAddedTask"]["taskTitle"];
for($i=0; $i < sizeof($completeTasksList); $i++){
?>

<div class="task-preview">
    <div class="task-preview-body">
        <div class="preview-heading-container">
            <h3 class="task-preview-heading"><strong><?php echo $completeTasksList[$i]["taskTitle"] ?></strong></h3>
            <h4 class="task-preview-date"><i><?php echo $completeTasksList[$i]["taskDate"] ?></i></h4>
            <h5 class="task-preview-category"><i><?php echo $completeCateList[$completeTasksList[$i]["taskCategory"]] ?></i></h5>
        </div>
        <p class="task-preview-desc">Lorem ipsum blah blah stuff stuff... see more-></p>
    </div>
    <form action="../home.php" method="post">
        <div class="task-preview-checkbox">
            <input type="checkbox" name="task-preview-input" class="task-preview-input">
            <div class="custom-checkbox"></div>
        </div>
    </form>
</div>

<?php
}

if(isset($_SESSION["newlyAddedTask"])) { ?>

    <div class="task-preview">
        <div class="task-preview-body">
            <div class="preview-heading-container">
                <h3 class="task-preview-heading"><strong><?php echo $_SESSION["newlyAddedTask"]["taskTitle"] ?></strong></h3>
                <h4 class="task-preview-date"><i><?php echo "one sec" ?></i></h4>
                <h5 class="task-preview-category"><i><?php echo $_SESSION["newlyAddedTask"]["taskCategory"] ?></i></h5>
            </div>
            <p class="task-preview-desc">Lorem ipsum blah blah stuff stuff... see more-></p>
        </div>
        <form action="../home.php" method="post">
            <div class="task-preview-checkbox">
                <input type="checkbox" name="task-preview-input" class="task-preview-input">
                <div class="custom-checkbox"></div>
            </div>
        </form>
    </div>

<?php } ?>
