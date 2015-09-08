<?php
/**
 * @package Parament
 */

get_header(); ?>

<div id="container" class="contain">

	<div id="main" role="main">
		<article class="page type-page hentry entry-content">
			<?php woocommerce_content(); ?>
			<?php comments_template(); ?>
		</article>
	</div><!-- end main -->

	<?php get_sidebar(); ?>

</div><!-- end container -->

<?php get_footer(); ?>
