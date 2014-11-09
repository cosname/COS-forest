<?php

/* bbpress/includes/forums/template.php */
function bbp_list_forums_mod( $args = '' ) {

	// Define used variables
	$output = $sub_forums = $topic_count = $reply_count = $counts = '';
	$i = 1;
	$count = array();

	// Parse arguments against default values
	$r = bbp_parse_args( $args, array(
		'before'            => '<ul class="bbp-forums-list">',
		'after'             => '</ul>',
		'link_before'       => '<li class="bbp-forum">',
		'link_after'        => '</li>',
		'count_before'      => ' (',
		'count_after'       => ')',
		'count_sep'         => ', ',
		'separator'         => ', ',
		'forum_id'          => '',
		'show_topic_count'  => true,
		'show_reply_count'  => true,
	), 'list_forums' );

	// Loop through forums and create a list
	$sub_forums = bbp_forum_get_subforums( $r['forum_id'] );
	if ( !empty( $sub_forums ) ) {

		// Total count (for separator)
		$total_subs = count( $sub_forums );
		foreach ( $sub_forums as $sub_forum ) {
      $i++;

			// Get forum details
			$count     = array();
			$permalink = bbp_get_forum_permalink( $sub_forum->ID );
			$title     = bbp_get_forum_title( $sub_forum->ID );

			// Show topic count
			if ( !empty( $r['show_topic_count'] ) && !bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['topic'] = bbp_get_forum_topic_count( $sub_forum->ID );
			}

			// Show reply count
			if ( !empty( $r['show_reply_count'] ) && !bbp_is_forum_category( $sub_forum->ID ) ) {
				$count['reply'] = bbp_get_forum_reply_count( $sub_forum->ID );
			}

			// Counts to show
			if ( !empty( $count ) ) {
				$counts = $r['count_before'] . implode( $r['count_sep'], $count ) . $r['count_after'];
			}

			// Build this sub forums link
      $evenodd = 'odd';
      if($i % 2 == 0) $evenodd = 'even';
      $output .= '<ul id="bbp-forum-'. $sub_forum->ID. '"'. 'class="forum subforum '.$evenodd .'">';
      $output .= '<li class="bbp-forum-info">';
      $output .= '<a class="bbp-forum-title" href="'. esc_url( $permalink ). '">';
      $output .= $title. '</a>';
      $output .= '<div class="bbp-forum-content">'. bbp_get_forum_content($sub_forum->ID). '</div>';
      $output .= '</li>';
      $output .= '<li class="bbp-forum-topic-count">'. $count['topic']. '</li>';
      $output .= '<li class="bbp-forum-reply-count">'. $count['reply']. '</li>';
      $output .= '<li class="bbp-forum-freshness">';
	    //$output .= bbp_get_forum_freshness_link($sub_forum->ID);
      $output .= '</li></ul>';
		}

		// Output the list
		echo apply_filters( 'bbp_list_forums', $output, $r );
	}
}

/* bbpress/includes/replies/template.php */
function bbp_reply_menu_order() {
  $bbp = bbpress();

	if ( !empty( $bbp->reply_query->in_the_loop ) && isset( $bbp->reply_query->post->menu_order ) ) {
	  $menu_order = $bbp->reply_query->post->menu_order + 1;
  } else {
    $menu_order = '火星';
  }
  echo $menu_order;
}

/* Implementation of [code] and [data] tags */
function shortcode_code( $atts, $content = null ) {
    $a = shortcode_atts( array( 'lang' => '' ), $atts );
    $lang = $a['lang'];
    // Remove line break (from old bbs)
    $clean_content = str_ireplace( '<br />', '', $content );
    // Remove p tag (from old bbs)
    $clean_content = str_ireplace( '<p>', '', $clean_content );
    $clean_content = str_ireplace( '</p>', '', $clean_content );
    $clean_content = esc_html( $clean_content );
    return '<pre class="highlight ' . $lang . '">' . $clean_content . '</pre>';
}
add_shortcode( 'code', 'shortcode_code' );

function shortcode_data( $atts, $content = null ) {
    $clean_content = str_ireplace( '<br />', '', $content );
    $clean_content = str_ireplace( '<p>', '', $clean_content );
    $clean_content = str_ireplace( '</p>', '', $clean_content );
    $clean_content = esc_html( $clean_content );
    return '<pre>' . $clean_content . '</pre>';
}
add_shortcode( 'data', 'shortcode_data' );


?>