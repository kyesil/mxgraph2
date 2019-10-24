<?php 
require  '_boot.php';

$file_handle = fopen(KWWW.'StaticWeb/www/R/pd/newfile.svg', 'w');
fwrite($file_handle, urldecode($_POST["xml"]));
fclose($file_handle);

