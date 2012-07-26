<?php global $theme; ?>

    <div id="footer" class="black_gradient">
        <a href="<?php echo home_url(); ?>" class="back_button black_button"><?php $theme->option('home_button'); ?></a>
        <div class="page_title"><?php $theme->option('footer_text'); ?></div>
        <a onClick="jQuery('html, body').animate( { scrollTop: 0 }, 'slow' );"  href="javascript:void(0);" id="top" class="black_button"><?php $theme->option('top_button'); ?></a>
        <div class="clear"></div>
    </div>

<?php wp_footer(); ?>
<?php $theme->option('analytics_code'); ?>
<script type="text/javascript">
$(".videocontainer").fitVids();
</script>
</body>
</html>
