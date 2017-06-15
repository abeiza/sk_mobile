(function () {

  "use strict";

  var app = new Framework7;
  var $$ = Dom7;
  var viewMain = app.addView('#view-main');
  var pullToRefreshPosts = $$('#content-posts');

  // When pullToRefresh is called
  pullToRefreshPosts.on('refresh', function (e) {

    // Simulation of an Ajax request for demo
    setTimeout(function(){
      $$('#post-list').prepend(
        '<li>'+
          '<a href="post.html">'+
            '<div class="post-thumbnail"><img src="img/thumbnails/image14.jpg"></div>'+
            '<div class="post-infos">'+
              '<div class="post-title"><span>Wow, pull-to-refresh seems to work well !</span></div>'+
              '<div class="post-category green">Business</div>'+
              '<div class="post-date"><i class="icon ion-android-time"></i>12 minutes ago</div>'+
            '</div>'+
          '</a>'+
        '</li>'
      );
      app.pullToRefreshDone(pullToRefreshPosts);
    }, 1500);
  });

  var isLoading = false;

  // When infiniteScroll is called
  $$('#content-posts').on('infinite', function () {
    if (isLoading) return;
    isLoading = true;

    // Simulation of an Ajax request for demo
    setTimeout(function(){
	var first_a = $$('#first').val();
	//if(first_a < 20){
	var first = $$('#first').val();
	var limit = $$('#limit').val();

	var first1 = $$('#first1').val();
	var limit1 = $$('#limit1').val();
	$$.ajax({
		url:"../../berita/get_data/",
		cache:false,
		data: {
		   start : first,
		   limit : limit,
		   start1 : first1,
		   limit1 : limit1
		},
		type: "POST",
		dataType: 'json',
		success:function(result){
				$$.each(result, function(i, data){
					if(data.flag_id == 'FLG00001'){
						$$('#post-list').append(
							'<li class="promoted">'+
							  '<a onclick="location.href = '+"'"+data.post_url+"'"+';">'+
								'<div class="post-thumbnail"><img src="http://suarakaryanews.com/beta/uploads/post/original/'+data.post_thumb+'"></div>'+
								'<div class="post-infos">'+
								  '<div class="post-title"><h4>'+data.post_title+'</h4></div>'+
								  '<div class="post-category red" style="float:left">Adventorial</div>'+
								  '<div class="post-date"><i class="icon ion-android-time"></i>'+data.post_modify_date.substr(8,2)+" "+formatMonth(data.post_modify_date.substr(5,2).valueOf()-1)+" "+data.post_modify_date.substr(0,4)+'</div>'+
								'</div>'+
							  '</a>'+
							'</li>');
					}else{
						$$('#post-list').append(
							'<li>'+
							  '<a onclick="location.href = '+"'http://m.suarakaryanews.com/index.php/berita/artikel/"+data.post_url+"'"+';">'+
								'<div class="post-thumbnail"><img src="http://suarakaryanews.com/beta/uploads/post/original/'+data.post_thumb+'"></div>'+
								'<div class="post-infos">'+
								  '<div class="post-title"><h4>'+data.post_title+'</span></h4>'+
								  '<div class="post-category red" style="float:left">'+data.category_name+'</div>'+
								  '<div class="post-date"><i class="icon ion-android-time"></i>'+data.post_modify_date.substr(8,2)+" "+formatMonth(data.post_modify_date.substr(5,2).valueOf()-1)+" "+data.post_modify_date.substr(0,4)+'</div>'+
								'</div>'+
							  '</a>'+
							'</li>');
					}
				});
				
				$$('#post-list').append('<li class="content-banner">' +
					'<img src="http://suarakaryanews.com/beta/assets/img/addsense/728x90-white.jpg" style="width:100%;"/>' +
				'</li>');
				
				var first_v = parseInt($$('#first').val());
				var limit_v = parseInt($$('#limit').val());
				$$('#first').val( first_v+limit_v );
				
				
				var first_vi = parseInt($$('#first1').val());
				var limit_vi = parseInt($$('#limit1').val());
				$$('#first1').val( first_vi+limit_vi );
		}
	});
	//}
      $$('#infinite-loader').remove();
      isLoading = false;
    }, 2000);

  });

  // When a post is opened
  app.onPageInit('post', function(page){
    $$('#view-main .back-hidden').toggleClass('back-hidden back-visible');
  });

  // When back arrow is clicked
  app.onPageBack('post', function(e){
    $$('#view-main .back-visible').toggleClass('back-hidden back-visible');
  });

}());
