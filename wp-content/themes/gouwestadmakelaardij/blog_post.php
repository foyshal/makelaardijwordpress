<?php
/*
Template Name: Blog Post Gouwestad Makelaardij
*/
?>

<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>

<section>
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<div class="page-header center">
					<h3><?php single_post_title(); ?></h3>
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span3">
				<p><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( array(500,500) ); ?></a></p>
				<p><i class="icon-calendar"></i> <?php the_date(); ?> <br>
				<i class="icon-bookmark-empty"></i> <?php the_category(' '); ?> </p>
				<i class="icon-tags"></i> Tags:
				<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
				<i class="icon-print"></i> <a href="javascript:window.print()" rel="nofollow">Printen</a>
			</div>
			<div class="span8 offset1">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
</section>

<section class="graylighter smaller-font">
	<div class="container">
					        
		<div class="row-fluid">
			<div class="span12">
				<ul class="pager">
					<li>
					<?php previous_post_link('%link') ?>
					</li>
					<li>
					<?php next_post_link('%link'); ?> 
					</li>
				</ul>				  
			</div>
		</div>
 
	</div>
</section>

</article>
<?php endwhile; ?>
