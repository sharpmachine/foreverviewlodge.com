<?php
/**
 * @package WordPress
 * @subpackage Chocolate
 */
?>

<?php if(!is_page_template('home-static.php')) : ?>
	</div>
<?php endif; ?>

<?php
if (!defined('GAL_HOME'))
   get_template_part( 'bottom' );
?>


</div>



<?php get_template_part('demo'); ?>

<?php wp_footer(); ?>


</body>
</html>
