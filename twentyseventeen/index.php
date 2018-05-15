<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="wrap">

	<?php
		$data['action'] = esc_url(admin_url('admin-post.php'));
		Timber::render('main.twig', $data);
	?>

	<?php
		if($_GET['city']){
			$response = wp_remote_get('http://api.openweathermap.org/data/2.5/forecast?q='.urldecode($_GET['city']).'&APPID=dca7c7172674502493dd85b847868df3&units=metric');
			$dataJSON = json_decode($response['body'], true);

			$data['desc'] = $dataJSON['list'][0]['weather'][0]['main'];
			$data['info'] = $dataJSON['list'][0]['main'];
			$data['city'] = $dataJSON['city'];

			if($data['desc'] != null) {
				Timber::render('weather.twig', $data);
			}
			else {
				$data['city'] = urldecode($_GET['city']);
				Timber::render('notfound.twig', $data);
			}
		}
	?>


			</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php get_footer();
