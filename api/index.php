<?php
require_once dirname(__FILE__)."/dao/UserDao.class.php";
require dirname(__FILE__). '/../vendor/autoload.php';
Flight::register('userDao', 'UserDao');
Flight::route('GET /users', function(){

  $user=Flight::userDao()->get_all(0,10);
  Flight::json($user);

});
Flight::route('GET /users/@id', function($id){

  $user=Flight::userDao()->get_by_id($id);
  Flight::json($user);


});
Flight::route("POST /users", function(){
  $request = Flight::request();
  $data = $request->data->getData();

  $user = Flight::userDao()->add($data);
  Flight::json($user);





  });


Flight::route("PUT /users/@id", function($id){
  $request = Flight::request();
  $data = $request->data->getData();

  Flight::userDao()->update($id,$data);
  $user = Flight::userDao()->get_by_id($id);




  Flight::json($user);

  });


  Flight::start();


 ?>
