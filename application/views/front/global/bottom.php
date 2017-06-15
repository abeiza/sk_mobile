 <!-- Scripts -->
    </body>
        <div id="fb-root"></div>
        <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v2.9&appId=1875197792736784";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>
		<!-- Place this tag where you want the share button to render. -->
		<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
		<script>
			;(function($){
              
              /**
               * jQuery function to prevent default anchor event and take the href * and the title to make a share popup
               *
               * @param  {[object]} e           [Mouse event]
               * @param  {[integer]} intWidth   [Popup width defalut 500]
               * @param  {[integer]} intHeight  [Popup height defalut 400]
               * @param  {[boolean]} blnResize  [Is popup resizeabel default true]
               */
              $.fn.customerPopup = function (e, intWidth, intHeight, blnResize) {
                
                // Prevent default anchor event
                e.preventDefault();
                
                // Set values for window
                intWidth = intWidth || '500';
                intHeight = intHeight || '400';
                strResize = (blnResize ? 'yes' : 'no');
            
                // Set title and open popup with focus on it
                var strTitle = ((typeof this.attr('title') !== 'undefined') ? this.attr('title') : 'Social Share'),
                    strParam = 'width=' + intWidth + ',height=' + intHeight + ',resizable=' + strResize,            
                    objWindow = window.open(this.attr('href'), strTitle, strParam).focus();
              }
              
              /* ================================================== */
              
              $(document).ready(function ($) {
                $('.customer.share').on("click", function(e) {
                  $(this).customerPopup(e);
                });
              });
                
            }(jQuery));
		</script>
	<script type="text/javascript">
		if (screen.width > 750) {
			document.location = 'http://suarakaryanews.com/index.php/berita/<?php echo $this->uri->segment(2);?>/<?php echo $this->uri->segment(3);?>';
		}
	</script>
</html>
