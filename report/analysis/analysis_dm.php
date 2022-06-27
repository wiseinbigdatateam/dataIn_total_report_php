<?php
include_once "../../inc/common.php";

$sql = "call DM_STEP01()";
mysqli_query($gconnet, $sql);

echo "call";
?>