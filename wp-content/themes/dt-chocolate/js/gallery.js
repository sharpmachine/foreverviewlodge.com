var slideshow_timeout_sec = 5000;

var slider_sequential = false;

var current_big_image = 0;

function images_loaded() {
   
   $("#big-image li img").each(function () {
      var img = $(this);
      
      img.css({
         width: 'auto',
         'min-height': '0px',
         visibility: 'visible'
      });
      
      img.removeAttr("width").removeAttr("height");
      
      var img_w = parseInt( img.attr("w") );
      var img_h = parseInt( img.attr("h") );
      var current_img_prop = img_w/img_h;
      
      $(window).resize(function () {
         if ( img.parent().index() != current_big_image )
            return;
         
         var window_h = $(window).height();
         var window_w = $(window).width();
         var h = window_h;
         var w = window_w;
         var w_margin = 0;
         var h_margin = 0;
         
         var current_prop = window_w/window_h;
         
         
         if (current_prop > current_img_prop)
         {
            w = window_w;
            h = w / current_img_prop;  
         }
         else
         {
            h = window_h;
            w = h * current_img_prop;  
         }
         w_margin = (window_w - w) / 2;
         h_margin = (window_h - h) / 2;
         
         img.css({
            height: h+"px",
            width:  w+"px",
            marginLeft: w_margin+"px",
            marginTop: h_margin+"px"
         });
      });
   });
   $(window).trigger('resize');
}

$(function () {
   if ( !$("#slider li").length ) return;
   
   var els = $("#big-image li img");
   current_big_image = $("#big-image li").length - 1;
   var current_loaded = 0;
   
   els.each(function () {
      $(this).bind('load', function () {
         //alert("loaded");
         current_loaded++;
         if (current_loaded == els.length)
         {
            $("#loading").hide();
            $("#big-image").css('visibility', 'visible');
            images_loaded();
         }
      });
      $(this).attr("src", $(this).attr("src"));
      if ( $(this)[0].complete )
         $(this).trigger("load");
   });
   
   if ($.browser.msie)
      $("#slider i").remove();
});

$(function () {   
   if ( !$("#slider li").length )
   {
      $("#loading").html("Please add some albums and photos to use this functionality.");
      $("#loading").css({
         'text-align': 'center',
         'background': 'none'
      });
      return;
   }
   
   var speed_anim = 1000;
   var slider = $("#slider ul");
   var previous_elements = slider.children();
   var len   = previous_elements.length;
   var one_w = 100;
   var pad   = 10;

   var now_cols = 1;
   var ww = 0;

   do {

      now_cols+=2;

      ww = (one_w*len*now_cols + pad*len*now_cols + 10*len*now_cols);

      $("#slider").css({
         width: ww+"px"
      });
      
      slider.prepend( previous_elements.clone() ).append( previous_elements.clone() );
   
   } while ( ww < $(window).width()*3 );
   
   var nn = 0;
   slider.children().each(function () {
      $(this).attr("n", nn);
      //$(this).append(nn);
      nn++;
   });
   
   //$("#slider_controls ul").append( slider.children().clone() );
   
   var middle_col = (now_cols-1)/2;
   
   var current_n = len*middle_col;
   function get_left(n, check) {
      if (!check)
      {
         /*
         if (n >= len*2)
         {
            set_slider_to(len - (current_n - n));
            n -= len;
         }
         if (n <= len-1)
         {
            set_slider_to(len*2);
            n += len;
         }
         */
         if (n >= len*(middle_col+1))
         {
            set_slider_to(current_n-len);
            n -= len;
         }
         if (n <= (len-1)*(middle_col))
         {
            set_slider_to(current_n+len);
            n += len;
         }
      }
      var v = one_w*n + pad*n + 10 + (n-1)*10;
      v *= -1;
      current_n = n;
      return v;
   }
   
   function set_slider_to(n) {
      var l = get_left(n, true);
      slider.css({
         left: l+"px"
      });
      return l;
   }
   
   set_slider_to(current_n);
   
   var allow_animation = true;
   
   $("#big-image li").css('zIndex', 1);
   $("#big-image li:eq("+(current_big_image)+")").css('zIndex', 10);
   
   slider.children().click(function () {
      var this_n = parseInt( $(this).attr("n") );
      if (!allow_animation)
         return false;
      allow_animation = false;
      
      var new_index_big_image = this_n;
      while (new_index_big_image >= len)
         new_index_big_image -= len;
      new_index_big_image = len - new_index_big_image - 1;
         
      var buf = current_big_image;
      current_big_image = new_index_big_image;
      $(window).trigger("resize");
      current_big_image = buf;
      
      var new_slide = $(this).clone();
      $("#slider_controls ul").prepend(new_slide);   

      $("#big-image li:eq("+(current_big_image)+")").css('zIndex', 10);
      $("#big-image li:eq("+(new_index_big_image)+")").css('zIndex', 5);
      
      var sequential = slider_sequential;
      
      slider.animate({
         left: get_left(this_n)+"px"
      }, {
         duration: speed_anim,
         queue: false,
         step: function (now, fx) {
            if (!sequential)
               return;
            if (fx.prop == "left") {
               var howmuch = fx.start - now;
               var all = fx.start - fx.end;
               var proc = Math.abs(howmuch/all);
               
               howmuch*=1*(102/Math.abs(all));
               
               /*
               $("#slider_controls ul li:eq(1)").css('left', (-1*howmuch)+"px");
               $("#slider_controls ul li:eq(0)").css('left', (all/Math.abs(all)*102-howmuch)+"px");
               */
               
               $("#big-image li:eq("+(current_big_image)+")").css('opacity', 1-proc);
               //$("#big-image li:eq("+(new_index_big_image)+")").css('opacity', proc);
               
               $("#slider_controls ul li:eq(1)").css('opacity', 1-proc);
               //$("#slider_controls ul li:eq(0)").css('opacity', proc);
            }
         },
         complete: function () {
            if (!sequential)
            {
               $("#big-image li:eq("+(current_big_image)+")").animate({
                  opacity: 0
               }, {
                  duration: speed_anim,
                  complete: function () {
                     allow_animation = true;
                     $("#slider_controls ul li:eq(1)").remove();
                     $("#big-image li:eq("+(current_big_image)+")").css('zIndex', 1).css('opacity', 1);
                     $("#big-image li:eq("+(new_index_big_image)+")").css('zIndex', 10);
                     current_big_image = new_index_big_image; 
                     if ($("#control_pause").is(":visible"))
                        restart_slideshow();  
                  }
               });
               $("#slider_controls ul li:eq(1)").animate({
                  opacity: 0
               }, {
                  duration: speed_anim,
                  complete: function () {
                  }
               });
               return;
            }
            allow_animation = true;
            $("#slider_controls ul li:eq(1)").remove();
            $("#big-image li:eq("+(current_big_image)+")").css('zIndex', 1).css('opacity', 1);
            $("#big-image li:eq("+(new_index_big_image)+")").css('zIndex', 10);
            current_big_image = new_index_big_image; 
            if ($("#control_pause").is(":visible"))
               restart_slideshow();  
         }
      });
      
      return false;
   });
   
   $("#control_b, #control_f").click(function () {
      if (slideshow_timeout)
         clearTimeout(slideshow_timeout);
      var p = ( $(this).attr("id") == "control_b" ? -1 : 1 );
      slider.find("li[n="+(current_n+p)+"]").trigger("click");
      if ($("#control_pause").is(":visible"))
         restart_slideshow();  
      return false;
   });
   
   var slideshow_timeout = false;
   function restart_slideshow() {
      if (slideshow_timeout)
         clearTimeout(slideshow_timeout);
      slideshow_timeout = setTimeout(function () {
         $("#control_f").trigger("click");
         restart_slideshow();  
      }, slideshow_timeout_sec);
   }
   
   $("#control_play").click(function () {
      restart_slideshow();   
      $(this).hide();
      $("#control_pause").show();
      return false;
   });

   $("#control_pause").click(function () {
      if (slideshow_timeout)
         clearTimeout(slideshow_timeout);
      $(this).hide();
      $("#control_play").show();
      return false;
   });   
   
   $("#control_play").trigger("click");
   
});
