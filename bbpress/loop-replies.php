<?php

/**
 * Replies Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_replies_loop' ); ?>

<ul id="topic-<?php bbp_topic_id(); ?>-replies" class="forums bbp-replies">

	<li class="bbp-header">

		<div class="bbp-reply-author"><?php  _e( 'Author',  'bbpress' ); ?></div><!-- .bbp-reply-author -->

		<div class="bbp-reply-content">

			<?php if ( !bbp_show_lead_topic() ) : ?>

				<?php _e( 'Posts', 'bbpress' ); ?>

				<?php bbp_topic_subscription_link(); ?>

				<?php bbp_user_favorites_link(); ?>

			<?php else : ?>

				<?php _e( 'Replies', 'bbpress' ); ?>

			<?php endif; ?>

		</div><!-- .bbp-reply-content -->

	</li><!-- .bbp-header -->

	<li class="bbp-body">

		<?php if ( bbp_thread_replies() ) : ?>

			<?php bbp_list_replies(); ?>

		<?php else : ?>

			<?php while ( bbp_replies() ) : bbp_the_reply(); ?>

				<?php bbp_get_template_part( 'loop', 'single-reply' ); ?>

			<?php endwhile; ?>

		<?php endif; ?>

	</li><!-- .bbp-body -->

	<li class="bbp-footer">

		<div class="bbp-reply-author"><?php  _e( 'Author',  'bbpress' ); ?></div>

		<div class="bbp-reply-content">

			<?php if ( !bbp_show_lead_topic() ) : ?>

				<?php _e( 'Posts', 'bbpress' ); ?>

			<?php else : ?>

				<?php _e( 'Replies', 'bbpress' ); ?>

			<?php endif; ?>

		</div><!-- .bbp-reply-content -->

	</li><!-- .bbp-footer -->

</ul><!-- #topic-<?php bbp_topic_id(); ?>-replies -->

<?php do_action( 'bbp_template_after_replies_loop' ); ?>

<script type="text/javascript">
jQuery("#bbp_reply_content").removeClass("wp-editor-area");
jQuery("a.bbp-topic-reply-link, a.bbp-reply-to-link").click(function(e){
    e.preventDefault();
    var editor = jQuery("#bbp_reply_content");
    if(!editor.length) return;
    var admin_link = jQuery(this).parent(".bbp-admin-links");
    if(!admin_link.length) return;
    var menu_order = admin_link.siblings(".bbp-reply-permalink").first();
    if(!menu_order.length) return;
    var author = admin_link.parent().parent().next().
                 children(".bbp-reply-author").first().
                 children(".bbp-author-name").first();
    if(!author.length) return;
    
    var msg = "回复 " + "<a href='" + menu_order.attr("href") + "'>" +
              menu_order.text() + "</a> 的 " + "<a href='" +
              author.attr("href") +"'>" +
              author.text() + "</a>：\n"
    
    editor.focus();
    editor.val(editor.val() + msg);
    editor.focus();
});
</script>