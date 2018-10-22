<?php


/*
* Adds an authentiation rest route which receives data and sends back a respnse with an authorisatoin
* token
* https://Sever-address/wp-json/login/auth
*/

add_action( 'rest_api_init', 'register_authentication_routes' );

function register_authentication_routes() {
  register_rest_route( 'login', '/auth/', array(
    'methods'  => 'POST',
     'callback' => 'serve_auth_route',
  ));
}

function serve_auth_route( WP_REST_Request $request ) {

    foreach($request as $r => $value){
    $request[$r] = sanitize_text_field($value);
}
 

$params = $request->get_params();
$username = $request['username'];
$password = $request['password'];

$user = get_user_by('login',$username);

$response = array(
    'data'      => array(),
    'msg'       => 'Invalid username or password',
    'status'    => false
);

if( $user ){
        $password_check = wp_check_password($password, $user->user_pass, $user->ID );
    
        if ( $password_check ){
            /* Generate a unique auth token */
            $token = generateRandomString( 40 );
 
            /* Store / Update auth token in the database */
            if( update_user_meta( $user->ID, 'auth_token', $token ) ){
                
                /* Return generated token and user ID*/
                $response['status'] = true;
                $response['data'] = array(
                    'auth_token'    =>  $token,
                    'user_id'       =>  $user->ID,
                    'user_login'    =>  $user->user_login,
                    'user_roles'    => $user->roles
                );
                $response['msg'] = 'Successfully Authenticated';
            }
        }
    }


return $response;


}

//Generates a random string for authentication.

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

