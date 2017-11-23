<?php
/**
 * The home page
 *
 * @package WordPress
 * @subpackage bebraven
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">



	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			// Get home page components based on the top-level page containing them:
			
			$home_container_ID = bz_get_id_by_slug('home-container');
			
			$args = array(
				'post_type' => 'page',
				'post_parent' => $home_container_ID,
				'post_status' => 'publish',
				'orderby' => 'menu_order',
				'order' => 'ASC',
			);
			
			$home_query = new WP_Query( $args );

			// The Loop
			if ( $home_query->have_posts() ) {
				while ( $home_query->have_posts() ) {
					$home_query->the_post();
					$component_format = (wp_get_post_terms($post->ID, 'format')) ? wp_get_post_terms($post->ID, 'format')[0]->slug : '';
					?>
					<section class="component <?php echo $post->post_name . ' ' . $component_format;?>">
						<?php 
						if (has_post_thumbnail()) {
							$thumbsize = ('half-left' == $component_format || 'half-right' == $component_format) ? 'half' : $component_format;
							the_post_thumbnail($thumbsize);
						}
						?>
						<div class="component-content">
							<h2 class="component-heading"><?php the_title(); ?></h2>
							<?php the_content(); ?>
						</div>
					</section>
					<?php 
				}
				/* Restore original Post Data */
				wp_reset_postdata();
			} else {
				// no posts found
			}
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
