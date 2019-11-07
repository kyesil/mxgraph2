<?php 
define('PD', dirname(__FILE__).'/../');
define('KWWW',PD .'/../../../');

define('UF', PD.'/../R/pd/');
define('PDW', PD.'javascript/examples/grapheditor/www/');

define('KLIB', KWWW.'predixiWeb/app/library/');

require  KWWW.'predixiWeb/conf/_config.php';

include KLIB . 'dbH.php';
include KLIB . 'dbNodeH.php';
include KLIB . 'sessH.php';

sessH::start(TRUE);

// if (!isset($_SESSION['user']))
//     exit('notlogin');
// if ( $_SESSION['user']['uLevel']<1000 )
//     exit('notauth');
?>