<?php 
define('LIB', '../../../../../../../predixiWeb/app/library/');
require  '../../../../../../../predixiWeb/conf/_config.php';

include LIB . 'dbH.php';
include LIB . 'dbNodeH.php';
include LIB . 'sessH.php';

sessH::start(TRUE);
// if (!isset($_SESSION['user']))
//     exit('notlogin');
// if ( $_SESSION['user']['uLevel']<1000 )
//     exit('notauth');
?>