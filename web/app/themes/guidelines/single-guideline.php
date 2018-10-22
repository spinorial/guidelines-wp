<?php get_header() ?>
<?php acf_form_head(); ?>

<div class="row">
<table class="table table-bordered">
	<thead class="thead-light">
	<tr>
		<td>Category</td>
		<td>Title</td>
		<td>Description</td>
		<td>Active Until</td>
		<td>Lead Author</td>
		<td>Download</td>
	</tr>
	</thead>
	<tr>
		<td>
			<?php $guideline_category_array = get_field( 'guideline_category' ); ?>
			<?php if ( $guideline_category_array ): ?>
				<?php foreach ( $guideline_category_array as $guideline_category_item ): ?>
				 	<?php echo $guideline_category_item; ?>
				<?php endforeach; ?>
			<?php endif; ?>	
		</td>
		<td> 
			<?php the_field( 'guideline_title' ); ?>
		</td>
		<td>
			<?php the_field( 'guideline_description' ); ?>
		</td>
		<td></td>
		<td></td>
		<td><?php $file = get_field( 'file' ); ?>
<?php if ( $file ) { ?>
	<a href="<?php echo $file['url']; ?>"><?php echo $file['filename']; ?></a>
<?php } ?></td>
	</tr>
</table>



</div>





	<div id="primary" class="content-area">
		<div id="content">

			<?php acf_form('new-event'); ?>

		</div><!-- #content -->
	</div><!-- #primary -->



<?php get_footer() ?>