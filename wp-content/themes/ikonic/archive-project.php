<?php get_header() ?>
<ul>
	<h3>Projects</h3>
	<?php 
	while (have_posts()) {
		the_post();
		echo "<li>";
		the_title();		
		echo "</li>";
	}
	?>
</ul>
<div class="pagination">
	<div class="pag_link pag_older"><?php next_posts_link( 'Older posts' ); ?></div>
	<div class="pag_link pag_newer"><?php previous_posts_link( 'Newer posts' ); ?></div>
</div>

<?php get_footer(); ?>