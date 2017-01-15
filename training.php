<?php 
 

// function oopmvc_recordtraining_func($data){
      
//       $post   = get_post( $data['id'] );
       
//       if ( !is_user_logged_in() ) {
//         return new WP_Error( 'user_not_logged_in', 'You need to logged in to check Training', array( 'status' => 201 ) );
//       }

//       if ( empty( $posts ) ) {
//         return new WP_Error( 'post_not_found', 'Training not found', array( 'status' => 404 ) );
//       }

//       $response = new WP_REST_Response( $post );

//       // Add a custom status code
//       $response->set_status( 200 );
  
//       return $response;

// }
// add_action( 'rest_api_init', function () {
//   register_rest_route( 'oopmvc/v1', '/recordtraining/(?P<id>\d+)', array(
//     'methods' => 'GET',
//     'callback' => 'oopmvc_recordtraining_func',
//   ) );
// } );

 






function filter_training_json( $data, $post, $context ) {

	$extra_field = array(
		'training_document_type',
		'training_doc_file',
		'training_video'
		);
 
    foreach ($extra_field as $key ) {
         $value  = get_field($key, $post->ID)  ;	 
         $data->data[$key] = (!empty($value ) ) ? $value : '';
    }
	

    $taxonomies = wp_get_post_terms($post->ID, 'training_categories');
    $taxonomies_slug = array();
    foreach($taxonomies as $tax){ 
		$taxonomies_slug[] = $tax->slug;
    }

	 $data->data['taxonomy']  = implode($taxonomies_slug, ' ');
 
     

    return $data;
}
add_filter( 'rest_prepare_training', 'filter_training_json', 10, 3 );