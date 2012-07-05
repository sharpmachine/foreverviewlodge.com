<form method="get" class="c_search" action="<?php echo home_url('/'); ?>" >
   <input name="s" type="text" value="<?php the_search_query(); ?>" placeholder="Wanna find something?" />
   <a href="#" onClick="$('.c_search').submit(); return false;"></a>
</form>
