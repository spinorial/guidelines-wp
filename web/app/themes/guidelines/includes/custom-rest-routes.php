<?php  

/*
* Rest Route for filtering by title
* https://server-address/wp-json/guideline/filter/title=[TITLE|notitle]
*/


add_action( 'rest_api_init', 'register_title_routes' );

function register_title_routes() {
	register_rest_route( 'guideline', '/filter/title=(?P<title>[a-zA-Z0-9-]+)(?:/id=(?P<id>\d+))?', array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'serve_guideline_title_route',
	));
}

function serve_guideline_title_route( WP_REST_Request $request ) {

	$title = $request['title'];
	$id= $request['id'];

	$returnArray = array();

	if($title){

		if($title=="notitle"){

			$posts = get_posts(array(
				'posts_per_page'    => -1,
				'post_type'         => 'guideline',
				'meta_key'          => 'guideline_title',
				'orderby'           => 'meta_value',
				'order'             => 'ASC'
			));

			if($id){

				$posts = get_posts(array(
				'posts_per_page'    => -1,
				'post_type'         => 'guideline',
				'meta_key'          => 'guideline_title',
				'orderby'           => 'meta_value',
				'order'             => 'ASC',
				'author'			=> $id,
				'post_status' 		=> array('publish', 'pending', 'draft', 'auto-draft')

			));

			}

		}

		if($title!="notitle"){

			$posts = get_posts(array(
				'posts_per_page'    => -1,
				'post_type'         => 'guideline',
				'meta_key'          => 'guideline_title',
				'meta_value'        => $title

			));

		}


	}else{

		$posts = get_posts(array(
			'posts_per_page'    => -1,
			'post_type'         => 'guideline'
		));
	}



	foreach($posts as $post){
		$fields = get_fields($post->ID);
		// array_push($fields,['id'=>$post->ID]);
		$fields =  array_merge($fields, array('status'=>$post->post_status,'id'=>$post->ID,'modified'=>$post->post_modified_gmt,'author'=>$post->post_author));


		$field_title = $fields['guideline_title'];
		unset($fields['review_panel']);

		array_push($returnArray,$fields);

	}
	return $returnArray;

}



/*
* Rest Route for filtering by letter
* https://server-address/wp-json/guideline/filter/select=[LETTER]/(optional)id=[ID]
*/

add_action( 'rest_api_init', 'register_select_routes' );

//Select with letter and optional ID/

function register_select_routes() {
	register_rest_route( 'guideline', '/filter/select=(?P<select>[a-zA-Z]{1})(?:/id=(?P<id>\d+))?', array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'serve_guideline_select_route',
	));
}


function serve_guideline_select_route( WP_REST_Request $request ) {

	$select = $request['select'];
	$id = $request['id'];


	if($select){

		$returnArray = array();

		$posts = get_posts(array(
			'posts_per_page'    => -1,
			'post_type'         => 'guideline',
			'meta_key'          => 'guideline_title', 
			'orderby'           => 'meta_value',
			'order'             => 'ASC'

		));

		if($id){

		$posts = get_posts(array(
		'posts_per_page'    => -1,
		'post_type'         => 'guideline',
		'meta_key'          => 'guideline_title', 
		'orderby'           => 'meta_value',
		'order'             => 'ASC',
		'post_status' 		=> array('publish', 'pending', 'draft', 'auto-draft'),
		'author'			=> $id

	));

		}


		foreach($posts as $post){
			$fields = get_fields($post->ID);
			$field_title = $fields['guideline_title'];

//Hide review panel members from front end.
			unset($fields['review_panel']);
			$fields =  array_merge($fields, array('status'=>$post->post_status,'id'=>$post->ID,'modified'=>$post->post_modified_gmt,'author'=>$post->post_author));

			if(substr(strtolower($field_title), 0, 1) === strtolower($select)){

				array_push($returnArray,$fields);
			}
		}


	}else{

		return null;

	}

//Have to return as array in the api else react doesnt recognise it.

	return $returnArray;

}



/*
*  Rest Route for getting guidelines by lead_author 
*/ 

add_action('rest_api_init','get_guidelines_by_lead_author');

function get_guidelines_by_lead_author(){
	register_rest_route( 'guideline', '/author/firstname=(?P<firstname>[a-zA-Z0-9-]+)/surname=(?P<surname>[a-zA-Z0-9-]+)',array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'serve_guideline_by_lead_author',
	));
}

function serve_guideline_by_lead_author(WP_REST_Request $request){

//This returns post where the lead author is the firstname and surname in the request. 
//could rewrite this using acf meta field querying


	

	// field_5b295c91bb6c3 - firstname
	// field_5b295cb2bb6c4 - surnamee



	$firstname = strtolower(sanitize_text_field($request['firstname']));
	$surname = strtolower(sanitize_text_field($request['surname']));


	$returnArray = array();

	$posts = get_posts(array(
		'posts_per_page'    => -1,
		'post_type'         => 'guideline',
		'meta_key'          => 'guideline_title', 
		'orderby'           => 'meta_value',
		'order'             => 'ASC',
		'post_status' 		=> array('publish', 'pending', 'draft', 'auto-draft')

	));

	 

	foreach($posts as $post){

		if(have_rows('lead_author',$post->ID) ){

			$r = the_row();

			if(strtolower($r['field_5b295c91bb6c3']) == $firstname && strtolower($r['field_5b295cb2bb6c4'])==$surname){


				$fields = get_fields($post->ID);
				$fields =  array_merge($fields, array('status'=>$post->post_status,'id'=>$post->ID,'modified'=>$post->post_modified_gmt));

				array_push($returnArray,$fields);

			}

		}


	}

	return $returnArray;

}


//---------------------------------------//


/*
*  Rest Route for getting guidelines by author ID
*/ 

add_action('rest_api_init','get_guidelines_by_author_id');

function get_guidelines_by_author_id(){
	register_rest_route( 'guideline', '/author/id=(?P<id>[0-9]+)',array(
		'methods'  => WP_REST_Server::READABLE,
		'callback' => 'serve_guideline_by_author_id',
	));
}

function serve_guideline_by_author_id(WP_REST_Request $request){


	$id = strtolower(sanitize_text_field($request['id']));
	

	$returnArray = array();

	$posts = get_posts(array(
		'posts_per_page'    => -1,
		'post_type'         => 'guideline',
		'meta_key'          => 'guideline_title', 
		'orderby'           => 'meta_value',
		'order'             => 'ASC',
		'post_status' 		=> array('publish', 'pending', 'draft', 'auto-draft'),
		'author'			=> $id

	));

	 

	foreach($posts as $post){



			


				$fields = get_fields($post->ID);
				$fields =  array_merge($fields, array('status'=>$post->post_status,'id'=>$post->ID,'modified'=>$post->post_modified_gmt));

				array_push($returnArray,$fields);

			

		}


	

	return $returnArray;

}





