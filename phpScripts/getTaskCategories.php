<?php
$getCateSql = "SELECT * FROM taskcategories";
$getCateResult = $conn->query($getCateSql);
$completeCateList = array();

while($row = $getCateResult->fetch_assoc()) {
    $completeCateList[$row["id"]] = $row["categoryName"];
}

$_SESSION["completeCateList"] = $completeCateList;
?>