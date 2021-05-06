<?php
/**
 * @OA\Info(title="Notepad", version="0.1")
 * @OA\OpenApi(
 *   @OA\Server(url="http://localhost/project/api/", description="Development Enviroment")
 * ),
 * @OA\SecurityScheme(securityScheme="ApiKeyAuth",type="apiKey",in="header",name="Authentication")
 */


/**
 * @OA\Get(path="/user",security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="query", name="offset", default=0, description="Offset for pagination"),
 *     @OA\Parameter(@OA\Schema(type="integer"), in="query", name="limit", default=25, description="Limit for pagination"),
 *     @OA\Parameter(@OA\Schema(type="string"), in="query", name="search", description="Search string for users. Case insensitive search"),
 *     @OA\Parameter(@OA\Schema(type="string"), in="query", name="order", default="-id", description="Sorting for return elements. -columne_name ascending order by columne_name, +columne_name descending order by columne_name"),
 *     @OA\Response(response="200", description="List users from database")
 * )
 */
Flight::route('GET /user', function(){
    $offset = Flight::query("offset",0);
    $limit = Flight::query("limit",10);
    $search = Flight::query('search');
    $order = Flight::query('order','-id');
    Flight::json(Flight::userService()->get_users($search, $offset, $limit, $order));
});

/**
 * @OA\Get(path="/user/{id}",security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(type="integer", in="path", allowReserved=true, name="id", default=1, description="id of user"),
 *     @OA\Response(response="200", description="Get user by id")
 * )
 */
Flight::route('GET /user/@id', function($id){
    Flight::json(Flight::userService()->get_by_id($id));
});


/**
 * @OA\Post(path="/register",
 * @OA\RequestBody(description="Basic user info", required=true,
 *    @OA\MediaType(
 *      mediaType="application/json",
 *      @OA\Schema(
 *        @OA\Property(property="username", type="string", example="My test user", desctiption="username of the user"),
 *        @OA\Property(property="email", type="string", example="username@gmail.com", desctiption="Users email"),
 *        @OA\Property(property="password", type="string", example="userspass", desctiption="Users password"),
 *        @OA\Property(property="profile_pic", type="string", example="blaa", desctiption="profile picture of the user")
 *      )
 *    )
 *   ),
 * @OA\Response(response="200", description="User that has been added to the database")
 * )
 */
Flight::route('POST /register', function(){
    $data = Flight::request()->data->getData();
    Flight::userService()->register($data);
    Flight::json(["message" => "Confirmaiton email has been sent. Please confirm your account."]);
});

/**
 * @OA\Put(path="/user/{id}",security={{"ApiKeyAuth": {}}},
 *     @OA\Parameter(@OA\Schema(type="integer"), in="path", name="id", default=1),
 *       @OA\RequestBody(description="Basic user info that is going to be updated", required=true,
 *         @OA\MediaType(
 *           mediaType="application/json",
 *           @OA\Schema(
 *             @OA\Property(property="password", type="string", example="userspass", desctiption="Users password"),
 *             @OA\Property(property="profile_pic", type="string", example="blaa", desctiption="Profile picture of the user")
 *           )
 *         )
 *        ),
 *     @OA\Response(response="200", description="Update user based on id")
 * )
 */
Flight::route('PUT /user/@id', function($id){
  $data = Flight::request()->data->getData();
  Flight::json(Flight::userService()->update($id,$data));
});


/**
 * @OA\Get(path="/confirm/{token}",
 *     @OA\Parameter(@OA\Schema(type="string"), in="path", name="token", description="token of a user"),
 *     @OA\Response(response="200", description="Message that is displayed to the user")
 * )
 */

Flight::route('GET /confirm/@token', function($token){
  Flight::json(Flight::userService()->confirm($token));
});

/**
 * @OA\Post(path="/login",
 * @OA\RequestBody(description="User email and password", required=true,
 *    @OA\MediaType(
 *      mediaType="application/json",
 *      @OA\Schema(
 *        @OA\Property(property="email", type="string", example="username@gmail.com", description="Users email"),
 *        @OA\Property(property="password", type="string", example="userspass", description="Users password")
 *      )
 *    )
 *   ),
 * @OA\Response(response="200", description="User that has been loged in")
 * )
 */
Flight::route('POST /login', function(){
    Flight::json(Flight::userService()->login(Flight::request()->data->getData()));
});

/**
 * @OA\Post(path="/forgot", description="Send recovery URL to users email address",
 * @OA\RequestBody(description="Basic user info", required=true,
 *    @OA\MediaType(
 *      mediaType="application/json",
 *      @OA\Schema(
 *        @OA\Property(property="email", type="string", required="true", example="username@gmail.com", description="Users email")
 *      )
 *    )
 *   ),
 * @OA\Response(response="200", description="Message that recovery link has been set")
 * )
 */
Flight::route('POST /forgot', function(){
    $data = Flight::request()->data->getData();
    Flight::userService()->forgot($data);
    Flight::json(["message"=>"Recovery link has been sent to your email."]);
});

/**
 * @OA\Post(path="/reset", description="Reset user password using recovery token",
 * @OA\RequestBody(description="Basic user info", required=true,
 *    @OA\MediaType(
 *      mediaType="application/json",
 *      @OA\Schema(
 *        @OA\Property(property="token", type="string", required="true", example="ast56sdoafj97aodf", description="Recovery token"),
 *        @OA\Property(property="password", type="string", required="true", example="userpassword", description="New password")
 *      )
 *    )
 *   ),
 * @OA\Response(response="200", description="Message that has reset his password")
 * )
 */
Flight::route('POST /reset', function(){
    Flight::json(Flight::userService()->reset(Flight::request()->data->getData()));
});


 ?>
