<?php
if( get_next_posts_link() || get_previous_posts_link() ) {
?>
  <!-- post pagination -->
  <nav id="pagination">
  	<div class="container container-small">
	  	<div class="row">
<?php
$right = url_get_contents( get_bloginfo('stylesheet_directory') . '/img/arrow-right.svg' );
$left = url_get_contents( get_bloginfo('stylesheet_directory') . '/img/arrow-left.svg' );

$previous = get_previous_posts_link($left);
$next = get_next_posts_link($right);
if ($previous && $next) {
?>
				<span class="col into-2 u-align-left"><?php echo $previous; ?></span>
				<span class="col into-2 u-align-right"><?php echo $next; ?></span>
<?php
} else if ($previous && !$next) {
?>
				<span class="col into-1 u-align-left"><?php echo $previous; ?></span>
<?php
} else if ($next && !$previous) {
?>
	  		<span class="col into-1 u-align-right"><?php echo $next; ?></span>
<?php
}
?>
			</div>
		</div>
  </nav>
<?php
}
?>