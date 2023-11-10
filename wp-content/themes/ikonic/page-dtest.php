<?php get_header(); ?>	

<div class="container" style="padding:2rem">
	<p>
		<a target="_blank" href="<?= hs_give_me_coffee() ?>">Click Here</a> to see a refreshing cup of coffee.
	</p>
	<p>Reload to get a new image.</p>
</div>
<div class="container" style="padding: 2rem">
	<h3>Some quotes to light up your day... I... mean <i>lighten</i>...</h3>
	<ul>
	<?php 
	foreach (tm_get_quotes() as $q) {
		echo "<li>{$q}</li>";
	}
	?>
	</ul>
</div>
<script>

	jQuery(document).ready(function($) {
		$.ajax({
			url: ajax_url,
			data:{
				boo:'ya',
				action: 'tm_projects_endpoint',
			},
			success: (response) => {
				console.log(response);
			}
		});

	});
</script>
<?php get_footer(); ?>