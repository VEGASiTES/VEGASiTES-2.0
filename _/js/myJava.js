// globals
var theme = "/wp-content/themes/vegasites_2.0/",
me,
fbID,
fbToken,
fbFirstname,
fbFullname,
fbPhoto,
fbWebsite,
fbURL,
fbEmail,
fbStatus;


// ************************** READY ***************************
$(function() { //ready

$('.iconV').click(function() {  
	$('.more').slideToggle(200, 'swing');
});

$('ul.navWrap').hover(function() { 
	$('li.outside').stop().animate({ height: '350px' }, 150, 'swing');
}, function() { 
	$('li.outside').stop().animate({ height: '40px' }, 150, 'swing');
});	

/* !lightbox images */
/* ================================================== */
$('a[rel="lightbox"]').click(function(){
	var thisImg = $(this).attr('href');
	$('.lightbox').html('<div class="picHolder"><img src="' + thisImg + '" /></div>').fadeIn();
	return false;
})

$('.lightbox').click(function(){
	$(this).fadeOut();
})

//getTweets('vegasites', '10', '.vegasitesTweets')

// ************************** forms ***************************
$('.form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    var post_url = form.attr('action');
    var post_data = form.serialize();
    if (form.hasClass('dark')) {
    	var loader = 'loader-lightOnDark.gif';
    } else {
    	var loader = 'loader-darkOnLight.gif';
    }
    $('.loadForm', form).html("<img src='" + theme + "_/img/" + loader + "' alt='loading' width='24' height='24' class='loading' />");
    $.ajax({
    	type: 'POST',
    	url: post_url,
    	data: post_data,
    	success: function(msg) {
    		$('.loadForm', form).fadeOut(500, function(){
    			$(".errorSuccess", form).html(msg).fadeIn();
    		});
    	}
    });
    $(".errorSuccess", form).click(function(){
    	$('.loadForm', form).html("<input type='submit' class='submit' name='submit' value='Send' />");
    	$(".errorSuccess", form).fadeOut(500, function(){
    		$('.loadForm', form).fadeIn();
    	});
    });
});
	
	
$('.sliderNav .prev').click(function() { 
	var pos = slider.getPos();
	if (pos != '0') {
		slider.prev();
	}
});

$('.sliderNav .next').click(function() { 
	var pos = slider.getPos();
	if (pos != '8') {
		slider.next();
	};
});

$('.navDot').click(function() { 
	var getTo = $(this).attr('id');
	slider.slide(getTo, 400);
	$('.navDot').removeClass('selected');
	$(this).addClass('selected');
});

var slider = new Swipe(document.getElementById('slider'), {
	  speed: 400,
	  //auto: 4000,
	  callback: function() {
	      var pos = slider.getPos();
	      $('.navDot').removeClass('selected');
	      $('.navDot.' + pos).addClass('selected');
      }
});
	
// ************************** END READY ***************************
}); //end ready


// ************************** functions ***************************
function scrollToTop(){
     	$('html,body').animate({scrollTop: '0'},'fast');
}

function scrollToID(id){
     	$('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
}

function replaceTags() {
	$("a[rel='tag']").each(function() {
	    this.setAttribute("href", this.getAttribute("href").replace("tag/", "#/tag:"));
	});

	$("a[rel='tag']").each(function() {
    	var href = this.getAttribute("href");
    	this.setAttribute("href", href.substr(0, href.length-1) + "");
	});
}

function checkUser(fbID,fbToken) {
	$.ajax({
		type: 'POST',
		url: theme + '_/services/user-check.php?UID=' + fbID+"&token="+fbToken,
		dataType: "json",
		success: function(data) {
			if (!data['authenticated']){ //user is not correctly authenticated
				//window.location=""; //send them somewhere
				return;
			}
			if (!data['userfound']) { //didn't find the user
				//location = '/finish-registration';
			}
		}
	});
	$.getJSON(theme + '_/services/jobs.php', function(data) {});
}


// ************************** twitter ***************************
function getTweets(username, count, div) { 
	$.ajax({
    url: 'http://api.twitter.com/1/statuses/user_timeline.json/',
    type: 'GET',
    dataType: 'jsonp',
    data: {
        screen_name: username,
        include_rts: true,
        count: count,
        include_entities: true
    },
    success: function(data, textStatus, xhr) {

         var html = '<div class="tweet">TWEET_TEXT</div><div class="time">AGO</div>';
 
         // append tweets into page
         for (var i = 0; i < data.length; i++) {
            $(div).append(
                html.replace('TWEET_TEXT', data[i].text )
                    .replace(/USER/g, data[i].user.screen_name)
                    .replace('AGO', data[i].created_at)
                    //.replace(/ID/g, data[i].id_str)
            );
         }                  
    }   
    });
}


// ************************** FACEBOOK ***************************
// Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));

// Init the SDK upon load
window.fbAsyncInit = function() {
    FB.init({
      appId      : '186397981389259', // App ID
      channelUrl : '//PREVIEW.VEGASITES.COM/wp-content/themes/vegasites_2.0/channel.php', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

FB.Event.subscribe('auth.statusChange', function(response) {
	if (response.authResponse) {
		// user has auth'd your app and is logged into Facebook
		fbID = response.authResponse.userID,
		fbToken = response.authResponse.accessToken;
		FB.api('/me', function(user) {
			if (user) {
				fbFirstname = user.first_name,
				fbFullname = user.name,
				fbPhoto = 'https://graph.facebook.com/' + user.id + '/picture?type=large',
				fbWebsite = user.website,
				fbURL = user.link,
				fbEmail = user.email;
				$('.fbPic').css('background-image', 'url("' + fbPhoto + '")');
				$('.fbName').html('Hi, ' + fbFirstname + '!');
				
				$('.fbLogout').click(function() {  
					FB.logout();
				})
				
			} // end if user
		}); // end fb ME
		
		$('.notConnected').hide();
		$('.connected').fadeIn();
		
		checkUser(fbID,fbToken);

	} else {
		
		$('.notConnected').fadeIn();
		$('.connected').hide();
		
	}; // end auth status change
});

$('#fbConnect').click(function() { 
      FB.login(function(response) {
	      // handle the response
	  }, {scope: 'email,user_birthday,user_website,user_checkins,user_events,user_photos,user_status,friends_photos,publish_stream,status_update,photo_upload,share_item,publish_checkins'}
	  );
});
  

} // end FB SDK
