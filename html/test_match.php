<?php

$test = "~/info/test/test.zip";
define("test", "~/info/test/");
if (preg_match('#^'.test.'.*\.zip$#', $test)){
//if (preg_match("/test/", $test)){
  echo "ture";
}else{
  echo "false";
}

?>
