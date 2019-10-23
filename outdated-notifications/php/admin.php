<?php

defined( 'ABSPATH' ) || exit;

?>

<div class="wrap">
	<h1 class="wp-heading-inline">Outdated Pages</h1>
	<hr class="wp-header-end">

	<?php 
	// the query
	$paged = isset($_GET['paged']) ? $_GET['paged'] : 1; 
	$args = array(
		'post_type'			=> 'page',
		'post_status'		=> 'publish',
		'posts_per_page'	=> 25,
		'paged'				=> $paged,
		'orderby'			=> 'modified',
		'order' 			=> 'ASC',
		'date_query' 		=> array(
								array(
									'column' => 'post_modified',
									'before'  => '3 months ago',
								),
		),
	);

	$custom_query = new WP_Query($args); ?>

		<table class="outdated-pages wp-list-table widefat fixed striped pages">
			<thead>
				<tr>
					<th>Page Title</th>
					<th>Last Updated</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>

			<!-- the loop -->
			<?php if ( $custom_query->have_posts() ) :  while ( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

				<tr>
					<td><strong><a href="<?php echo the_permalink(); ?>" target="_blank" title="View '<?php the_title(); ?>'"><?php the_title(); ?></a></strong></td>
					<td><?php the_modified_date(); ?></td>
					<td class="actions">
						<a href="<?php echo the_permalink(); ?>" title="View '<?php the_title(); ?>'"><i class="fas fa-fw fa-eye"></i></a>
						<a href="<?php echo get_edit_post_link(); ?>" title="Edit '<?php the_title(); ?>'"><i class="fas fa-fw fa-pencil-alt"></i></a>
					</td>
				</tr>

			<?php endwhile; ?>
			<?php else : ?>
				<tr>
					<td colspan="3"><?php _e( 'There are no outdated pages. Great job!' ); ?></td>
				</tr>
			<?php endif; ?>
			<!-- end of the loop -->

			</tbody>
			<tfoot>
				<tr>
					<th>Page Title</th>
					<th>Last Updated</th>
					<th>Actions</th>
				</tr>
			</tfoot>
		</table>

		<div class="tablenav bottom">

			<div class="alignleft">

				<span class="pagination-links">
					<?php
						$big = 999999999; // need an unlikely integer
						echo paginate_links( array(
						    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						    'format' => '?paged=%#%',
						    'current' => max( 1, $paged ),
						    'total' => $custom_query->max_num_pages
						) );
					?>
				</span>
				
			</div>

			<div class="tablenav-pages">

				<span class="displaying-num">
					<?php

						$count = $custom_query->found_posts;

						echo $count . ' items';
					?>
				</span>
				
			</div>

		</div>

		<?php wp_reset_postdata(); ?>

		<style type="text/css">
			.outdated-pages {
				margin-top: 10px;
			}

			.outdated-pages .actions a {
				font-size: 1.2em;
				margin-right: 10px;
			}

			.page-numbers {
				margin-right: 3px;
			}
		</style>

</div>
