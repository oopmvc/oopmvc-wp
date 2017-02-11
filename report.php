<?php  


 add_action('admin_menu', 'oopmvc_add_record_menu');


    function oopmvc_add_record_menu() {
	    add_submenu_page('edit.php?post_type=records', __('Report','menu-report'), __('Report','menu-report'), 'manage_options', 'reportpage', 'oopmvc_report_cb'); 

    }


    function oopmvc_report_cb() {

    		$fromdate = date('Y-m-d', strtotime( '-7 days' ) );
    		$todate   = date('Y-m-d');
    		$reportaction   = 'generatereport';

    	    if(isset($_POST['fromdate']) && isset($_POST['todate'])){
                $fromdate 			= $_POST['fromdate'];
    			$todate   			= $_POST['todate'];   
    			$reportaction   	= $_POST['reportaction']; 

    			if( $reportaction == 'generatereport'){ 
	    			$report_results = oopmvc_generate_report($fromdate, $todate, $reportaction);  
	    		}

    	    }


    		echo "<h2>" . __( 'Training Report', 'menu-report' ) . "</h2>"; ?>


    		<form id="" name="" action="edit.php?post_type=records&page=reportpage" method="post">
			    From Date:
			    <input type="text" id="fromdate" name="fromdate" value="<?php echo $fromdate;?>"/>
			    To Date: <input type="text" id="todate" name="todate" value="<?php echo $todate;?>"/>
			    <select name="reportaction">
			    	<option value="generatereport" <?php echo $reportaction == 'generatereport' ? 'selected' : '';?>> Make Report </option> 
			    	<option value="downloadreport" <?php echo $reportaction == 'downloadreport' ? 'selected' : '';?>> Download CSV Report </option> 
			    </select>
			    <input type="submit" value="Submit" name="submit"> 

			</form>
 
			<div id="reportresults"><?php 

			if( $reportaction == 'generatereport'){  
					echo $report_results;

			}else{ $filename = date('Y-m-d h:i:s').'_report.csv' ; ?>

			<script type="text/javascript">
                 jQuery(document).ready(function($) {
                 	    jQuery.ajax({ 
                 	   		method: "POST",
							url: '<?php echo admin_url( 'admin-ajax.php' );?>',
							data: {action: 'downloadreportcsv', fromdate: '<?php echo $fromdate;?>', todate: '<?php echo $todate;?>', reportaction : 'downloadreport'}
						})
						.done(function( response ) {
								var uri = 'data:text/csv;charset=UTF-8,' + encodeURIComponent(response);
								var downloadLink = document.createElement("a");
								downloadLink.href = uri;
								downloadLink.download = "<?php echo $filename;?>";
								document.body.appendChild(downloadLink);
							    downloadLink.click();
							    document.body.removeChild(downloadLink);  
						});



                 });		
			</script>

		<?php } ?></div> 
		    
			<script type="text/javascript">
			    jQuery(document).ready(function() {
			        jQuery('#fromdate').datepicker({
			            dateFormat : 'yy-mm-dd'
			        });

			        jQuery('#todate').datepicker({
			            dateFormat : 'yy-mm-dd'
			        });
			    });
			</script>  

		 


<?php  

}


add_action( 'wp_ajax_downloadreportcsv', 'prefix_downloadreportcsv' ); 
add_action( 'wp_ajax_nopriv_downloadreportcsv', 'prefix_downloadreportcsv' ); 
function prefix_downloadreportcsv() {
     
 
	$fromdate 			= isset($_POST['fromdate'] ) 		? $_POST['fromdate'] : date('Y-m-d', strtotime( '-7 days' ) );
	$todate   			= isset($_POST['todate'] ) 			? $_POST['todate'] : date('Y-m-d');   
	$reportaction   	= isset($_POST['reportaction'] ) 	? $_POST['reportaction'] : 'downloadreport'; 



    if( $reportaction == 'downloadreport'){ 
	    			$report_results = oopmvc_generate_report($fromdate, $todate, $reportaction);  
	    			echo $report_results;
 	}

    wp_die();
}


 
add_action( 'admin_enqueue_scripts', 'enqueue_date_picker' ); 
  
function enqueue_date_picker(){
        wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		 

}


 


function oopmvc_generate_report($fromdate, $todate , $reportaction =  'generatereport'){
	$args = array(
    				'post_type' => 'records',
				    'posts_per_page'   => '-1',
				    'orderby'   => 'post_date',
        			'order' => 'DESC',
				    'date_query' => array(
				        array(
				            'after'     => date('F jS, Y', strtotime($fromdate)),
				            'before'    => date('F jS, Y', strtotime($todate)),
				            'inclusive' => true,
				        ),
				    ),
				);
				$oop_query = new WP_Query( $args );  

				$report_results = ($reportaction == 'generatereport') ? '<table class="widefat fixed striped" cellspacing="0">
					    <thead>
					    <tr>
					            <th id="usernamecol" class="manage-column column-username" scope="col">User name</th>
					            <th id="emailcol" class="manage-column column-email" scope="col"> 	Emaiil Address</th> 
					            <th id="timecol" class="manage-column column-time" scope="col"> 	Date/Time </th> 
					            <th id="urlcol" class="manage-column column-url" scope="col"> 	Download PDF / Played Video </th> 
					            <th id="titlecol" class="manage-column column-title" scope="col"> 	Title </th> 

					    </tr>
					    </thead> 

					    <tbody id="the-list">' : "Username, loginid, UserEmail,View Time,Content_type,URL,Training Title\n";

					    $i=0;
 

								    while ( $oop_query->have_posts() ) : $oop_query->the_post();
												$post_id = $oop_query->post->ID;
								     			$user_id  		= get_post_meta( $post_id, 'user_id', true); 
								     			$user_info 		= get_userdata($user_id );

											    $userfullname = $user_info->first_name.' '. $user_info->last_name ;
											    $user_login = $user_info->user_login;
											    $username 		= $userfullname.'('.$user_login.')';
											    $useremail 		= $user_info->user_email;
											    
											    $view_time 		= get_post_meta( $post_id, 'date_time', true);  
											    $training_post_id 	= get_post_meta( $post_id, 'training_post_id', true);   

											    $training_post_edit_URL 	= get_edit_post_link($training_post_id); 

											    $content_type 	= get_post_meta( $post_id, 'content_type', true);  

											    if($content_type == 'Video'){ 
											    	$training_URL 	= get_post_meta( $training_post_id, 'video_file_url', true);    
											    }else if($content_type == 'PDF'){
													$attachmentID 	= get_post_meta( $training_post_id, 'training_doc_file', true);  
													$training_URL 	= wp_get_attachment_url( $attachmentID );  
											    }else{
											    	$training_URL 	= get_edit_post_link($training_post_id);  
											    }

											     

											    
											    $post_title     = get_the_title();




										if( $reportaction == 'generatereport'){  

											   
											    $trclass = ($i++ % 2 == 0) ? 'alternate' : '';


								        		$report_results .= '<tr class="'.$trclass.'">
					            						            <td class="column-columnname">'. $username.  '</td>
					            									<td class="column-columnname">'. $useremail . '</td>
					            									<td class="column-columnname">'. $view_time .'</td>
					            									<td class="column-columnname"> <a href="'.$training_URL.'" target="_blank"> '. $content_type. ' </a> </td>
					            									<td class="column-columnname"><a href="'.$training_post_edit_URL.'" target="_blank">'. $post_title.'</a></td>
					        										</tr>'; 
								    	}else{
					                         $report_results .=  $userfullname.",".$user_login.",".$useremail.",".$view_time.",".$content_type. ",". $training_URL.",".$post_title ."\n" ;
								    	}

								    endwhile;

								    $report_results .= ($reportaction == 'generatereport') ? '</tbody></table>' : '';

					                 

								    // Reset Post Data
								    wp_reset_postdata();

								    return $report_results;
} 