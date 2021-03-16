<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserDao.class.php";
require_once dirname(__FILE__)."/dao/GoalsDao.class.php";
$dao = new GoalsDao();

$goal = [
  "user_id"=>1,
  "goal" => "smrsati 5 kg",
  "status" => "ne znamo status",
  "recycled" => 0
];

$goal1 = $dao->add($goal);

print_r($goal1);
 ?>
