<?php

require_once(__DIR__.'/includes/guideline-functions.php');
require_once(__DIR__.'/includes/custom-rest-routes.php');
require_once(__DIR__.'/includes/authentication-rest-route.php');




add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}






add_action('init', 'create_tracker_post_type');
function create_tracker_post_type()
{
    register_post_type('tracker',
        array(
            'labels' => array(
                'name' => __('Trackers'),
                'singular_name' => __('tracker')
            ),
            'public' => true,
            'map_meta_cap' => true,
            'description' => 'Tracker post to manage guidelines',
            'menu_position' => 1,
            'menu_icon' => 'dashicons-media-document',
            'show_in_rest' => false,
            'supports' => [
                'title',
                'revisions'
            ],
            'hierarchical' => false,
            'has_archive' => false,
            'rewrite' => array( 'slug' => 'tracker')
        )
    );
}





// -------------------------- //

add_action( 'rest_api_init', 'register_select_routes_and_author' );

function register_select_routes_and_author() {
  register_rest_route( 'guideline', '/filter/select=(?P<select>[a-zA-Z]{1})/authorid=(?P<authorid>[a-z0-9]+)', array(
     'methods'  => WP_REST_Server::READABLE,
     'callback' => 'serve_guideline_select_route_and_author',
  ));
}

function serve_guideline_select_route_and_author( WP_REST_Request $request ) {

$select = $request['select'];
$authorid = $request['authorid'];


if($select && $authorid){

    $returnArray = array();

     $posts = get_posts(array(
    'author'            => $authorid,
    'posts_per_page'    => -1,
    'post_type'         => 'guideline',
    'meta_key'          => 'guideline_title', 
    'orderby'           => 'meta_value',
    'order'             => 'ASC'
    
    ));


    foreach($posts as $post){
    $fields = get_fields($post->ID);
    $field_title = $fields['guideline_title'];

    //Hide review panel members from front end.
    unset($fields['review_panel']);

    if(substr(strtolower($field_title), 0, 1) === strtolower($select)){
                // echo json_encode($fields);

                array_push($returnArray,$fields);
            }
    }


    }else{

    return null;

    }

    //Have to return as array in the api else react doesnt recognise it.

    return $returnArray;

}


// ------------------------------------------------------------------------------------------ //



function newGuidelineAutomation(){
    $output = 'This is done when a new post is created';
  
    $my_post = array(
    'post_title'    => 'Automated Post',
    'post_content'  => 'This was created Automatically',
    'post_status'   => 'publish',
    'post_author'   => 1,
    'post_type'     => 'post'
    );
// Insert the post into the database
wp_insert_post( $my_post );
}
add_action( 'new_post_guideline', 'newGuidelineAutomation' );



//----------- EMAIL --------------------//

function emailTest(){
 $to = "joseph.h.marshall@gmail.com";
$subject = "Test Email";
$message = "This is a test email";
$headers = array(
    "From: Joseph Marshall <joseph.marshall1@nhs.net>;",
    "BCC: Blind Carbon Copy <myothername@example.com>;",
);

wp_mail( $to, $subject, $message); 
}

// add_action('init','emailTest');




?>