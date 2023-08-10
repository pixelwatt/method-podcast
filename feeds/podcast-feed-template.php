<?php
header('Content-Type: text/xml');
$util = new Method_Podcast_Utilities();

echo '<?xml version="1.0" encoding="UTF-8"?><rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0"><channel>';
echo ( $util->get_option( 'channel_title' ) ? '<title>' . $util->get_option( 'channel_title' ) . '</title>' : '' );
echo ( $util->get_option( 'channel_desc' ) ? '<description><![CDATA[' . apply_filters( 'the_content', $util->get_option( 'channel_desc' ) ) . ']]></description>' : '' );
if ( $util->get_option( 'channel_artwork' ) ) {
	echo '<itunes:image href="' . $util->get_option( 'channel_artwork' ) . '"/>';
	if ( ( $util->get_option( 'channel_title' ) ) && ( $util->get_option( 'channel_link' ) ) ) {
		echo '<image><url>' . $util->get_option( 'channel_artwork' ) . '</url><title>' . $util->get_option( 'channel_title' ) . '</title><link>' . $util->get_option( 'channel_link' ) . '</link></image>';
	}
}
echo '<language>' . $util->get_option( 'channel_language', 'en-us' ) . '</language>';
if ( $util->get_option( 'channel_itunes_categories' ) ) {
	if ( is_array( $util->get_option( 'channel_itunes_categories' ) ) ) {
		if ( 0 < count( $util->get_option( 'channel_itunes_categories' ) ) ) {
			foreach ( $util->get_option( 'channel_itunes_categories' ) as $cat ) {
				if ( ! empty( $cat ) ) {
					$cata = explode( ", ", $cat );
					if ( 1 < count( $cata ) ) {
						echo '<itunes:category text="' . $cata[0] . '"><itunes:category text="' . $cata[1] . '"/></itunes:category>';
					} elseif ( 1 == count( $cata ) ) {
						echo '<itunes:category text="' . $cata[0] . '"/>';
					} else {
						// Welp, no categories
					}
				}
			}
		}
	}
}
echo '<itunes:explicit>' . ( 'on' == $util->get_option( 'channel_explicit' ) ? 'true' : 'false' ) . '</itunes:explicit>';
echo ( $util->get_option( 'channel_author' ) ? '<itunes:author>' . $util->get_option( 'channel_author' ) . '</itunes:author>' : '' );
if ( ( $util->get_option( 'channel_owner_email' ) ) && ( $util->get_option( 'channel_owner_name' ) ) ) {
	echo '<itunes:owner><itunes:name>' . $util->get_option( 'channel_owner_name' ) . '</itunes:name><itunes:email>' . $util->get_option( 'channel_owner_email' ) . '</itunes:email></itunes:owner>';
}
echo ( $util->get_option( 'channel_copyright' ) ? '<copyright>' . $util->get_option( 'channel_copyright' ) . '</copyright>' : '' );
echo ( $util->get_option( 'channel_link' ) ? '<link>' . $util->get_option( 'channel_link' ) . '</link>' : '' );
echo '<atom:link href="' . get_bloginfo('url') . '/podcast-feed" rel="self" type="application/rss+xml"/>';
$args = array(
	'post_type' => 'method_podcast',
	'posts_per_page' => -1,
	'post_status' => 'publish',
	'order' => 'DESC',
	'fields' => 'ids',
);
$items = get_posts( $args );
if ( $items ) {
	if ( is_array( $items ) ) {
		if ( 0 < count( $items ) ) {
			foreach ( $items as $item ) {
				$util->load_meta( $item );
				$desc = $util->get_loaded_meta( '_method_podcast_desc' );
				echo '<item>';
				echo '<title>' . get_the_title( $item ) . '</title>';
				echo '<guid>' . $item . '</guid>';
				echo '<pubDate>' . get_the_time( 'r', $item ) . '</pubDate>';
				echo ( $util->get_loaded_meta( '_method_podcast_artwork' ) ? '<itunes:image href="' . $util->get_loaded_meta( '_method_podcast_artwork' ) . '"/>' : '' );
				echo '<itunes:explicit>' . ( 'on' == $util->get_loaded_meta( '_method_podcast_explicit' ) ? 'true' : 'false' ) . '</itunes:explicit>';
				echo '<description><![CDATA[' . apply_filters( 'the_content', ( ! empty( $desc ) ? $desc : get_the_content( null, false, $item ) ) ) . ']]></description>';
				if ( ( $util->get_loaded_meta( '_method_podcast_file' ) ) && ( $util->get_loaded_meta( '_method_podcast_length' ) ) ) {
					echo '<enclosure url="' . $util->get_loaded_meta( '_method_podcast_file' ) . '" length="' . $util->get_loaded_meta( '_method_podcast_length' ) . '" type="' . $util->get_loaded_meta( '_method_podcast_type', 'audio/mpeg' ) . '" />';
				}
				echo ( $util->get_loaded_meta( '_method_podcast_duration' ) ? '<itunes:duration>' . $util->get_loaded_meta( '_method_podcast_duration' ) . '</itunes:duration>' : '' );
				echo '</item>';
				$util->unload_meta();
			}
		}
	}
}
echo '</channel></rss>';