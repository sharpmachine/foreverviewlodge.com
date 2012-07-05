jQuery(function(){

//Stick footer to the bottom
$(window).resize(function(){
	$('#bg').css({
		'min-height' : $(window).height()
	});
}).trigger('resize');

/* masonry: begin */
	var fix_masonry = false,
		$multicol = $('#multicol');

	if (fix_masonry == true) {
		$multicol.imagesLoaded( function(){
			masonry_apply();
		});
	} else {
		masonry_apply();
	}

	function masonry_apply(){

		if ($('.article_box', $multicol).length > 0) {
			$multicol.masonry({
				columnWidth: 240, 
				itemSelector: '.article_box',
				isAnimated: true, 
				animationOptions: {
					duration: 500,
					easing: 'linear'
				}
			});
		}

		if( $('.folio_box').length > 0){
			$multicol.masonry({
				columnWidth: 240, 
				itemSelector: '.folio_box',
				isAnimated: true,
				animationOptions: {
					duration: 500,
					easing: 'linear'
				}
			});
		}

	}
/* masonry: end */
});

$(function () {
   $(".hs_me").each(function () {
      this.onclick = function () {
         return hs.expand(this, config1);
      };
   });
});

jQuery.fn.attachHs = function(is_gallery) {
   if ( 2 == is_gallery) {


		if ($(this).hasClass("hs_done")) {
		} else {
			var group_id = $(this).parents('.hidden').eq(1).attr("class").replace('hidden post_', 'gal_group_');
			var slideshow_options_new = {};
			$.extend(slideshow_options_new, slideshow_options);
			slideshow_options_new.slideshowGroup = group_id;
			hs.addSlideshow(slideshow_options_new);
		}


		$(this).each(function () {

			if ($(this).hasClass("hs_done")) {
				return;
			} else {
				$(this).addClass("hs_done");
			}

			var link = $(this);

			link[0].onclick = function () {
				return hs.expand(this, {slideshowGroup: group_id, transitions: ['expand', 'crossfade']});
			};

			$(this).click(function () {
				$(link).trigger("onclick");
				return false;
			});		 

		});
   }else if( is_gallery ) {
		$(this).each(function () {
         if ($(this).hasClass("hs_done"))
            return;
         $(this).addClass("hs_done");
		 
		 
         /*var link = $(this).children("a")[0];
         if ( $(link).length > 0 )
         {
			console.log(this)
            this.onclick = function () {
               $(link).trigger("click");
            };
            link.onclick = function () {
				return hs.expand(this, config1);
			};
         }
         else
         {
            this.onclick = function () {
               return hs.expand(this, config1);
            };
         }*/
		 
		var link = $(this).find('a');

		link[0].onclick = function () {
			return hs.expand(this, config1);
		};

		$(this).click(function () {
			$(link).trigger("onclick");
			return false;
		});
		 
      });
   }
   else
   {
	  $(this).each(function () {
         if ($(this).hasClass("hs_done"))
            return;
         $(this).addClass("hs_done");
         $(this).unbind('click');
         this.onclick = function () {
            return hs.expand(this, {
               src: $(this).attr("href")
            });
         }
      });
   }
};

// menu

$(function () {
   $(".nav > ul").attr("id", "nav");
	$('#nav li ul').wrap('<div />');
	$('#nav li div').append('<i />');
	$('#nav li ul').css({
		'display': 'block'
	});
	
	$("#big-image img").each(function () {
	   var rel = $(this).attr("alt");
	   rel = rel.split('|');
	   $(this).attr("width", rel[0]);
	   $(this).attr("height", rel[1]);
	   $(this).attr("w", rel[0]);
	   $(this).attr("h", rel[1]);
	});
	
	$(".with_href").each(function () {
	   $(this).attr("href", $(this).children("a").attr("href"));
	});
	
	$("#multicol > .hidden, .to_end").each(function () {
	   var e = $(this).detach();
	   e.appendTo( $("body") );
	});
	
	if (!menu_cl)
	{
	   $("#nav a").each(function () {
	      var parent = $(this).parent().parent().parent().parent().children("a");
	      if ( parent.not( $("#nav a") ).length ) return;
	      parent.css('cursor', 'default').click(function () {
	         return false;
	      });
	   });
	}
	
});

// menu

var menu_timeout_open = false;
var menu_timeout_close = false;

$(function () {

   var menu_speed_show = 300;
   var menu_show_timeout = 300;

   $("#nav li").each(function () {
      var sub_ul = $(this).children("div");
      
      if (!sub_ul.length)
      {
         $(this).hover(function () {
            if (menu_timeout_open)
               clearTimeout(menu_timeout_open);
         },
         function () {
         });
         return;
      }
      
      prev_left = 172;
      
      var new_left = parseInt( prev_left ) - 10;
      var init_left = new_left+20;

      if ($.browser.msie && $.browser.version < 9)
      {
         sub_ul.css({
            display: 'none'
         });
      }
      else
      {
         sub_ul.css({
            display: 'block',
            opacity: 0
         });
      }
      
      $(this).hover(function () {
         if (menu_timeout_open)
            clearTimeout(menu_timeout_open);
         
         menu_timeout_open = setTimeout(function () {
            sub_ul.find("div").hide();
            if ($.browser.msie && $.browser.version < 9)
            {
               sub_ul.show();
            }
            else
            {
               sub_ul.css({
                  display: 'block',
                  opacity: 0,
                  left: init_left
               }).animate({
                  opacity: 1,
                  left: new_left
               }, {
                  duration: menu_speed_show,
                  queue: false,
                  complete: function () {
                     if ($.browser.msie) this.style.removeAttribute('filter');
                  }
               });
            }
         }, menu_show_timeout);
      },
      function () {
         sub_ul.hide();
      });
   });
   
   $("#nav").hover(function () { },function () {
      //$("#nav div").hide();
      if (menu_timeout_open)
         clearTimeout(menu_timeout_open);
   });
   
   $("#nav div").each(function () {
      var tout_hide = false;
      var d = $(this);
      d.hover(function () {
         if (tout_hide)
            clearTimeout(tout_hide);
      },
      function () {
         tout_hide = setTimeout(function () {
            d.hide();
         }, 500);
      });
   });

});

// end menu


// flickr animations
$(function () {
   $(".flickr").each(function () {
      var ee = $(this);
      ee.parent().hover(function () {
      },
      function () {
         $("i", ee).animate({
            opacity: 0
         }, {
            duration: 300,
            queue: false
         });
      });
      $("i", ee).hover(function () {
         $(this).animate({
            opacity: 0
         }, {
            duration: 300,
            queue: false
         });      
         $("i", ee).not( $(this) ).animate({
            opacity: 0.4
         }, {
            duration: 300,
            queue: false
         });
      }, function () {
         
      });
   });
});
// end flickr animations

// go up arrow
$(function () {
   $(".go_up").click(function () {
      $("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).animate({scrollTop: 0}, 500);
      return false;
   });
});
// end go up arrow

// form validation
function update_form_validation() {
   $("[placeholder]").each(function () {
      $(this).val( $(this).val().replace( $(this).attr("placeholder"), '' ) );
      //$(this).unbind().placeholder();
   });
   $("form .go_button, form .do_add_comment").unbind().click(function () {
   
      $(this).parents("form").find("input, textarea").each(function () {
         $(this).val( $(this).val().replace( $(this).attr("placeholder"), '' ) ).unbind().placeholder();
      });
      $(".formError").remove();
      
      var e=$(this).parents("form");
      e.find("input, textarea").each(function () {
         $(this).unbind();
         $(this).val( $(this).val().replace( $(this).attr("placeholder"), "" ) );
      });
      if (!e.attr("valed")) {
        if (!e.hasClass("ajax") && !e.hasClass("ajaxing"))
          e.validationEngine();
        else
          e.validationEngine({
               ajaxSubmit: true,
               ajaxSubmitFile: window.location.href
          });
      }
      e.attr("valed", "1");
      e.submit(); 
      e.find("input, textarea").each(function () {
         $(this).placeholder();
      });      
      return false;
   });
   $("form .do_clear").unbind().click(function (e) {
      $(this).parents("form").find("input, textarea").each(function () {
         $(this).val("").unbind().placeholder();
      });
      $(".formError").remove();
      
      if ($(this).attr("remove") && !$(this).parents("#form_prev_holder").length) 
      {
         move_form_to( $("#form_prev_holder") );
         $("#form_holder .do_clear").removeAttr('remove');
      }
      
      return false;
   });
}
$(update_form_validation);
// end form validation

// comments form
function move_form_to(ee)
{
      var e = $("#form_holder").html();
      var tt = $("#form_holder .header").text();
      
      var to_slide_up = ($(".comment_bg #form_holder").length ? $("#form_holder") : $(".share_com"));
      
      to_slide_up.slideUp(500, function () {
         $("#form_holder").remove();
         
         ee.append('<div id="form_holder">'+e+'</div>');
         $("#form_holder .header").html(tt);
         $("#form_holder [valed]").removeAttr('valed');
         $("#form_holder .do_clear").attr('remove', 1);
         
         if (Cufon) Cufon('#form_holder .header', {
	         fontWeight: 'bold',
	         color: '-linear-gradient(#f5f2eb, 0.5=#f5f2eb, 0.8=#acaaa4, #acaaa4)', textShadow: '-1px -1px #000'
         });
         
         $(".formError").remove();
         
         $("#form_holder").hide();
         
         to_slide_up = ($(".comment_bg #form_holder").length ? $("#form_holder") : $(".share_com"));
         if (to_slide_up.hasClass('share_com')) $("#form_holder").show();
         
         to_slide_up.slideDown(500);
         
         if (ee.attr("id") != "form_prev_holder")
         {
            $("#comment_parent").val( ee.parent().attr("id").replace('comment-', '') );
         }
         else
         {
            $("#comment_parent").val("0");
         }
         
         update_form_validation();
      });
}
$(function () {
   $(".comment .comments").click(function () {
      move_form_to( $(this).parent().parent() );
      return false;
   });
});
// end comments form

// albums

var folio_caption_fade_speed = 300;
var folio_mask_fade_slidedown_speed = 300;
var folio_desc_fade_speed = 300;

var folio_photos_bg_fade_speed = 1000;
var folio_photos_gal_fade_speed = 500;

var prev_scroll_top = 0;

function update_photos_events()
{
   if (menu_timeout_open)
      clearTimeout(menu_timeout_open);


   $("#nav div").hide();

   $('.multipics', current_album).not('.masonry').find("a").each(function() {
		var href = $(this).attr('href');
		var src = $(this).attr('data-src');
		var width = $(this).attr('data-width');
		var height = $(this).attr('data-height');
		var caption = $.trim($(this).text());
		var style = 'style="background: url(\''+src+'\')"';
		var new_html = '<a href="'+ href +'" class="go_pic size_s" '+style+' title="'+ caption +'"><img src="'+ src +'" width="'+ width +'" height="'+ height +'" alt="" /><i></i></a>';
		$(this).replaceWith(new_html);
   });
   
   //console.log('rebild album: '+current_album);
   //console.debug(current_album);
   
   $(".big_gallery", current_album).show().css('visibility', 'hidden');
	if (1) $('.multipics', current_album).masonry({
	    columnWidth: 240, 
    	temSelector: '.go_pic',
	    isAnimated: true
	});
	$(".big_gallery", current_album).css('visibility', 'visible').hide();
	
	if ( $.browser.opera || $.browser.msie && $.browser.version < 8 ) {
			$('#bg').css({
			'display': 'none'
		});
	}
	
   if (Cufon) Cufon('.big_gallery h1', {
      fontWeight: 'bold',
      color: '-linear-gradient(#f5f2eb, 0.3=#f5f2eb, #a6a39d)', textShadow: '0 -2px #000'
   }); 
   if (Cufon) Cufon('.go_back', {
      fontWeight: 'bold',
      color: '-linear-gradient(#473e2b, 0.4=#473e2b, #1c1a19)', textShadow: '0 1px #fff'
   });
  
   $(".big_gallery .go_back").unbind().click(function () {
     //$(window).scrollTop(prev_scroll_top);
     
      if ($.browser.opera)
         $(document).unbind('mousewheel');
     
     
     $(".big_gallery").fadeOut(folio_photos_gal_fade_speed, function () {
        $(".big_gallery_bg").fadeOut(folio_photos_bg_fade_speed, function () {
            $("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).animate({scrollTop: prev_scroll_top}, 500, function () {
               $('#bg').css({
                  'height': 'auto',
                  'overflow': 'visible'
               });
               if ( $.browser.opera || $.browser.msie && $.browser.version < 8 ) {
                     $('#bg').css({
                     'display': 'block'
                  });
               }
            });
        });
     });
     return false;
   });
   
   if (!$.browser.msie)
   {
      
      $(".multipics a i").css({
         display: 'block',
         opacity: 0
      });
      
      $(".multipics a, .galonelvel").hover(function () {
         $("i", this).animate({
            opacity: 1
         }, {
            duration: 500,
            queue: false
         });
      },
      function () {
         $("i", this).animate({
            opacity: 0
         }, {
            duration: 500,
            queue: false
         });
      });
   }
   	
   $(".go_pic", current_album).each(function () {
      $(this).attr("rel", "gal[g]");//.attr("title",  "");
   });

   $("a[rel=gal\\[g\\]]", current_album).attachHs(2);
	
}

var current_album = false;

$(function () {
   if ( !$(".folio").length ) return;
   
   $(".folio").each(function () {
   
      if ($(this).parent().hasClass('galonelvel')) return;
   
      var box = $(this);
   
      box.click(function () {
      
         var p_href = $(this).parent().attr("href");
         if (p_href && $(this).parent().hasClass("portfolio")) 
         {
            window.location.href = p_href;
            return false;
         }
      
         var cl = box.parent().attr("class").replace(/^.*for_(post_[0-9]+).*$/, '$1');
         current_album = $("." + cl);
         
         if (!current_album.length)
            alert("Album not found (."+cl+")");
      
         prev_scroll_top = $(window).scrollTop();
      
         $(".big_gallery", current_album).hide();
         
         $(".big_gallery_bg", current_album).css({
            display: 'block',
            opacity: 1,
            visibility: 'visible',
            'height': $("#bg").height()+"px",
            'min-height': $(window).height()+"px",
      	   //top: $(window).scrollTop()+"px"
      	   top: 0
         }).hide().fadeIn(folio_photos_bg_fade_speed, function () {
            //$(window).scrollTop(0);
            //$(".big_gallery_bg").css('top', 0);
            update_photos_events();
            $("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).animate({scrollTop: 0}, 500, function () {
               //$(".big_gallery_bg", current_album).height( $("#bg").height() );
               
               var hh =  $(".big_gallery", current_album).height() + 118;
               if ( hh < $(window).height() )
                  hh = $(window).height();
               
               $("#bg, .big_gallery_bg").css({
                  height: hh+"px",
                  overflow: 'hidden'
               });
            });
            //$("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).css({scrollTop: 0});
            //$(".big_gallery_bg", current_album).height( $(".big_gallery", current_album).height() + 80 );
            $(".big_gallery", current_album).hide().fadeIn(folio_photos_gal_fade_speed);
         });
         return false;
      });
      
      box.hover(function () {
         if ($.browser.msie)
         {
            $(".folio_just_caption", box).css({
               visibility: 'hidden'
            });
            $(".folio_mask", box).css({
               display: 'block',
               height: '100%'
            });
         }
         else
         {
            $(".folio_just_caption", box).animate({
               opacity: 0
            }, {
               queue: false,
               duration: folio_caption_fade_speed
            });
            var to_height = $(".folio_mask", box).css('height', '100%').height();
            $(".folio_mask .folio_desc", box).hide();
            $(".folio_mask", box).css({
               display: 'block',
               height: 0,
               opacity: 0
            }).animate({
               height: to_height,
               opacity: 1
            }, {
               queue: false,
               duration: folio_mask_fade_slidedown_speed,
               complete: function () {
                  $(".folio_desc", box).css({
                     display: 'block',
                     opacity: 0
                  }).animate({
                     opacity: 1
                  }, {
                     queue: false,
                     duration: folio_desc_fade_speed,
                     complete: function () {
                        if ($.browser.msie) this.style.removeAttribute('filter');
                     }
                  });
               }
            });
         }
      }, function () {
         if ($.browser.msie)
         {
            $(".folio_just_caption", box).css({
               visibility: 'visible'
            });
            $(".folio_mask", box).css({
               display: 'none',
               height: '100%'
            });
         }
         else
         {
            $(".folio_mask", box).animate({
               height: 0,
               opacity: 0
            }, {
               queue: false,
               duration: folio_mask_fade_slidedown_speed
            });
            $(".folio_just_caption", box).animate({
               opacity: 1
            }, {
               queue: false,
               duration: folio_caption_fade_speed
            });
         }
      });
   });
});
// end albums


// PIE
$(function () {
/*    $('.folio, .folio_mask, .folio_caption, .folio_just_caption').each(function() {
        if ($.browser.msie) PIE.attach(this);
    });
*/    
    $(".galonelvel").unbind().attr("rel", "gal\\[b\\]").addClass('prettyPhoto').attachHs(1);
   
   $(".wp-post-image").parent().addClass('prettyPhoto');
    
   $(".prettyPhoto").attachHs();
   
   if (!$.browser.msie)
   {
      
      $(".galonelvel i").css({
         display: 'block',
         opacity: 0
      });
      
      $(".galonelvel").hover(function () {
         $("i", this).animate({
            opacity: 1
         }, {
            duration: 500,
            queue: false
         });
      },
      function () {
         $("i", this).animate({
            opacity: 0
         }, {
            duration: 500,
            queue: false
         });
      });
   }
   
   $("#slider ul li i").css({
      display: 'block',
      opacity: 0.2
   });
   
   $("#slider ul li a").hover(function () {
      $("i", this).animate({
         opacity: 0
      }, {
         duration: 500,
         queue: false
      });
   },
   function () {
      $("i", this).animate({
         opacity: 0.2
      }, {
         duration: 500,
         queue: false
      });
   });
});
// end PIE 

// for test
$(function () {
   //$(".folio:first").click();
});


$(document).ready(function() {
	$(".toggle a.question").click(function (event) {
		event.preventDefault(); 
		$(this).toggleClass("act");
		$(this).next("div.answer").slideToggle("fast");
	});
});


function simple_tooltip(target_items, name){
 $(target_items).each(function(i){
		$("body").append("<div class='"+name+"' id='"+name+i+"'>"+$(this).find('span.tooltip_c').html()+"</div>");
		var my_tooltip = $("#"+name+i);

		$(this).removeAttr("title").mouseover(function(){
					my_tooltip.css({opacity:1, display:"none"}).fadeIn(400);
		}).mousemove(function(kmouse){
				var border_top = $(window).scrollTop();
				var border_right = $(window).width();
				var left_pos;
				var top_pos;
				var offset = 15;
				if(border_right - (offset *2) >= my_tooltip.width() + kmouse.pageX){
					left_pos = kmouse.pageX+offset;
					} else{
					left_pos = border_right-my_tooltip.width()-offset;
					}

				if(border_top + (offset *2)>= kmouse.pageY - my_tooltip.height()){
					top_pos = border_top +offset;
					} else{
					top_pos = kmouse.pageY-my_tooltip.height()-2.2*offset;
					}

				my_tooltip.css({left:left_pos, top:top_pos});
		}).mouseout(function(){
				my_tooltip.css({left:"-9999px"});
		});



	});
}

$(document).ready(function(){
	 simple_tooltip(".tooltip","tooltip_cont");
	 $(".cont_butt").click(function ()
	 {
	    //$("#order_form").submit();
	    return false;
	 });
      if ($.validationEngine) {
         $(".valForm, .uniform").each(function () {
            return;
            if ( $(this).attr("valed") ) return;
            $(this).attr("valed", "1").validationEngine({
               ajaxSubmit: true,
               ajaxSubmitFile: window.location.href
            });
         });
      }
});

$(document).ready(function(){
	$('div.framed').wrapInner( '<div />');
});
jQuery(function(){
	var win_w = $(window).width()-350;
	$('.jp-progress').css({width:win_w});
});

$('#JPlayer').find('display').css('zIndex', '999');


jQuery(function(){
	Cufon.CSS.ready(function() {
		var right_s = $('.static #pg_desc2 div, .video #pg_desc2 div').width() - $('.static #pg_desc1 div, .video #pg_desc1 div').width() + 20;
		var b = 70 +  $('.static #pg_desc2 div, .video #pg_desc2 div').height();
		
		$('.static #pg_desc1 div').css( {'right' : right_s , 'bottom' : b} );
		$('.static #pg_desc2 div').css( {'right' : 20, 'bottom' : 60 } );
		
		$('.video #pg_desc1 div').css( {'right' : right_s , 'bottom' : b} );
		$('.video #pg_desc2 div').css( {'right' : 20 , 'bottom' : 60} );
		
		Cufon('#pg_desc2 div h2', {
			  color: '-linear-gradient(#1c1a19, #473e2b)', textShadow: '1px 1px #ffffff'
		});
	});
}); 


jQuery(function() {
	function resize_mask_on_video(){
	var w_h = $(window).height();
	
	var w_w = $(window).width();
	
	var n_h = $(window).height()-39;
	

	$(".video #JPlayer_wrapper").css({
		height: w_h,
		width: w_w
	});
	$(".video.jw #big-mask").css({
		"min-height": 0,
		height: n_h
	});
	}
	
	resize_mask_on_video();
	$(window).resize(function () {
		resize_mask_on_video();
	});

});

jQuery(document).ready(function($) {
    $(".dtq-fby-form-section").wrap("<fieldset id='submit'>");
}); 