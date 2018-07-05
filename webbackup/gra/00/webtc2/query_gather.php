<?php
// web/webtc2/query_gather.php
// Revised 06-29-2018
#include('../utilities/transcoder.php');
#require_once('../webtc/dal_sqlite.php');
if (isset($_GET['callback'])) {
 header('content-type: application/json; charset=utf-8');
 header("Access-Control-Allow-Origin: *");
}
$meta = '<meta charset="UTF-8">'; 
require_once('../webtc/dictcode.php');
require_once('../webtc/dal.php');
$dal = new Dal($dictcode);
echo "$meta\n";
if (isset($_POST['data'])) {
 $data = $_POST['data'];
 $data1 = preg_replace('/<\/key1>/','',$data);
 $keyar = preg_split('/<key1>/',$data1);
}else {
 $data = "";
 $keyar = array();
}
#$utilchoice = $_POST['utilchoice'];
#$filter0 = $_POST['filter'];
#$filter = transcoder_standardize_filter($filter0);
#echo count($keyar) . " keyar len\n";
$matches=array();
$nmatches=0;

foreach($keyar as $key) {
 #$results = dal_gra1($key);
 $results = $dal->get1($key,$dictcode);
 foreach($results as $line) {
  list($key1,$lnum1,$data2) = $line;
  $matches[$nmatches]=trim($data2);
  $nmatches++;
 }
 if (count($results) == 0) {
  $data1 = "<Hx><h><key1>$key1</key1></h><body>" .
		"no data for key1=$key1</body><tail></tail></Hx>";
  $matches[$nmatches]=trim($data1);
  $nmatches++;
 }
}
$table1 = join('\n',$matches);
print $table1;

exit;
?>