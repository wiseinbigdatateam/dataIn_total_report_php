<?php
include_once "../../inc/common.php";

$memid = "dev";

if($memid != "" && $idx != "") {

    $output = shell_exec('/home/ubuntu/dataIn/report/analysis/make_ahp_model_image.sh '.$memid.' '.$idx);
    echo "<pre>out => $output</pre>";
    echo "<br>";


$output=null;
$retval=null;
//exec("conda activate datainpy");
//exec("python /home/ubuntu/dataIn/report/pythonProg/graph/html2img.py ".$memid." ".$idx."");

//exec('sudo conda activate datainpy', $output, $retval);
exec("/home/ubuntu/dataIn/report/analysis/make_ahp_model_image.sh ".$memid." ".$idx, $output, $retval);

//exec('/home/ubuntu/dataIn/report/analysis/make_ahp_model_image.sh dev 238', $output, $retval);
echo "Returned with status $retval and output:\n";
print_r($output);
echo "<br>";

echo "<br>==================================================================<br><br>";

$exec_code = 'conda activate datainpy';
exec($exec_code, $output, $retval);

echo $exec_code."<br>";
echo "Returned with status $retval and output:\n";
print_r($output);
echo "<br>";

echo "<br>==================================================================<br><br>";

$exec_code = "python /home/ubuntu/dataIn/report/pythonProg/graph/html2img.py ".$memid." ".$idx;
exec($exec_code, $output, $retval);

echo $exec_code."<br>";
echo "Returned with status $retval and output:\n";
print_r($output);
echo "<br>";

echo "<br>==================================================================<br><br>";

/*
    exec("conda activate datainpy");
    exec("python /home/ubuntu/dataIn/report/pythonProg/graph/html2img.py ".$memid." ".$idx."");
*/
    echo "python /home/ubuntu/dataIn/report/pythonProg/graph/html2img.py ".$memid." ".$idx."";

    echo "<br>";

    echo $memid." - ".$idx;

    echo "<br>";

    echo "<img src='/report/pythonProg/AHPModelImg/".$memid."_".$idx.".png'><br>";

}
?>
dev_59<br>
<img src='https://dataintotalreporting.s3.us-east-2.amazonaws.com/AHPModelImg/dev_59.png'>
<br>

kky_422<br>
<img src="https://dataintotalreporting.s3.us-east-2.amazonaws.com/AHPModelImg/kky_422.png">
<br>

sangmi_200<br>
<img src="https://dataintotalreporting.s3.us-east-2.amazonaws.com/AHPModelImg/sangmi_200.png">
<br>

<?=$memid?>_<?=$idx?><br>
<img src="https://dataintotalreporting.s3.us-east-2.amazonaws.com/AHPModelImg/<?=$memid?>_<?=$idx?>.png">