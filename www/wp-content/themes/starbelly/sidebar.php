<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package starbelly
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<div class="sb-sidebar-frame sb-pad-type-1 content-sidebar">
    <aside id="secondary" class="sb-sidebar widget-area">
      <?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside>
</div>
