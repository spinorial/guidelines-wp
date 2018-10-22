<?php
/**
 * Template Name: GuidelinesIndex
 *
 **/

get_header();?>

<div class="container">

<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<h4>Guidelines to aid with the management of patients on the intensive care unit</h4>
		
	</div>
	
</div>

<table class="table table-bordered">

	<thead class="thead-light">
		<tr>
			<td>Category</td>
			<td>Title</td>
			<td>Description</td>
			<td>Document</td>
			<td>Lead Author</td>
			<td>Created</td>
			<td>Reviewed</td>
			<td>Valid Until</td>	
		</tr>
	</thead>

<?php
    $loop = new WP_Query( array( 'post_type' => 'guideline') );
    if ( $loop->have_posts() ) : 
    	while ( $loop->have_posts() ) : $loop->the_post(); ?>



    	<tr class="<?php the_title() ?>">
    		<td><?php the_field( 'guideline_category' ); ?></td>
    		<td><?php the_field( 'guideline_title' ); ?></td>
    		<td><?php the_field( 'guideline_description' ); ?></td>
    		<td>
    			<span class="oi oi-file"></span>
    			<?php $file = get_field( 'file' ); ?>
				
				<?php if ( $file ) { ?>
					<a href="<?php echo $file['url']; ?>"><?php echo "View"; ?></a>
				<?php } ?>
    		</td>
    		<td>
    			
<?php if ( have_rows( 'lead_author' ) ) : ?>
	<?php while ( have_rows( 'lead_author' ) ) : the_row(); ?>
		<?php the_sub_field( 'title' ); ?>
		<?php the_sub_field( 'firstname' ); ?>
		<?php the_sub_field( 'surname' ); ?>
	<?php endwhile; ?>
<?php else : ?>
	<?php // no rows found ?>
<?php endif; ?>
    		</td>
    		<td><?php echo get_the_date(); ?></td>
    		<td><?php echo get_the_modified_date(); ?></td>
    		<td></td>
    	</tr>

        	
         
        <?php endwhile;
    endif;
    wp_reset_postdata();
?>

</table>

</div>

<?php get_footer(); ?>