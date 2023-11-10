<?php

add_action( 'after_setup_theme', 'tm_support' );
function tm_support()
{
	add_theme_support( 'menus' );
}
function tm_assets() {
	wp_enqueue_style('main_stylesheet', get_template_directory_uri() . '/style.css', array(), rand(), 'all');

	// Dequeuing default jquery because I suspect it's the slim version (not what i need)
	wp_dequeue_script('jquery');
	wp_deregister_script('jquery');
	// regular compressed production build
	wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.7.1.min.js', array(), '3.7.1' );
}
add_action('wp_enqueue_scripts', 'tm_assets');
function tm_ajax_url() {
	?>
	<script type="text/javascript">
		var ajax_url = "<?= admin_url('admin-ajax.php'); ?>";
	</script>
	<?php
}

add_action('wp_footer', 'tm_ajax_url');

add_action('template_redirect', 'tm_check_user_ip');
function tm_check_user_ip()
{
	$ip_address = $_SERVER['REMOTE_ADDR'];
	$redirect_to = 'https://ikonicsolution.com/';
	if(strpos($ip_address, '77.29') === 0){
		/**
		 * TIP:
		 * we CANNOT use equality operator (==) above, intead we use identity operator (===) to get desired result
		 * strpos returns boolean FALSE in case it doesn't find the text, and returns integer 0 when it finds it
		 * in the start of the string. Hence it's important to use === so it returns false on (false === 0)
		 * */
		
		return wp_redirect($redirect_to);
		wp_exit();
	}
}
add_action( 'after_setup_theme', 'tm_ikonic_setup' );
function tm_ikonic_setup()
{
	register_nav_menus(
		array(
			'tm_main' => esc_html__( 'Main Menu', 'tm_main' ),
		)
	);
}
add_action('init', 'tm_custom_posts_and_taxonomies');
function tm_custom_posts_and_taxonomies()
{
	/**
	 * NOTE:
	 * 		The $labels variable was written by the help of ChatGPT to avoid redundant repetition. Since it was
	 * 		all repetitive work, nothing skill related so thought it should be fine. The prompt given was:
	 * 
	 * 			"create an extensive list of labels for a wordpress custom post type with slug 'project'."
	 * 
	 * 		This was the only place (other than taxonomy labels) where ChatGPT's help was used. For references,
	 * 		I have visited official documentations, not even stackoverflow.
	 * 		
	 * 		I wrote this to clearify that I often use ChatGPT to help me automate lots of repetitive work.
	 * 		Like following a simple html structure or creating realistic dummy data (names, descriptions, 
	 * 		etc especially for client demos).
	 * 
	 * */
	$labels = array(
		'name'                  => _x( 'Projects', 'Post type general name', 'tm_ikonic' ),
		'singular_name'         => _x( 'Project', 'Post type singular name', 'tm_ikonic' ),
		'add_new'               => _x( 'Add New Project', 'tm_ikonic' ),
		'add_new_item'          => __( 'Add New Project', 'tm_ikonic' ),
		'edit_item'             => __( 'Edit Project', 'tm_ikonic' ),
		'new_item'              => __( 'New Project', 'tm_ikonic' ),
		'view_item'             => __( 'View Project', 'tm_ikonic' ),
		'view_items'            => __( 'View Projects', 'tm_ikonic' ),
		'search_items'          => __( 'Search Projects', 'tm_ikonic' ),
		'not_found'             => __( 'No projects found', 'tm_ikonic' ),
		'not_found_in_trash'    => __( 'No projects found in Trash', 'tm_ikonic' ),
		'parent_item_colon'     => __( 'Parent Project:', 'tm_ikonic' ),
		'all_items'             => __( 'All Projects', 'tm_ikonic' ),
		'archives'              => __( 'Project Archives', 'tm_ikonic' ),
		'attributes'            => __( 'Project Attributes', 'tm_ikonic' ),
		'insert_into_item'      => __( 'Insert into project', 'tm_ikonic' ),
		'uploaded_to_this_item' => __( 'Uploaded to this project', 'tm_ikonic' ),
		'featured_image'        => __( 'Project Featured Image', 'tm_ikonic' ),
		'set_featured_image'    => __( 'Set featured image', 'tm_ikonic' ),
		'remove_featured_image' => __( 'Remove featured image', 'tm_ikonic' ),
		'use_featured_image'    => __( 'Use as featured image', 'tm_ikonic' ),
		'menu_name'             => _x( 'Projects', 'Admin Menu text', 'tm_ikonic' ),
		'filter_items_list'     => __( 'Filter projects list', 'tm_ikonic' ),
		'items_list_navigation' => __( 'Projects list navigation', 'tm_ikonic' ),
		'items_list'            => __( 'Projects list', 'tm_ikonic' ),
	);
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'project' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author' ),
		'taxonomies'         => array( 'project_type' ),
	);

	register_post_type('project', $args);

	// Registering Tax
	$labels = array(
		'name'                       => _x( 'Project Types', 'taxonomy general name', 'tm_ikonic' ),
		'singular_name'              => _x( 'Project Type', 'taxonomy singular name', 'tm_ikonic' ),
		'search_items'               => __( 'Search Project Types', 'tm_ikonic' ),
		'popular_items'              => __( 'Popular Project Types', 'tm_ikonic' ),
		'all_items'                  => __( 'All Project Types', 'tm_ikonic' ),
		'parent_item'                => __( 'Parent Project Type', 'tm_ikonic' ),
		'parent_item_colon'          => __( 'Parent Project Type:', 'tm_ikonic' ),
		'edit_item'                  => __( 'Edit Project Type', 'tm_ikonic' ),
		'update_item'                => __( 'Update Project Type', 'tm_ikonic' ),
		'add_new_item'               => __( 'Add New Project Type', 'tm_ikonic' ),
		'new_item_name'              => __( 'New Project Type Name', 'tm_ikonic' ),
		'separate_items_with_commas' => __( 'Separate project types with commas', 'tm_ikonic' ),
		'add_or_remove_items'        => __( 'Add or remove project types', 'tm_ikonic' ),
		'choose_from_most_used'      => __( 'Choose from the most used project types', 'tm_ikonic' ),
		'not_found'                  => __( 'No project types found', 'tm_ikonic' ),
		'menu_name'                  => __( 'Project Types', 'tm_ikonic' ),
		'view_item'                  => __( 'View Project Type', 'tm_ikonic' ),
		'update_item'                => __( 'Update Project Type', 'tm_ikonic' ),
		'popular_items'              => __( 'Popular Project Types', 'tm_ikonic' ),
		'separate_items_with_commas' => __( 'Separate project types with commas', 'tm_ikonic' ),
		'add_or_remove_items'        => __( 'Add or remove project types', 'tm_ikonic' ),
		'choose_from_most_used'      => __( 'Choose from the most used project types', 'tm_ikonic' ),
		'back_to_items'              => __( 'Back to Project Types', 'tm_ikonic' ),
	);

	$args = array(
		'labels'            => $labels,
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'project_type' ),
		'show_in_rest'      => true,
	);
	register_taxonomy( 'project_type', 'project', $args);
}

add_action( 'pre_get_posts', 'tm_projects_pagination' );
function tm_projects_pagination($query)
{
	if ( $query->is_post_type_archive( 'project' ) && $query->is_main_query() && ! is_admin() ) {
		$query->set( 'posts_per_page', 6 );
	}
}

add_action('wp_ajax_tm_projects_endpoint', 'tm_auth_endpoint');
add_action('wp_ajax_nopriv_tm_projects_endpoint', 'tm_unauth_endpoint');
/**
 * We can the method above or just use one callback function and differentiate between
 * logged and logged out using is_user_logged_in() function. But I prefer this method
 * in case we need to change the behavior of individual case independently in future.
 * */

function tm_get_posts($type, $per_page)
{
	$args = [
		'post_type' => $type,
		'post_status' => 'publish',
		'posts_per_page' => $per_page,
		'tax_query' => [
			[
				'taxonomy' => 'project_type',
				'field'    => 'slug',
				'terms'    => 'architecture',
			],
		],
	];
	$query = new WP_Query($args);
	$return_data = [];
	foreach($query->posts as $p){
		$return_data[] = [
			'ID' => $p->ID,
			'title' => get_the_title($p->ID),
			'link' => get_permalink($p->ID),
		];
	}
	return $return_data;
}
function tm_auth_endpoint()
{
	return wp_send_json_success(tm_get_posts('project', 6));
}
function tm_unauth_endpoint()
{
	return wp_send_json_success(tm_get_posts('project', 3));
}

function hs_give_me_coffee() {
	$response = wp_remote_get('https://coffee.alexflipnote.dev/random.json');

	if (is_wp_error($response)) {
		return 'Sorry, couldn\'t fetch coffee at the moment.';
	}
	$coffee_data = json_decode(wp_remote_retrieve_body($response), true);
	$direct_coffee_link = isset($coffee_data['file']) ? $coffee_data['file'] : 'No direct link available.';
	return $direct_coffee_link;
}
function tm_get_quotes($count = 5)
{
	$api_url = "https://api.kanye.rest/";
	$quotes = [];
	while (count($quotes) < $count) {
		$retries = 3;
		// We don't know how reliable api is so giving 3 fair retries incase of any errors like
		// network issue (on either side), overload etc (especially in real world applications).
		// Ofcourse, the amount of error handling code I will develop in real projects will 
		// depend on what kind of api it is and what kind of errors it can give out. But I've
		// included a decent amount here to give you an idea.
		for ($i = 0; $i < $retries; $i++) {
			$response = wp_remote_get($api_url);

			if (is_wp_error($response)) {
				$error_message = $response->get_error_message();
				$quotes[] = "Error fetching quote: $error_message";
				continue;
			} else {
				$data = json_decode(wp_remote_retrieve_body($response), true);
				if (json_last_error() !== JSON_ERROR_NONE) {
					$quotes[] = "Error decoding API response. Invalid JSON.";
					continue;
				}
				if (!isset($data['quote'])) {
					$quotes[] = "Error in API response: Quote not found.";
					continue;
				}

				$quotes[] = $data['quote'];
				break;
			}
		}
	}

	return $quotes;
}
