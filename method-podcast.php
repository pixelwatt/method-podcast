<?php
/**
 * Plugin Name: Method Podcast
 * Plugin URI:
 * Description: This is a podcast integration that sets up a post type and custom feed for podcasts.
 * Version: 0.9.2
 * Author: Rob Clark
 * Author URI: https://robclark.io
 * License: GPLv2 or later
 * Text Domain: method-podcast
 */

function method_podcast_add_feed() {
  	add_feed('podcast-feed', 'method_podcast_load_feed');
}
add_action('init', 'method_podcast_add_feed');

function method_podcast_load_feed() {
  	add_filter('pre_option_rss_use_excerpt', '__return_zero');
  	load_template( plugin_dir_path( __FILE__ ) . 'feeds/podcast-feed-template.php' );
}

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

	$cmb_options->add_field(
		array(
			'name'     => __( '<span style="font-size: 1.25rem; font-weight: 800; line-height: 1; text-transform: none;">Syndication Links</span>', 'method-podcast' ),
			'desc'     => __( 'Below, provide links to the platforms being used to syndicate your podcast.', 'hfh' ),
			'id'       => 'syndication_info',
			'type'     => 'title',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Spotify URL', 'method-podcast' ),
			'id'       => 'syndication_spotify',
			'type'     => 'text_url',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Apple Podcasts URL', 'method-podcast' ),
			'id'       => 'syndication_apple',
			'type'     => 'text_url',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Google Podcasts URL', 'method-podcast' ),
			'id'       => 'syndication_google',
			'type'     => 'text_url',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Pocketcasts URL', 'method-podcast' ),
			'id'       => 'syndication_pocketcasts',
			'type'     => 'text_url',
		)
	);

}

add_action( 'init', 'method_podcast_init' );

function method_podcast_get_syndication_links() {
	$output = '';
	$links = array();
	$util = new Method_Podcast_Utilities();
	$opts = array( 'syndication_spotify', 'syndication_apple', 'syndication_google', 'syndication_pocketcasts' );
	foreach ( $opts as $opt ) {
		if ( $util->get_option( $opt ) ) {
			$link_url = $util->get_option( $opt );
			switch ( $opt ) {
				case 'syndication_spotify':
					$links[] = array(
						'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><title>Spotify</title><g><path fill="currentColor" d="M24 11.69V12.29c0 .15-.01.29-.02.44-.02.24-.04.48-.07.72-.02.19-.04.38-.07.57-.05.29-.11.57-.18.85-.07.27-.15.54-.24.81-.09.28-.19.56-.3.84-.07.19-.16.37-.25.55-.09.19-.17.38-.27.57-.72 1.35-1.66 2.52-2.82 3.51a11.898 11.898 0 0 1-4.85 2.5c-.33.08-.67.16-1.01.21-.16.02-.32.04-.48.07-.06 0-.13.01-.19.02s-.03.01-.05.02h-.09c-.05-.03-.09-.02-.14 0h-.14l-.21.02h-.09c-.1 0-.2.01-.3.02h-.46c-.13 0-.26-.02-.39-.03-.06 0-.13 0-.19-.01h-.27s-.09-.02-.14-.02l-.21-.03c-.08 0-.15-.01-.23-.02-.13-.02-.26-.03-.38-.05-.19-.04-.39-.08-.58-.13-.23-.05-.47-.1-.7-.17-.2-.06-.41-.13-.61-.2-.23-.08-.45-.17-.67-.26-.17-.07-.34-.13-.5-.21-.19-.09-.38-.2-.57-.3-1.72-.93-3.13-2.2-4.23-3.81-.48-.7-.87-1.46-1.21-2.24-.1-.22-.16-.45-.24-.68-.11-.29-.19-.58-.26-.88-.09-.35-.17-.71-.23-1.07-.03-.21-.05-.42-.07-.63l-.06-.77v-1c.02-.44.05-.88.13-1.32.05-.3.09-.6.17-.9.08-.29.14-.58.23-.87.07-.24.17-.47.25-.71.1-.28.22-.56.35-.83.71-1.5 1.69-2.8 2.93-3.89C5.47 1.8 7.02.96 8.76.46c.27-.08.53-.15.8-.2.21-.04.42-.07.64-.1.16-.02.31-.05.47-.07.06 0 .11-.01.17-.02h.06c.07 0 .14-.01.21-.02h.09c.12 0 .25-.01.37-.02h.71c.12 0 .23.01.35.02h.27c.07 0 .14.01.21.02.04 0 .09.02.13.02.21.02.42.04.63.07.24.04.47.09.71.14l.75.18c.07.02.14.05.2.07.25.08.5.16.75.25.14.05.28.12.43.18.23.1.47.2.69.31 1.28.64 2.41 1.5 3.39 2.55.94 1.01 1.69 2.15 2.23 3.42.11.26.22.53.31.8.09.26.17.53.25.8.11.41.21.82.26 1.24.02.18.07.36.09.55.02.21.04.42.05.63v.21c0 .07.01.14.02.21Zm-12.45-1.15h-.14c-.06 0-.11-.01-.17-.02h-.18c-.07 0-.14-.01-.21-.02h-.3s-.07-.02-.1-.02h-.91c-.03 0-.07.01-.1.02-.17 0-.34.02-.51.02h-.18c-.06 0-.11.01-.17.02-.04 0-.09.01-.13.02-.05-.03-.09-.02-.14 0-.08 0-.15.02-.23.02-.06 0-.12.01-.19.02-.07 0-.14.01-.21.03-.18.04-.36.04-.54.08-.23.06-.46.07-.69.12-.42.1-.85.2-1.26.33-.38.12-.61.39-.66.8-.04.38.11.67.42.88.11.07.22.14.36.14.09.03.19.03.28 0l.57-.15c.2-.05.4-.11.6-.15.25-.05.5-.07.75-.13.26-.06.52-.07.77-.11.06 0 .13-.01.19-.02h.06c.07 0 .14-.01.21-.02h.06c.11 0 .22-.01.33-.02H10.78c.11 0 .22.02.33.02h.06c.08 0 .16.01.24.02.06 0 .12.02.18.02.17.02.33.03.5.05.13.02.27.05.4.07.19.03.38.05.57.09.38.08.75.17 1.12.26.3.08.59.16.89.25.25.08.49.18.73.27.27.11.54.22.8.34.4.18.78.4 1.16.63.07.04.16.07.25.07.1.04.2.03.31 0a.932.932 0 0 0 .77-1.05v-.02a.892.892 0 0 0-.4-.61c-.49-.31-1.01-.58-1.54-.81-.19-.08-.38-.16-.57-.23-.21-.09-.43-.17-.64-.25-.24-.08-.48-.15-.73-.23a9.73 9.73 0 0 0-.77-.22c-.27-.07-.54-.12-.81-.17-.28-.06-.57-.11-.85-.16a11.537 11.537 0 0 0-.87-.11c-.07 0-.14-.01-.21-.02h-.02a.59.59 0 0 1-.14-.02Zm-3.34-4.1c-.05.01-.11.02-.16.02h-.09c-.08 0-.15.01-.23.02-.13.02-.27.03-.4.05-.08.01-.16.03-.25.04-.1.02-.21.04-.31.05-.14.02-.28.02-.42.05-.3.06-.6.12-.89.19-.33.08-.65.17-.97.26-.36.11-.59.37-.7.72-.09.28-.07.57.07.84.16.29.39.49.7.58l.13.03c.11.04.22.04.33 0 .32-.08.64-.17.97-.25.22-.05.44-.09.67-.14.21-.04.42-.08.64-.1.12 0 .23-.03.35-.04.18-.02.37-.05.55-.07.07 0 .14-.01.21-.02h.04c.09 0 .17-.01.26-.02h.04c.11 0 .22-.02.33-.02h.06c.16 0 .33-.01.49-.02h1.08c.14 0 .28.01.42.02h.39c.09 0 .19.01.28.02h.09l.24.02h.06l.21.02h.06c.06 0 .11.01.17.02l.28.03c.09.01.18.03.27.04l.27.03c.22.03.43.07.64.11.22.04.45.07.67.12.34.08.68.16 1.02.25.24.06.49.14.73.21.19.06.38.12.57.19.2.07.4.16.59.24.23.1.47.19.7.3.26.13.52.28.78.42.12.07.25.11.38.14.11.03.22.03.32 0 .05-.01.11-.03.16-.04.44-.13.76-.52.8-1.02 0-.04.03-.09-.02-.12a.86.86 0 0 0-.09-.42c-.11-.23-.28-.39-.5-.52-.53-.31-1.08-.58-1.64-.81-.23-.1-.47-.18-.7-.27-.22-.08-.45-.16-.67-.23-.17-.05-.34-.09-.52-.14l-.49-.15c-.29-.07-.59-.13-.88-.2-.22-.05-.43-.09-.65-.13-.14-.03-.29-.05-.43-.07-.14-.02-.28-.04-.42-.07-.06 0-.13-.02-.19-.03-.09 0-.19-.01-.28-.02-.09-.01-.17-.03-.25-.05-.07 0-.14-.01-.21-.02h-.11c-.05 0-.09-.01-.14-.02-.08 0-.16-.02-.23-.02h-.02a.59.59 0 0 1-.14-.02h-.16c-.06-.01-.13-.02-.19-.02h-.18c-.08 0-.16-.01-.23-.02h-.27c-.13 0-.26-.01-.4-.02h-.98c-.15 0-.29.01-.44.02h-.25c-.08 0-.16.01-.24.02h-.04c-.1 0-.2.01-.3.02h-.16c-.05 0-.1.01-.14.02Zm.55 8.01c-.05 0-.11.01-.16.02h-.11c-.07 0-.14.01-.21.02-.13.02-.26.03-.38.05-.1.01-.21.03-.31.05-.19.03-.39.05-.58.08-.38.07-.76.14-1.14.22-.14.03-.29.05-.43.12-.2.12-.34.28-.38.52v.28c0 .1.05.18.1.26.13.18.29.3.52.34.07.03.14.03.21 0 .21-.04.42-.09.63-.13.16-.03.32-.07.48-.1.15-.03.3-.05.46-.07.1-.02.2-.03.3-.05l.28-.03c.19-.02.37-.04.56-.07.07 0 .14-.01.21-.02h.04c.08 0 .16-.01.24-.02h.11c.14 0 .28-.01.42-.02s.08 0 .12 0h.89c.09 0 .19.01.28.02h.25c.09 0 .17.01.26.02.09 0 .17.02.26.02.16.02.32.05.48.07.17.02.34.04.5.07.17.03.33.08.49.11.37.07.73.17 1.09.29.26.09.51.19.77.29.2.08.4.16.59.26.33.17.65.36.98.53.05.03.12.04.18.05.09.03.17.03.26 0 .32-.07.52-.26.6-.57v-.03a.715.715 0 0 0-.32-.75c-.11-.08-.23-.14-.35-.21-.43-.24-.87-.47-1.34-.65-.19-.07-.37-.16-.56-.23-.27-.1-.54-.18-.8-.27-.09-.03-.18-.05-.27-.07-.09-.02-.18-.04-.26-.06-.2-.04-.39-.09-.59-.13a5.25 5.25 0 0 0-.55-.09c-.16-.02-.33-.04-.49-.07-.03 0-.05-.01-.07-.02-.07 0-.14-.02-.2-.03-.08 0-.16-.02-.23-.02h-.02a.59.59 0 0 1-.14-.02h-.18c-.06 0-.13-.01-.19-.02h-.27c-.03 0-.07-.01-.1-.01h-.95c-.03 0-.07.01-.1.02h-.32c-.06 0-.11 0-.17.01h-.18c-.06 0-.11.01-.17.02ZM12.45 0v.02h-.87V0h.87Z"/><path d="M.03 11.69v.62H0v-.62h.03ZM24 12.72h-.02c0-.15.01-.29.02-.44v-.07.51ZM11.34 24v-.02h.05c.13 0 .26.02.39.03h-.44ZM0 12.31h.03v.19h-.04v-.18Z"/><path d="M.03 11.69H0v-.18h.04v.19ZM12.24 24c.1 0 .2-.01.3-.02V24h-.3ZM23.98 11.27H24v.21h-.02v-.21Z"/><path d="M12.54 24v-.02h.21V24h-.21ZM23.98 11.48H24v.21c0-.07-.01-.14-.02-.21ZM9.66 8.6s.09-.02.14-.02h.92c.04 0 .08 0 .12.02H9.66ZM10.7 14.41H9.59c.03 0 .07-.02.1-.02h.95c.03 0 .07 0 .1.01h-.05ZM10.56 10.49H9.45c.03 0 .07-.02.1-.02h.91c.03 0 .07.01.1.02ZM9.62 15.9s.07-.02.1-.02h.86c.03 0 .07 0 .1.02H9.62ZM10.77 6.37h-1v-.02h.98v.02ZM9.6 12.36h.78v.02h-.79v-.02ZM9.46 10.49c-.17 0-.34.01-.51.02.17 0 .34-.01.51-.02ZM9.13 8.63c.16 0 .33-.01.49-.02-.16 0-.33.01-.49.02Z"/><path d="M9.78 6.35v.02h-.44c.15 0 .29-.01.44-.02ZM10.7 8.61H11.11v.02c-.14 0-.28-.01-.42-.02ZM9.2 15.92c.14 0 .28-.01.42-.02-.14 0-.28.01-.42.02ZM10.77 6.37v-.02c.13 0 .26.01.4.02h-.39ZM11.2.04c.12 0 .25-.01.37-.02-.12 0-.25.01-.37.02ZM12.29.03H12.63v.02c-.12 0-.23-.01-.35-.02ZM9.6 12.36v.02h-.34c.12 0 .23-.01.35-.02ZM10.38 12.37v-.02c.12 0 .23.01.35.02h-.34ZM4.69 9.3h.33c-.11.04-.22.04-.33 0ZM8.74 8.65c.11 0 .22-.01.33-.02-.11 0-.22.01-.33.02ZM19.51 10.79h.32a.58.58 0 0 1-.32 0ZM8.83 12.4c.11 0 .22-.01.33-.02-.11 0-.22.01-.33.02ZM10.81 12.38c.11 0 .22.01.33.02-.11 0-.22-.01-.33-.02ZM11.11 6.38h.32v.02c-.11 0-.22-.01-.33-.02ZM10.7 14.41h.32v.02c-.11 0-.22-.01-.33-.02ZM10.86 10.51c-.1 0-.2-.01-.3-.02h.3v.02ZM11.12 8.63v-.02c.1 0 .2.01.3.02h-.3ZM8.82 6.4c-.1 0-.2.01-.3.02.1 0 .2-.01.3-.02ZM18.04 14.47h.31c-.1.03-.2.04-.31 0ZM9.58 14.41c-.1 0-.2.01-.3.02v-.02h.3ZM5.33 12.98h.28c-.09.03-.19.03-.28 0ZM11.5 8.63c.09 0 .19.01.28.02-.09 0-.19-.01-.28-.02ZM10.63 15.91h.28v.02c-.09 0-.19-.01-.28-.02ZM11.41 15.94c.09 0 .17.02.26.02-.09 0-.17-.02-.26-.02ZM16.75 17.65h.26c-.09.03-.17.03-.26 0ZM9.34 6.38c-.09 0-.17.01-.26.02v-.02h.25ZM8.44 8.67c.09 0 .17-.01.26-.02-.09 0-.17.01-.26.02ZM11.16 15.92c.09 0 .17.01.26.02-.09 0-.17-.01-.26-.02ZM11.78 14.47c-.08 0-.16-.01-.23-.02.08 0 .16.01.23.02ZM20.8 9.73s-.01-.08-.02-.12c.05.03.02.08.02.12ZM7.96 6.47c-.08 0-.15.01-.23.02.08 0 .15-.01.23-.02ZM11.2 12.4c.08 0 .16.01.24.02-.08 0-.16-.01-.24-.02ZM11.44 6.39v-.02c.08 0 .16.01.23.02h-.23Z"/><path d="M9.09 6.38v.02h-.23c.08 0 .16-.01.24-.02ZM12.59 6.46c-.08 0-.16-.01-.23-.02.08 0 .16.01.23.02ZM8.33 10.56c-.08 0-.15.02-.23.02.08 0 .15-.02.23-.02ZM11.87 8.65c.08 0 .16.01.24.02-.08 0-.16-.01-.24-.02ZM8.86 15.94c.08 0 .16-.01.24-.02-.08 0-.16.01-.24.02ZM12.17 8.68c.07 0 .14.01.21.02-.07 0-.14-.01-.21-.02ZM11.92 10.58c-.07 0-.14-.01-.21-.02.07 0 .14.01.21.02ZM10.9.07c.07 0 .14-.01.21-.02-.07 0-.14.01-.21.02ZM12.75 23.98h-.12c.07 0 .14-.01.21-.02v.02h-.09ZM10.79 23.93c-.07 0-.14-.02-.21-.02.07 0 .14.02.21.02ZM12.91.05c.07 0 .14.01.21.02-.07 0-.14-.01-.21-.02ZM8.56 12.42c.07 0 .14-.01.21-.02-.07 0-.14.01-.21.02ZM5.68 16.41h.21c-.07.03-.14.03-.21 0ZM8.6 15.97c.07 0 .14-.01.21-.02-.07 0-.14.01-.21.02ZM10.91 15.92v-.02c.07 0 .14.01.21.02h-.21ZM11.98 14.5c-.07 0-.14-.02-.2-.03.07 0 .14.02.2.03ZM10.86 10.51v-.02c.07 0 .14.01.21.02h-.2ZM8.49 14.47c-.07 0-.14.01-.21.02.07 0 .14-.01.21-.02ZM13.05 6.51c-.07 0-.14-.01-.21-.02.07 0 .14.01.21.02ZM8.19 8.7c.07 0 .14-.01.21-.02-.07 0-.14.01-.21.02ZM8.1 10.58c-.06 0-.12.01-.19.02.06 0 .12-.01.19-.02ZM8.95 10.52c-.06 0-.13.01-.19.02v-.02h.18ZM11.03 14.43v-.02c.06 0 .13.01.19.02h-.18ZM12.64.04V.02c.06 0 .13.01.19.02h-.18ZM9.11 14.43c-.06 0-.13.01-.19.02v-.02h.18ZM11.39 14.45c-.06 0-.13-.01-.19-.02h.18v.02ZM11.39 23.97h-.18v-.02c.06 0 .13 0 .19.01ZM13.44 23.91c-.06 0-.13.01-.19.02.06 0 .13-.01.19-.02ZM11.26 10.54c-.06 0-.13-.01-.19-.02h.18v.02ZM8.3 12.45c.06 0 .13-.01.19-.02-.06 0-.13.01-.19.02ZM11.86 6.42c-.06 0-.13-.01-.19-.02h.18v.02ZM11.86 6.42V6.4c.06 0 .13.01.19.02h-.18Z"/><path d="M8.77 10.52v.02h-.16c.06 0 .11-.01.17-.02ZM11.26 10.54v-.02c.06 0 .11.01.17.02h-.16ZM8.93 14.43v.02h-.16c.06 0 .11-.01.17-.02ZM12.2 6.44c-.06 0-.11-.01-.17-.02h.16v.02ZM8.51 6.42c-.06 0-.11.01-.17.02v-.02h.16ZM11.2 23.96v.02c-.06 0-.11-.01-.17-.02h.16ZM9.28 14.41v.02h-.16c.06 0 .11 0 .17-.01ZM8.22 6.44c-.05 0-.11.01-.16.02.05 0 .11-.01.16-.02ZM12.45 8.7c.06 0 .11.01.17.02-.06 0-.11-.01-.17-.02ZM8.77 14.45c-.05 0-.11.01-.16.02.05 0 .11-.01.16-.02ZM10.67.09c.06 0 .11-.01.17-.02-.06 0-.11.01-.17.02ZM13.12 23.95h-.14c.05-.02.09-.03.14 0ZM12.73 6.49s-.09-.01-.14-.02c.05 0 .09.01.14.02ZM8.47 10.56h-.14s.09-.03.14 0ZM10.93 23.95s-.09-.01-.14-.02c.05 0 .09.01.14.02Z"/><path d="M8.36 6.42v.02h-.14c.05 0 .1-.01.14-.02ZM11.39 14.45v-.02c.05 0 .1.01.14.02h-.14ZM11.56 10.56s-.1-.01-.14-.02h.14v.02ZM12.83 23.97v-.02h.14c-.05 0-.1.01-.14.02ZM11.56 10.56v-.02c.05 0 .1.01.14.02h-.14ZM12.2 6.44v-.02c.05 0 .1.01.14.02h-.14ZM13.25 23.93s-.03.01-.05.02c.02 0 .03-.01.05-.02ZM17.6 17.08v-.03.03ZM19.11 13.42v-.03.02ZM5.06 15.53v.03-.03ZM5.05 15.78v.02-.02Z"/></g></svg>',
						'label' => 'Spotify',
						'url' => $link_url,
					);
					break;
				case 'syndication_apple':
					$links[] = array(
						'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><title>Apple Podcasts</title><path fill="currentColor" d="M22.92 10.41c-.03.76-.04 1.52-.15 2.28-.11.75-.36 1.45-.57 2.17-.24.5-.46 1.01-.73 1.49-.39.71-.88 1.35-1.42 1.95-.68.62-1.32 1.26-2.1 1.77-.36.24-.73.45-1.11.63-.33.16-.8.46-1.16.48-.41.02-.18-.58-.14-.84.04-.37.09-.61.44-.79.77-.4 1.5-.8 2.16-1.38 1-.68 1.63-1.81 2.27-2.8.11-.21.23-.41.31-.63.19-.52.36-1.05.53-1.58.19-.94.24-1.83.26-2.79-.12-.58-.13-1.18-.26-1.76-.13-.59-.34-1.16-.61-1.69-.18-.55-.56-1.09-.9-1.55-.32-.45-.7-.98-1.16-1.29a9.325 9.325 0 0 0-6.75-2.67c-1.27.02-2.54.29-3.7.81-1.03.46-2.2 1.16-2.89 2.06-.03.02-.07.03-.1.06a9.449 9.449 0 0 0-2.13 3.49c-.27.73-.42 1.48-.49 2.25-.05.56 0 1.13 0 1.69.17 1.06.36 2.09.83 3.06.16.32.32.64.49.95.27.46.57.91.94 1.3.26.28.51.57.79.83.46.44.96.82 1.52 1.13.34.19.73.35 1.05.56.31.21.31.5.35.84.02.17.2.7-.04.77-.12.04-.37-.13-.48-.18-.22-.09-.43-.18-.65-.28-1.5-.69-2.62-1.71-3.75-2.89-.25-.35-.52-.69-.76-1.05-.57-.87-.99-1.81-1.29-2.8-.13-.53-.28-1.06-.35-1.6-.08-.57-.07-1.15-.09-1.72.05-.56.08-1.12.17-1.68.07-.43.2-.85.31-1.27.26-.77.56-1.53.98-2.23.16-.26.32-.52.49-.78.82-1.18 1.83-2.04 2.96-2.91C6.91 1.3 7.8.8 8.82.49 9.83.17 10.9 0 11.96 0c1.12 0 2.26.16 3.33.5 1.06.34 1.98.92 2.94 1.46.94.68 1.79 1.45 2.47 2.4.34.47.63.97.95 1.46.31.74.66 1.44.88 2.22.21.78.3 1.57.39 2.38Zm-10.73 3.21c-.97-.05-1.76.21-2.5.84-.58.64-.41 1.77-.37 2.56.06.66.1 1.32.2 1.97.08.89.24 1.78.38 2.67.13.58.16 1.33.59 1.78.39.42 1.02.58 1.58.57.51-.02 1.1-.19 1.45-.58.4-.45.44-1.17.56-1.74.18-1.18.33-2.36.47-3.54.11-1.13.39-2.48-.13-3.54-.56-.69-1.36-.93-2.22-.98ZM6.45 8.88c.25-.68.61-1.29 1.09-1.83 1.15-1.39 2.97-2.11 4.76-2.02.81.04 1.62.25 2.35.61.63.32 1.39.81 1.8 1.41.58.65.99 1.4 1.22 2.24.14.75.25 1.42.2 2.18-.05.31-.08.62-.15.92-.2.82-.57 1.56-1.11 2.21-.36.38-.71.63-.72 1.18 0 .21-.15 1.09.08 1.19.21.09.78-.53.93-.66.33-.29.61-.64.9-.96.15-.22.31-.42.43-.66.25-.5.48-1.02.72-1.53.23-.94.34-1.81.34-2.79-.07-.4-.11-.81-.2-1.21-.17-.77-.5-1.48-.9-2.15-.92-1.27-1.96-2.23-3.41-2.87-.99-.34-1.94-.56-3-.52-1.1.04-2.05.37-3.07.75-.71.45-1.4.89-1.98 1.5-.56.59-1 1.26-1.36 1.99-.24.62-.46 1.22-.58 1.88-.12.67-.08 1.35-.06 2.03.03.2.06.4.1.6.2.86.51 1.68.98 2.43.54.88 1.25 1.6 2.11 2.18h.1c.16-.38.16-1.04.08-1.45-.08-.42-.61-.83-.88-1.15-.38-.63-.74-1.21-.93-1.92-.16-.59-.35-1.44-.17-2.05.02-.53.15-1.04.34-1.54Zm5.2-1.37c-1.42.16-2.37 1.53-2.19 2.91.23.99.85 1.79 1.86 2.07 1.04.28 2.12-.16 2.75-1.01.44-.66.53-1.39.36-2.15-.48-1.19-1.46-1.97-2.79-1.82Z"/></svg>',
						'label' => 'Apple Podcasts',
						'url' => $link_url,
					);
					break;
				case 'syndication_google':
					$links[] = array(
						'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><title>Google Podcasts</title><path fill="currentColor" d="M13.46 20.91v1.61c0 .75-.52 1.34-1.26 1.46-.01 0-.02.01-.03.02h-.34c-.12-.03-.24-.06-.35-.1-.56-.22-.92-.74-.93-1.35v-1.66c0-.71.52-1.32 1.23-1.42.73-.1 1.37.28 1.61.98.05.15.07.31.08.47Zm10.49-10.12c-.2-.68-.8-1.15-1.64-1.05-.65.08-1.19.67-1.21 1.32-.02.62-.02 1.23 0 1.85.03.87.87 1.47 1.64 1.34.63-.1 1.03-.46 1.21-1.07.02-.07.03-.14.05-.21v-1.96c-.02-.08-.03-.15-.05-.23Zm-13.4 5.52c0 .12.01.24.03.35.14.77.97 1.34 1.77 1.12.59-.16 1.1-.68 1.1-1.44V7.63c0-.13-.02-.27-.05-.4-.14-.56-.69-1.07-1.38-1.06-.5 0-.89.2-1.19.58-.2.26-.29.57-.29.9v8.65Zm-5.22-4.32c.19.75.94 1.22 1.68 1.06.74-.15 1.18-.76 1.18-1.45V6.28a1.438 1.438 0 0 0-1.61-1.46c-.38.04-.69.21-.94.5-.19.22-.33.48-.33.77-.01.95 0 1.89 0 2.84v2.64c0 .14.01.29.05.42Zm13.4.43c0-.13-.01-.26-.04-.38-.19-.82-1-1.28-1.81-1.06-.62.17-1.05.73-1.05 1.37v5.34c0 .1 0 .21.02.31.15.83.95 1.33 1.7 1.17.7-.15 1.18-.73 1.18-1.47v-5.28ZM2.84 10.71c-.15-.5-.68-.99-1.35-.98-.29 0-.55.06-.79.21-.4.25-.65.62-.68 1.09-.03.6 0 1.21 0 1.81a1.47 1.47 0 0 0 1.85 1.38c.59-.17 1.02-.68 1.06-1.3.02-.3 0-.61 0-.91v-.78c0-.18-.03-.36-.08-.53Zm7.75-7.3c.16.75.91 1.22 1.59 1.13a1.47 1.47 0 0 0 1.29-1.47V1.48c0-.13-.02-.26-.05-.39-.15-.61-.76-1.16-1.56-1.07-.28.03-.53.13-.74.3-.32.25-.51.58-.54.98-.02.33 0 .67 0 1h-.01v.76c0 .12.01.24.04.35Zm8.1 2.5c-.19-.81-.99-1.27-1.79-1.06-.63.16-1.06.73-1.07 1.38v1.68c0 .11.02.22.04.33.19.8 1.08 1.32 1.9 1.02.55-.2.95-.7.96-1.35V6.29c0-.13-.01-.26-.04-.38ZM8.16 15.78a1.452 1.452 0 0 0-2.38-.77c-.3.27-.47.6-.48 1.01V17.72c0 .13.01.27.05.39.19.73.94 1.21 1.67 1.06.73-.15 1.18-.75 1.18-1.42v-1.68c0-.1-.01-.2-.03-.29Z"/></svg>',
						'label' => 'Google Podcasts',
						'url' => $link_url,
					);
					break;
				case 'syndication_pocketcasts':
					$links[] = array(
						'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><title>Pocketcasts</title><path fill="currentColor" d="M23.99 11.99h-3.02C20.72 6.16 15.32 1.73 9.51 3.4 4.2 4.92 1.4 11.24 4.06 16.16c1.6 2.96 4.61 4.7 7.94 4.8v2.99C4.44 24.58-1.24 16.48.23 9.5 1.97 1.27 11.78-2.66 18.74 2.02c3.23 2.18 5.38 6.04 5.25 9.97ZM6.95 6.82a7.3 7.3 0 0 0-1.44 8.36c.67 1.37 1.73 2.38 3.05 3.13.91.52 2.36 1.24 3.44.85v-2.59c-3.63-.17-5.89-4.32-3.6-7.32 2.66-3.49 7.95-1.38 8.16 2.77.91 0 1.78.01 2.65 0 .15-6.31-7.84-9.53-12.27-5.19Z"/></svg>',
						'label' => 'Pocketcasts',
						'url' => $link_url,
					);
					break;
				default:
					break;
			}
		}
	}
	if ( 0 < count( $links ) ) {
		$output = '<ul class="method-podcast-syndication-links">';
		foreach ( $links as $link ) {
			$output .= '<li><a href="' . $link['url'] . '" target="_blank"><span class="aria-hidden">' . $link['icon'] . '</span><span class="visually-hidden">' . $link['label'] . '</span></a></li>';
		}
		$output .= '</ul>';
	}
	return $output;
}

function method_podcast_init() {
	$labels = array(
		'name'               => _x( 'Podcasts', 'post type general name', 'hfh' ),
		'singular_name'      => _x( 'Podcast', 'post type singular name', 'hfh' ),
		'menu_name'          => _x( 'Podcasts', 'admin menu', 'hfh' ),
		'name_admin_bar'     => _x( 'Podcast', 'add new on admin bar', 'hfh' ),
		'add_new'            => _x( 'Add New Podcast', 'job', 'hfh' ),
		'add_new_item'       => __( 'Add New Podcast', 'hfh' ),
		'new_item'           => __( 'New Podcast', 'hfh' ),
		'edit_item'          => __( 'Edit Podcast', 'hfh' ),
		'view_item'          => __( 'View Podcast', 'hfh' ),
		'all_items'          => __( 'Podcasts', 'hfh' ),
		'search_items'       => __( 'Search Podcasts', 'hfh' ),
		'parent_item_colon'  => __( 'Parent Podcast:', 'hfh' ),
		'not_found'          => __( 'No podcasts found.', 'hfh' ),
		'not_found_in_trash' => __( 'No podcasts found in Trash.', 'hfh' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'A description for the post type.', 'hfh' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'rewrite'            => array( 'slug' => 'podcast' ),
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position' 	 => 5,
		'menu_icon'			 => 'dashicons-megaphone',
		'supports'           => array( 'title' , 'editor', 'thumbnail' )
	);

	register_post_type( 'method_podcast', $args );
}

add_action( 'cmb2_admin_init', 'method_podcast_register_podcast_metabox' );

function method_podcast_register_podcast_metabox() {
	$cmb_options = new_cmb2_box(
		array(
			'id'            => '_method_postcast_metabox_podcast',
			'title'         => esc_html__( 'Podcast Options', 'cmb2' ),
			'object_types'  => array( 'method_podcast' ),
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Description', 'method-podcast' ),
			'desc'     => __( 'Provide an episode description.', 'hfh' ),
			'id'       => '_method_podcast_desc',
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
			'desc'     => __( 'Provide artwork for this episode if desired. Otherwise, the channel artwork will be used. Artwork must be a minimum size of 1400 x 1400 pixels and a maximum size of 3000 x 3000 pixels, in JPEG or PNG format, 72 dpi, with appropriate file extensions (.jpg, .png), and in the RGB colorspace. These requirements are different from the standard RSS image tag specifications.', 'hfh' ),
			'id'       => '_method_podcast_artwork',
			'type'     => 'file',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Explicit?', 'method-podcast' ),
			'desc'     => __( 'Check this box if this episode contains explicit content.', 'hfh' ),
			'id'       => '_method_podcast_explicit',
			'type'     => 'checkbox',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Audio File', 'method-podcast' ),
			'desc'     => __( 'Provide the audio file for this episode.', 'hfh' ),
			'id'       => '_method_podcast_file',
			'type'     => 'file',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Audio File Length', 'method-podcast' ),
			'desc'     => __( 'This value will automatically be calculated and most likely will never need to be manually entered.', 'hfh' ),
			'id'       => '_method_podcast_length',
			'type'     => 'text',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Audio File Type', 'method-podcast' ),
			'desc'     => __( 'This will default to the filetype for mp3, but can be manually changed if needed.', 'hfh' ),
			'id'       => '_method_podcast_filetype',
			'type'     => 'text',
			'attributes' => array(
				'placeholder' => 'audio/mpeg',
			),
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Audio File Duration', 'method-podcast' ),
			'desc'     => __( 'Provide the duration of this episode, in seconds.', 'hfh' ),
			'id'       => '_method_podcast_duration',
			'type'     => 'text',
		)
	);

}

function method_podcast_update_filelength( $id, $post ) {
	$file = get_post_meta( $post->ID, '_method_podcast_file', true );

	if ( !empty($file) ) {
		$filesize = method_podcast_getRemoteFilesize( $file, false );
		update_post_meta( $post->ID, '_method_podcast_length', $filesize ); 
	}

	return;
}

add_action( 'save_post', 'method_podcast_update_filelength', 10000, 2 );

function method_podcast_getRemoteFilesize($file_url, $formatSize = true)
{
    $head = array_change_key_case(get_headers($file_url, 1));
    // content-length of download (in bytes), read from Content-Length: field
	
    $clen = isset($head['content-length']) ? $head['content-length'] : 0;
 
    // cannot retrieve file size, return "-1"
    if (!$clen) {
        return -1;
    }
 
    if (!$formatSize) {
        return $clen; 
		// return size in bytes
    }
 
    $size = $clen;
    switch ($clen) {
        case $clen < 1024:
            $size = $clen .' B'; break;
        case $clen < 1048576:
            $size = round($clen / 1024, 2) .' KB'; break;
        case $clen < 1073741824:
            $size = round($clen / 1048576, 2) . ' MB'; break;
        case $clen < 1099511627776:
            $size = round($clen / 1073741824, 2) . ' GB'; break;
    }
 
    return $size; 
	// return formatted size
}

function method_podcast_check_array_key( $item, $key ) {
	$output = false;
	if ( is_array( $item ) ) {
		if ( array_key_exists( $key, $item ) ) {
			if ( ! empty( $item["{$key}"] ) ) {
				$output = true;
			}
		}
	}
	return $output;
}

class Method_Podcast_Utilities {
	protected $loaded_meta = array();
	protected $opts        = array();

	function __construct() {
		$this->opts = get_option( 'method_podcast' );
	}

	public function load_meta( $id ) {
		$this->loaded_meta = get_post_meta( $id );
		return;
	}

	public function unload_meta() {
		$this->loaded_meta = array();
		return;
	}

	public function get_loaded_meta( $key, $fallback = '' ) {
		$output = false;
		if ( $this->check_array_key( $this->loaded_meta, $key ) ) {
			if ( $this->check_array_key( $this->loaded_meta[ "{$key}" ], 0 ) ) {
				$output = $this->loaded_meta[ "{$key}" ][0];
			}
		}
		return ( false === $output ? ( ! empty( $fallback ) ? $fallback : false ) : $output );
	}

	public function get_serialized_loaded_meta( $key ) {
		$output = false;
		if ( $this->check_array_key( $this->loaded_meta, $key ) ) {
			if ( $this->check_array_key( $this->loaded_meta[ "{$key}" ], 0 ) ) {
				$output = maybe_unserialize( $this->loaded_meta[ "{$key}" ][0] );
			}
		}
		return $output;
	}

	public function get_loaded_headline( $key, $before, $after, $fallback = '' ) {
		$output = '';
		if ( ( $this->get_loaded_meta( $key ) ) || ( ! empty( $fallback ) ) ) {
			$output = $before . ( $this->get_loaded_meta( $key ) ? $this->format_tags( esc_html( $this->get_loaded_meta( $key ) ) ) : $fallback ) . $after;
		}
		return $output;
	}

	public function get_loaded_content( $key, $before, $after, $fallback = '' ) {
		$output = '';
		if ( ( $this->get_loaded_meta( $key ) ) || ( ! empty( $fallback ) ) ) {
			$output = $before . ( $this->get_loaded_meta( $key ) ? $this->filter_content( $this->get_loaded_meta( $key ) ) : $fallback ) . $after;
		}
		return $output;
	}

	public function get_option( $key, $fallback = '' ) {
		$output = false;
		if ( $this->check_array_key( $this->opts, $key ) ) {
			$output = $this->opts[ "{$key}" ];
		}
		return ( false === $output ? ( ! empty( $fallback ) ? $fallback : false ) : $output );
	}

	public function get_headline_from_option( $key, $before, $after, $fallback = '' ) {
		$output = '';
		if ( ( $this->get_option( $key ) ) || ( ! empty( $fallback ) ) ) {
			$output = $before . ( $this->get_option( $key ) ? $this->format_tags( esc_html( $this->get_option( $key ) ) ) : $fallback ) . $after;
		}
		return $output;
	}

	public function get_content_from_option( $key, $before, $after, $fallback = '' ) {
		$output = '';
		if ( ( $this->get_option( $key ) ) || ( ! empty( $fallback ) ) ) {
			$output = $before . ( $this->get_option( $key ) ? $this->filter_content( $this->get_option( $key ) ) : $fallback ) . $after;
		}
		return $output;
	}

	public function check_array_key( $item, $key ) {
		$output = false;
		if ( is_array( $item ) ) {
			if ( array_key_exists( $key, $item ) ) {
				if ( ! empty( $item["{$key}"] ) ) {
					$output = true;
				}
			}
		}
		return $output;
	}

	public function filter_content( $content ) {
		if ( ! empty( $content ) ) {
			$content = apply_filters( 'the_content', $content );
		}
		return $content;
	}
}
