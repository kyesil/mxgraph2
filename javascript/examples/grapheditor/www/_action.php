<?php 
require  '../../../../_SCREEN/_boot.php';

$file_handle = fopen(UF.escapeshellcmd('screen.xml'), 'w');
fwrite($file_handle, urldecode($_POST["xml"]));
fclose($file_handle);

$file_handle = fopen(UF.escapeshellcmd('screen.svg'), 'w');
fwrite($file_handle, urldecode($_POST["svg"]));
fclose($file_handle);

var_dump($_POST);

