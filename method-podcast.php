<?php
/**
 * Plugin Name: Method Podcast
 * Plugin URI:
 * Description: This is a podcast integration that sets up a post type and custom feed for podcasts.
 * Version: 0.9.0
 * Author: Rob Clark
 * Author URI: https://robclark.io
 * License: GPLv2 or later
 * Text Domain: method-podcast
 */

add_action( 'cmb2_admin_init', 'method_podcast_options_metabox' );

function method_podcast_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box(
		array(
			'id'           => 'method_podcast_plugin_options_metabox',
			'title'        => esc_html__( 'Podcast Settings', 'cmb2-mapbox' ),
			'object_types' => array( 'options-page' ),

			/*
			 * The following parameters are specific to the options-page box
			 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
			 */

			'option_key'      => 'method_podcast', // The option key and admin menu page slug.
			'menu_title'      => esc_html__( 'Podcast Settings', 'cmb2-mapbox' ), // Falls back to 'title' (above).
			'position'        => 2, // Menu position. Only applicable if 'parent_slug' is left empty.
			'parent_slug'     => 'options-general.php',
			'save_button'     => esc_html__( 'Save Settings',  'cmb2-mapbox' ), // The text for the options-page save button. Defaults to 'Save'.
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( '<span style="font-size: 1.25rem; font-weight: 800; line-height: 1; text-transform: none;">Channel Settings</span>', 'method-podcast' ),
			'desc'     => __( 'Below, provide overall settings for the podcast.', 'hfh' ),
			'id'       => 'channel_info',
			'type'     => 'title',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Title', 'method-podcast' ),
			'desc'     => __( 'Provide a title for the podcast', 'hfh' ),
			'id'       => 'channel_title',
			'type'     => 'text',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Description', 'method-podcast' ),
			'desc'     => __( 'Provide a description for the podcast. This should be less than 3600 characters.', 'hfh' ),
			'id'       => 'channel_desc',
			'type'     => 'wysiwyg',
			'options'  => array(
				'media_buttons' => false,
				'textarea_rows' => 8,
			)
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Podcast Artwork', 'method-podcast' ),
			'desc'     => __( 'Provide artwork for this podcast. Artwork must be a minimum size of 1400 x 1400 pixels and a maximum size of 3000 x 3000 pixels, in JPEG or PNG format, 72 dpi, with appropriate file extensions (.jpg, .png), and in the RGB colorspace. These requirements are different from the standard RSS image tag specifications.', 'hfh' ),
			'id'       => 'channel_artwork',
			'type'     => 'file',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Language', 'method-podcast' ),
			'desc'     => __( 'Provide the language of this podcast. <code>en-us</code> will be used as the language is no language is provided.', 'hfh' ),
			'id'       => 'channel_language',
			'type'     => 'text',
			'attributes' => array(
				'placeholder' => 'en-us',
			), 
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Categories (Apple)', 'method-podcast' ),
			'desc'     => __( 'Choose categories for this podcast.', 'hfh' ),
			'id'       => 'channel_itunes_categories',
			'type'     => 'select',
			'repeatable' => true,
			'show_option_none' => true,
			'default' => '',
			'text' => array(
				'add_row_text' => 'Add Another Category',
			),
			'options' => array(
				'Arts' => 'Arts',
				'Arts, Books' => 'Arts > Books',
				'Arts, Design' => 'Arts > Design',
				'Arts, Fashion &amp; Beauty' => 'Arts > Fashion & Beauty',
				'Arts, Food' => 'Arts > Food',
				'Arts, Performing Arts' => 'Arts > Performing Arts',
				'Arts, Visual Arts' => 'Arts > Visual Arts',
				'Business' => 'Business',
				'Business, Careers' => 'Business > Careers',
				'Business, Entrepreneurship' => 'Business > Entrepreneurship',
				'Business, Investing' => 'Business > Investing',
				'Business, Management' => 'Business > Management',
				'Business, Marketing' => 'Business > Marketing',
				'Business, Non-Profit' => 'Business > Non-Profit',
				'Comedy' => 'Comedy',
				'Comedy, Comedy Interviews' => 'Comedy > Comedy Interviews',
				'Comedy, Improv' => 'Comedy > Improv',
				'Comedy, Stand-Up' => 'Comedy > Stand-Up',
				'Education' => 'Education',
				'Education, Courses' => 'Education > Courses',
				'Education, How To' => 'Education > How To',
				'Education, Language Learning' => 'Education > Language Learning',
				'Education, Self-Improvement' => 'Education > Self-Improvement',
				'Fiction' => 'Fiction',
				'Fiction, Comedy Fiction' => 'Fiction > Comedy Fiction',
				'Fiction, Drama' => 'Fiction > Drama',
				'Fiction, Science Fiction' => 'Fiction > Science Fiction',
				'Government' => 'Government',
				'History' => 'History',
				'Health &amp; Fitness' => 'Health & Fitness',
				'Health &amp; Fitness, Alternative Health' => 'Health & Fitness > Alternative Health',
				'Health &amp; Fitness, Fitness' => 'Health & Fitness > Fitness',
				'Health &amp; Fitness, Medicine' => 'Health & Fitness > Medicine',
				'Health &amp; Fitness, Mental Health' => 'Health & Fitness > Mental Health',
				'Health &amp; Fitness, Nutrition' => 'Health & Fitness > Nutrition',
				'Health &amp; Fitness, Sexuality' => 'Health & Fitness > Sexuality',
				'Kids &amp; Family' => 'Kids & Family',
				'Kids &amp; Family, Education for Kids' => 'Kids & Family > Education for Kids',
				'Kids &amp; Family, Parenting' => 'Kids & Family > Parenting',
				'Kids &amp; Family, Pets &amp; Animals' => 'Kids & Family > Pets & Animals',
				'Kids &amp; Family, Stories for Kids' => 'Kids & Family > Stories for Kids',
				'Leisure' => 'Leisure',
				'Leisure, Animation &amp; Manga' => 'Leisure > Animation & Manga',
				'Leisure, Automotive' => 'Leisure > Automotive',
				'Leisure, Aviation' => 'Leisure > Aviation',
				'Leisure, Crafts' => 'Leisure > Crafts',
				'Leisure, Games' => 'Leisure > Games',
				'Leisure, Hobbies' => 'Leisure > Hobbies',
				'Leisure, Home &amp; Garden' => 'Leisure > Home & Garden',
				'Leisure, Video Games' => 'Leisure > Video Games',
				'Music' => 'Music',
				'Music, Music Commentary' => 'Music > Music Commentary',
				'Music, Music History' => 'Music > Music History',
				'Music, Music Interviews' => 'Music > Music Interviews',
				'News' => 'News',
				'News, Business News' => 'News > Business News',
				'News, Daily News' => 'News > Daily News',
				'News, Entertainment News' => 'News > Entertainment News',
				'News, News Commentary' => 'News > News Commentary',
				'News, Politics' => 'News > Politics',
				'News, Sports News' => 'News > Sports News',
				'News, Tech News' => 'News > Tech News',
				'Religion &amp; Spirituality' => 'Religion & Spirituality',
				'Religion &amp; Spirituality, Buddhism' => 'Religion & Spirituality > Buddhism',
				'Religion &amp; Spirituality, Christianity' => 'Religion & Spirituality > Christianity',
				'Religion &amp; Spirituality, Hinduism' => 'Religion & Spirituality > Hinduism',
				'Religion &amp; Spirituality, Islam' => 'Religion & Spirituality > Islam',
				'Religion &amp; Spirituality, Judaism' => 'Religion & Spirituality > Judaism',
				'Religion &amp; Spirituality, Religion' => 'Religion & Spirituality > Religion',
				'Religion &amp; Spirituality, Spirituality' => 'Religion & Spirituality > Spirituality',
				'Science' => 'Science',
				'Science, Astronomy' => 'Science > Astronomy',
				'Science, Chemistry' => 'Science > Chemistry',
				'Science, Earth Sciences' => 'Science > Earth Sciences',
				'Science, Life Sciences' => 'Science > Life Sciences',
				'Science, Mathematics' => 'Science > Mathematics',
				'Science, Natural Sciences' => 'Science > Natural Sciences',
				'Science, Nature' => 'Science > Nature',
				'Science, Physics' => 'Science > Physics',
				'Science, Social Sciences' => 'Science > Social Sciences',
				'Society &amp; Culture' => 'Society & Culture',
				'Society &amp; Culture, Documentary' => 'Society & Culture > Documentary',
				'Society &amp; Culture, Personal Journals' => 'Society & Culture > Personal Journals',
				'Society &amp; Culture, Philosophy' => 'Society & Culture > Philosophy',
				'Society &amp; Culture, Places &amp; Travel' => 'Society & Culture > Places & Travel',
				'Society &amp; Culture, Relationships' => 'Society & Culture > Relationships',
				'Sports' => 'Sports',
				'Sports, Baseball' => 'Sports > Baseball',
				'Sports, Basketball' => 'Sports > Basketball',
				'Sports, Cricket' => 'Sports > Cricket',
				'Sports, Fantasy Sports' => 'Sports > Fantasy Sports',
				'Sports, Football' => 'Sports > Football',
				'Sports, Golf' => 'Sports > Golf',
				'Sports, Hockey' => 'Sports > Hockey',
				'Sports, Rugby' => 'Sports > Rugby',
				'Sports, Running' => 'Sports > Running',
				'Sports, Soccer' => 'Sports > Soccer',
				'Sports, Swimming' => 'Sports > Swimming',
				'Sports, Tennis' => 'Sports > Tennis',
				'Sports, Volleyball' => 'Sports > Volleyball',
				'Sports, Wilderness' => 'Sports > Wilderness',
				'Sports, Wrestling' => 'Sports > Wrestling',
				'Technology' => 'Technology',
				'True Crime' => 'True Crime',
				'TV &amp; Film' => 'TV & Film',
				'TV &amp; Film, After Shows' => 'TV & Film > After Shows',
				'TV &amp; Film, Film History' => 'TV & Film > Film History',
				'TV &amp; Film, Film Interviews' => 'TV & Film > Film Interviews',
				'TV &amp; Film, Film Reviews' => 'TV & Film > Film Reviews',
				'TV &amp; Film, TV Reviews' => 'TV & Film > TV Reviews',
			), 
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Explicit?', 'method-podcast' ),
			'desc'     => __( 'Check this box if this podcast contains explicit content.', 'hfh' ),
			'id'       => 'channel_explicit',
			'type'     => 'checkbox',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Author', 'method-podcast' ),
			'desc'     => __( 'Provide the name of the group responsible for creating the show.', 'hfh' ),
			'id'       => 'channel_author',
			'type'     => 'text',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Owner Name', 'method-podcast' ),
			'desc'     => __( 'Provide an owner name for the podcast (will not be visible in Podcasts app, used for admin contact).', 'hfh' ),
			'id'       => 'channel_owner_name',
			'type'     => 'text',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Owner Email', 'method-podcast' ),
			'desc'     => __( 'Provide an owner email address for the podcast (will not be visible in Podcasts app, used for admin contact).', 'hfh' ),
			'id'       => 'channel_owner_email',
			'type'     => 'text_email',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Copyright', 'method-podcast' ),
			'desc'     => __( '(If not applicable, leave blank to omit from feed)', 'hfh' ),
			'id'       => 'channel_copyright',
			'type'     => 'text',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Podcast Website Link', 'method-podcast' ),
			'desc'     => __( '(If not applicable, leave blank to omit from feed)', 'hfh' ),
			'id'       => 'channel_link',
			'type'     => 'text_url',
		)
	);

}