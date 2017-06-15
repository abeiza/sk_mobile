(function () {

  "use strict";

  var app = new Framework7;
  var $$ = Dom7;
  var viewMain = app.addView('#view-main');
  var pullToRefreshPosts = $$('#content-posts');

  // When a post is opened
  app.onPageInit('post', function(page){
    $$('#view-main .back-hidden').toggleClass('back-hidden back-visible');
  });

  // When back arrow is clicked
  app.onPageBack('post', function(e){
    $$('#view-main .back-visible').toggleClass('back-hidden back-visible');
  });

}());
