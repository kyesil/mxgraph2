<?php 
define('KWWW', '../../../../../../../');
define('LIB', KWWW.'predixiWeb/app/library/');
define('PD', KWWW.'StaticWeb/www/R/pd/');
require  KWWW.'predixiWeb/conf/_config.php';

include LIB . 'dbH.php';
include LIB . 'dbNodeH.php';
include LIB . 'sessH.php';

sessH::start(TRUE);
// if (!isset($_SESSION['user']))
//     exit('notlogin');
// if ( $_SESSION['user']['uLevel']<1000 )
//     exit('notauth');
?>