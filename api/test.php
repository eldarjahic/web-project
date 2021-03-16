<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once dirname(__FILE__)."/dao/UserDao.class.php";

$dao = new UserDao();

$user = [
  "username"=>"eldar",
  "password"=>"12345678",
  "profile_pic"=>"admalaf",
  "email"=>"eldar1234@gmail.com"
];

$user1 = $dao->add($user);
 ?>
