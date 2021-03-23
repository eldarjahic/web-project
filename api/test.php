<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/GoalsDao.class.php";
$dao = new UserDao();




$goal1 = $dao->get_all($_GET["offset"], $_GET["limit"]);
echo json_encode($goal1, JSON_PRETTY_PRINT);



 ?>
