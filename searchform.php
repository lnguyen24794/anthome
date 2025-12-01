<?php
/**
 * The template for displaying search forms
 *
 * @package Anthome
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="position-relative">
		<input 
			type="search" 
			class="search-field" 
			placeholder="<?php echo esc_attr_x( 'Tìm kiếm...', 'placeholder', 'anthome' ); ?>" 
			value="<?php echo get_search_query(); ?>" 
			name="s" 
			required
		/>
		<button type="submit" class="search-submit">
			<i class="bi bi-search"></i>
		</button>
	</div>
</form>

 