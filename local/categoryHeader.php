<?php
$alternatingColors = ['#889BA3', '#AABABC', '#CFCCC5'];
$colorCounter = 0;
foreach($completeCateList as $row) {
    ?>
<div class="category-container">
    <div class="category-heading" style="background: <?php echo $alternatingColors[$colorCounter] ?>">
        <div class="category-info-container">
            <h2 class="category-title"><?php echo $row ?></h2>
            <h3 class="category-amount">6 tasks</h3>
        </div>
        <img src="assets/Asset%202.svg" alt="dropdown arrow">
    </div>

</div>

<?php
if($colorCounter >= count($alternatingColors)-1){
    $colorCounter = 0;
}else {
    $colorCounter++;
}
} ?>

