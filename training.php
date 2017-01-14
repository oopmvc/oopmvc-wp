<?php 
 

function oopmvc_customposts_func($data){
  return var_export($data);
}


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
	

    $taxonomies = wp_get_post_terms($post->ID, 'categoriestraining');
    $taxonomies_slug = array();
    foreach($taxonomies as $tax){
		$taxonomies_slug[] = $tax->slug;
    }

	$data->data['taxonomy']  = implode($taxonomies_slug, ' ');
 
    
 

    return $data;
}
add_filter( 'rest_prepare_training', 'filter_training_json', 10, 3 );