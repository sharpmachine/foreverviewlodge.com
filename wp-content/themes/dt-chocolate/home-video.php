<?php /* Template Name: Homepage - Video */ ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php
	global $post;
	$box_name = 'homevideo';
	$homepage_data = get_post_meta( $post->ID, 'dt_'. $box_name. '_options', true );
	if ( $homepage_data ) {
		$vid_repeat = $homepage_data['dt_vid_loop'];
		$vid_auto = $homepage_data['dt_vid_autoplay'];
		$video = $homepage_data['dt_video'];
		$hide_desc = $homepage_data['dt_hide_desc'];
		$link = $homepage_data['dt_link'];
		$hide_masc = $homepage_data['dt_hide_over_mask'];
	} else {
		$video = $hide_desc = $hide_masc = $vid_repeat = $vid_auto = $vid_control = $link = false;
	}
	
	if ( has_post_thumbnail() ) {
		$poster = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
		$poster = $poster[0];
	} else
		$poster = '';
?>
<script type="text/javascript">
		jQuery(document).ready( function(){
			var w_height = jQuery(window).height();
			var w_width = jQuery(window).width();
		<?php if ( $jwplayer_flag ): ?>
            jwplayer("JPlayer").setup({
				flashplayer: "<?php echo get_template_directory_uri(); ?>/js/jwplayer/player.swf",
				file: "<?php echo $video; ?>",
				'image': "<?php echo $poster ?>",
				autostart: <?php echo $vid_auto?'true':'false' ?>,
				bufferlength: 5,
				repeat: "<?php echo $vid_repeat?'always':'none'; ?>",
				controlbar: {position: 'bottom'},
				height: w_height,
				width: w_width,
				stretching: 'fill',
				'skin': "<?php echo get_template_directory_uri(); ?>/js/jwplayer/glows.zip"
			});
		<?php else:
			preg_match_all( '/.*\.(.*)$/', $video, $mathes );
			switch ( current($mathes[1]) ) {
				case 'flv':
					$video = 'flv: "'. $video. "\",\n";
					break;
				case ('mp4' || 'mpg4'):
					$video = 'm4v: "'. $video. "\",\n";
					break;
				default: $video = '';
			}
			
			$poster = $poster?"poster: \"". $poster. "\",\n":$poster;
			$poster = str_replace( get_site_url(), '', $poster );
			
			$vid_repeat = $vid_repeat?'ended: function() {$(this).jPlayer("play");},'."\n":'';
			$vid_auto = $vid_auto?'$(this).jPlayer("play");'."\n":'';
		?>
				$("#JPlayer").jPlayer( {
					swfPath: "<?php echo get_template_directory_uri() ?>/js/jplayer/",
					cssSelectorAncestor: "#jplayer_controlls",
					size: {
						width: w_width,
						height: w_height
					},
					ready: function() { // The $.jPlayer.event.ready event
						$(this).jPlayer("setMedia", { // Set the media
							<?php echo $video ?>
							<?php echo $poster ?>
							preload: "auto"
						});
						<?php echo $vid_auto ?>// Attempt to auto play the media
					},
					click: function( event ) {
						if( event.jPlayer.status.paused || event.jPlayer.status.waitForPlay ) {
							$(this).jPlayer("play");
						} else {
							$(this).jPlayer("pause");
						}
					},
					<?php echo $vid_repeat ?>
					solution: 'flash, html',
					supplied: 'flv, m4v',
					wmode: "opaque"
				});
		<?php endif ?>
		});
</script>
<div class="pg_content video">
	<?php if ( !$hide_desc ): ?>
		<div id="pg_desc2" class="pg_description">
		<?php if( !empty($post->post_content) ): ?>
			<div style="display:block;">
				<h2>
					<?php the_title(); ?>
				</h2>
				<p>
					<?php echo wp_kses_post( $post->post_content ); ?>
				</p>
				<?php if( !empty($link) ): ?>
				<p>
					<a class="go_more" href="<?php echo esc_url($link); ?>">
						<span>
							<i></i>
							<?php _e('Details', LANGUAGE_ZONE); ?>
						</span>
					</a>
				</p>
				<?php endif ?>
			</div>
			<div class="desc-b"></div>
		<?php endif ?>
		</div>
	<?php endif ?>
		
	<div id="JPlayer"></div>
</div><!-- .pg_content end-->

<?php if(!$hide_masc): ?>
	<div id="big-mask"></div>
<?php endif; ?>

<?php get_footer(); ?>