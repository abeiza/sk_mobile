<div id="notif-reaction"><span></span></div>
<style>
#notif-reaction{
    width: 100%;
    height: 100%;
    position: fixed;
    top: 0;
    left: 0;
    display: none;
	background: rgba(0,0,0,0.3);
	z-index: 9999999999;
}
</style>
<script>
		function formatMonth(m){
			var monthNames = [
				"Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Des"
			];
			
			return monthNames[m];
		}
	</script>
	<script>
		function reply_click(click_id){
			$('#id-tanggapan').val(click_id);
			$('#box-reply-up').show();
			$("#box-reply-up").css("display","flex");
			$("#reply-pop").css("display","flex");
		}
	</script>
	<script>
		function loadReaction(){
			var url = '<?php echo $this->uri->segment(3);?>';
			 $.ajax({
				url:"../../berita/get_reaction_photo/",
				cache:false,
				data: {
				   url : url
				},
				type: "POST",
				dataType: 'json',
				success:function(result){
					$('.senang-id span').remove();
					$('.terhibur-id span').remove();
					$('.terinspirasi-id span').remove();
					$('.tidakpeduli-id span').remove();
					$('.terganggu-id span').remove();
					$('.sedih-id span').remove();
					$('.cemas-id span').remove();
					$('.marah-id span').remove();
					
					$('.senang-id').append("<span>"+result.senang+" %</span>");
					$('.terhibur-id').append("<span>"+result.terhibur+" %</span>");
					$('.terinspirasi-id').append("<span>"+result.terinspirasi+" %</span>");
					$('.tidakpeduli-id').append("<span>"+result.tidak_peduli+" %</span>");
					$('.terganggu-id').append("<span>"+result.terganggu+" %</span>");
					$('.sedih-id').append("<span>"+result.sedih+" %</span>");
					$('.cemas-id').append("<span>"+result.cemas+" %</span>");
					$('.marah-id').append("<span>"+result.marah+" %</span>");
				}
			});
		}
		
		function loadCommentPost(){
			var url = '<?php echo $this->uri->segment(3);?>';
				 $.ajax({
					url:"../../berita/get_comment_photo/",
					cache:false,
					data: {
					   url : url
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						$('#comment-tree #comment-list').remove();
						$('#comment-tree').append('<div id="comment-list"></div>');
							
						$.each(result, function(i, data){
							if(data.comment_order == 1){
								if(data.guest_profile_pict == null || data.guest_profile_pict == ''){
									$('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="http://suarakaryanews.com/assets/img/profile-image-2.png"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}else{
									$('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="http://suarakaryanews.com/uploads/user/original/'+data.guest_profile_pict+'"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}
							}else{
								if(data.guest_profile_pict == null || data.guest_profile_pict == ''){
									$('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="http://suarakaryanews.com/assets/img/profile-image-2.png">'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}else{
									$('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="http://suarakaryanews.com/uploads/user/original/'+data.guest_profile_pict+'"/>'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}
							}
						});
					}
				});
		}
	</script>
	<script>
		$(function() {
			$(function(){
				var url = '<?php echo $this->uri->segment(3);?>';
				 $.ajax({
					url:"../../berita/get_reaction_photo/",
					cache:false,
					data: {
					   url : url
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						$('.senang-id span').remove();
						$('.terhibur-id span').remove();
						$('.terinspirasi-id span').remove();
						$('.tidakpeduli-id span').remove();
						$('.terganggu-id span').remove();
						$('.sedih-id span').remove();
						$('.cemas-id span').remove();
						$('.marah-id span').remove();
						
						$('.senang-id').append("<span>"+result.senang+" %</span>");
						$('.terhibur-id').append("<span>"+result.terhibur+" %</span>");
						$('.terinspirasi-id').append("<span>"+result.terinspirasi+" %</span>");
						$('.tidakpeduli-id').append("<span>"+result.tidak_peduli+" %</span>");
						$('.terganggu-id').append("<span>"+result.terganggu+" %</span>");
						$('.sedih-id').append("<span>"+result.sedih+" %</span>");
						$('.cemas-id').append("<span>"+result.cemas+" %</span>");
						$('.marah-id').append("<span>"+result.marah+" %</span>");
					}
				}); 
			});
			setInterval(function(){loadReaction()}, 3000);
			
			$(function(){
				 var url = '<?php echo $this->uri->segment(3);?>';
				 $.ajax({
					url:"../../berita/get_comment_photo/",
					cache:false,
					data: {
					   url : url
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						$('#comment-tree #comment-list').remove();
						$('#comment-tree').append('<div id="comment-list"></div>');
							
						$.each(result, function(i, data){
							if(data.comment_order == 1){
								if(data.guest_profile_pict == null || data.guest_profile_pict == ''){
									$('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="http://suarakaryanews.com/assets/img/profile-image-2.png"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}else{
									$('#comment-tree #comment-list').append(
									'<li>'+
										'<div class="comment-box">'+
											'<img alt="" class="img-comment" src="http://suarakaryanews.com/uploads/user/original/'+data.guest_profile_pict+'"/>'+
											'<div class="comment-content">'+
												'<h4>'+data.guest_name+'<a id="'+data.comment_id+'" onclick="reply_click(this.id)"><i class="fa fa-comment-o"></i>Reply</a></h4>'+
												'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+'</span>'+
												'<p>'+data.comment_text+'</p>'+
											'</div>'+
										'</div>'+
									'</li>');
								}
							}else{
								if(data.guest_profile_pict == null || data.guest_profile_pict == ''){
									$('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="http://suarakaryanews.com/assets/img/profile-image-2.png">'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}else{
									$('#comment-tree #comment-list').append(
									'<ul class="depth">'+
										'<li>'+
											'<div class="comment-box">'+
												'<img alt="" class="img-comment" src="http://suarakaryanews.com/uploads/user/original/'+data.guest_profile_pict+'"/>'+
												'<div class="comment-content">'+
													'<h4>'+data.guest_name+'</h4>'+
													'<span><i class="fa fa-clock-o"></i>'+data.comment_post_date.substr(8,2)+" "+formatMonth(data.comment_post_date.substr(5,2).valueOf()-1)+" "+data.comment_post_date.substr(0,4)+'</span>'+
													'<p>'+data.comment_text+'</p>'+
												'</div>'+
											'</div>'+
										'</li>'+
									'</ul>');
								}
							}
						});
					
						//loadCommentPost();
					}
				}); 
			});
			setInterval(function(){loadCommentPost()}, 3000);
			
			$("#reply-close").click(function(){
				$("#box-reply-up").fadeOut();
				$("#box-reply-up").css("display","none");
				$("#login-reply").css("display","none");
			});
			
			$('#senang-box').click(function(){
				var id_post = $("#post").val();
				 $.ajax({
					url:"../../berita/set_reaction_photo/",
					cache:false,
					data: {
					   reac : 'REA00001',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
					}
				});
			});
			
			$('#terhibur-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"../../berita/set_reaction_photo/",
					cache:false,
					data: {
					   reac : 'REA00002',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
					}
				});
			});
			
			$('#terinspirasi-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"../../berita/set_reaction_photo/",
					cache:false,
					data: {
					   reac : 'REA00003',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
					}
				});
			});
			
			$('#tidakpeduli-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"../../berita/set_reaction_photo/",
					cache:false,
					data: {
					   reac : 'REA00004',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
					}
				});
			});
			
			$('#terganggu-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"../../berita/set_reaction_photo/",
					cache:false,
					data: {
					   reac : 'REA00005',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
					}
				});
			});
			
			$('#sedih-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"../../berita/set_reaction_photo/",
					cache:false,
					data: {
					   reac : 'REA00006',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
					}
				});
			});
			
			$('#cemas-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"../../berita/set_reaction_photo/",
					cache:false,
					data: {
					   reac : 'REA00007',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
					}
				});
			});
			
			$('#marah-box').click(function(){
				var id_post = $("#post").val();
				$.ajax({
					url:"../../index.php/berita/set_reaction_photo/",
					cache:false,
					data: {
					   reac : 'REA00008',
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
					}
				});
			});
			
			$('#submit-comment').click(function(){
				var comment = $("#comment").val();
				var id_post = $("#post").val();
				 $.ajax({
					url:"../../berita/set_comment_post/",
					cache:false,
					data: {
					   comment : comment,
					   post : id_post
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
						
						$("#comment").val('');
					}
				});
			});
			
			$('#submit-comment-tanggapan').click(function(){
				var comment = $("#comment-tanggapan").val();
				var id_post = $("#post").val();
				var id_comment = $("#id-tanggapan").val();
				 $.ajax({
					url:"../../berita/set_comment_post_tanggapan/",
					cache:false,
					data: {
					   comment : comment,
					   post : id_post,
					   id_comment : id_comment
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Terimakasih telah memberikan tanggapan</span>');
						}else if(result.status == 'failed'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Telah terjadi kesalahan</span>');
						}else if(result.status == 'available'){
							$("#notif-reaction span").remove();
							$("#notif-reaction").css("display","flex");
							$("#notif-reaction").append('<span class="notif-box">Maaf, Anda telah memberikan tanggapan pada artikel ini</span>');
						}else{
							window.location = "http://m.suarakaryanews.com/index.php/berita/login/";
						}
						
						$("#comment-tanggapan").val('');
						$('#box-reply-up').fadeOut();
					}
				});
			});
			
			$("#notif-reaction").click(function(){
				$("#notif-reaction").fadeOut();
			});
		});
		</script>
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		
	<?php 
		foreach($query_adv->result() as $pop){
			if($pop->position_id == 'PSB00002'){
	?>
	<div id="bottom-adv-fixed" style="position:fixed;bottom:-5px;z-index:9999;">
	    <div>
			<a id="bottom-adv-close" style="background:#ec3e3e;color:#fff;padding:5px;border-radius:3px 3px 0 0;font-size:11px;text-decoration:none;cursor:pointer;"><span class="fa fa-close"></span> Close</a>
		</div>
		<a onclick="location.href = '<?php echo $pop->adv_link;?>';"><img style="margin:auto;width:100%;" src="<?php echo $url_pc.'uploads/advertise/original/'.$pop->adv_pict;?>" /></a>
	</div>
	<?php 
			}
		}
	?>
	<div class="views tabs">
      <!-- Main view -  Home -->
      <div id="view-main" class="view view-main tab active">
        <div class="navbar navbar-background">
          <div class="navbar-inner">
            
            <div class="left logo-img"><a onclick="location.href = '<?php echo base_url();?>';"><img style="width:auto;margin-top:7px;" src="<?php echo $url_pc;?>/assets/img/logo_mobile.png" alt=""></a></div>
            <div class="right position-absolute">
                <a href="#" data-panel="right" class="link open-panel"><i class="demo-icon ion-navicon"></i></a>
            </div>
          </div>
        </div>
        <!-- Main view content -->
        <div class="pages navbar-fixed">
          <div class="page" style="overflow:auto!important">
			<div class="directori">
				<span>Home</span> / 
				<span>Gambar</span> / 
				<span>Gambar Detail</span>
			</div>
			<div class="title-post" style="padding:15px;">
				<h1 style="font-size:18px;"><?php echo $title_main;?></h1>
				<ul class="post-tags">
					<li><i class="fa fa-clock-o"></i><?php echo date('D, d M Y',strtotime($date_main));?></li>
					<li><i class="fa fa-user"></i>by <a href="#"><?php echo $posted_main;?></a></li>
				</ul>
			</div>
			<?php 
			$query = $this->db->query("select pict_detail_url,pict_detail_short_desc from sk_photo_detail where ref_pict_id = '".$pict_id."' order by ObjectID");
			foreach($query->result() as $pd1){
			?>
			<img src="<?php echo $url_pc;?>uploads/pict/original/<?php echo $pd1->pict_detail_url?>" style="width:100%;" alt="">
			<div style="font-size:12px;padding-bottom:10px;"><?php echo $pd1->pict_detail_short_desc?></div>
			<?php 
			}
			?>
			<div class="text-content" style="padding:10px;">
				<?php echo $desc_main;?>
			</div>
			<div class="share-section">
				<div>Share</div>
				<div style="float:left;padding-top:0;padding-bottom:0;width:100%;">
					<div style="padding:0;" data-href="<?php echo $url_mobile.'index.php/berita/foto_detail/'.$this->uri->segment(3);?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="facebook" class="fb-xfbml-parse-ignore" target="_blank" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fm.suarakaryanews.com%2Findex.php%2Fberita%2Ffoto_detail%2F<?php echo rawurlencode($this->uri->segment(3));?>&amp;src=sdkpreparse');"><i class="ion-social-facebook"></i></a></div>
					<a onclick="window.open('https://twitter.com/share');" target="_blank" class="twitter"><i class="ion-social-twitter"></i></a>
					<a href="https://plus.google.com/share?url=<?php echo rawurlencode('https://m.suarakaryanews.com/index.php/berita/foto_detail/'.$this->uri->segment(3));?>" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" class="google"><i class="ion-social-googleplus"></i></a>
				    <a onclick="window.open('whatsapp://send?text=SUARAKARYANEWS.COM <?php echo $title_main.' '.$shortDWName;?>');" class="whatsapp" data-action="share/whatsapp/share"><i class="ion-social-whatsapp"></i></a>
				</div>
				<div style="float:left;padding-top:0;padding-bottom:0;width:100%;">
					<a class="tag-point" onclick="location.href = '<?php echo base_url();?>index.php/berita/comment/<?php echo $this->uri->segment(3)?>';" style="background-color:#999;padding:5px 14px;margin:2.5px;"><i class="ion-chatbubbles"></i> Komentar</a>
				</div>
			</div>
			
			<div style="width:100%;float:left;padding:15px;">
			  <h1 style="font-size:18px;margin-bottom:20px;">Bagaimana Reaksi Anda Tentang Artikel ini?</h1>
			  <hr style="margin-bottom:10px;border:none;border-bottom:1px solid #f6f6f6"/>
				<div class="reaction-box" id="senang-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/senang.png"/>
					<div class="desc">
						<h6>Senang</h6>
						<p class="senang-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box" id="terhibur-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/terhibur.png"/>
					<div class="desc">
						<h6>Terhibur</h6>
						<p class="terhibur-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box" id="terinspirasi-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/terinspirasi.png"/>
					<div class="desc">
						<h6>Terinspirasi</h6>
						<p class="terinspirasi-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box" id="tidakpeduli-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/tidak_peduli.png"/>
					<div class="desc">
						<h6>Tidak Peduli</h6>
						<p class="tidakpeduli-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box" id="terganggu-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/terganggu.png"/>
					<div class="desc">
						<h6>Terganggu</h6>
						<p class="terganggu-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box" id="sedih-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/sedih.png"/>
					<div class="desc">
						<h6>Sedih</h6>
						<p class="sedih-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box" id="cemas-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/cemas.png"/>
					<div class="desc">
						<h6>Cemas</h6>
						<p class="cemas-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box" id="marah-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/marah.png"/>
					<div class="desc">
						<h6>Marah</h6>
						<p class="marah-id"><span>0 %</span></p>
					</div>
				</div>
				<input type="hidden" id="post" value="<?php echo $id_post;?>"/>
			</div>	
			<div style="width:100%;float:left;margin-bottom:50px;padding:15px;">
				<ul class="post-list" id="post-list">
				<div>
					<h1 style="font-size:18px;margin-bottom:20px;">Berita Terkait</h1>
				</div>
				<?php 
				if($get_other->num_rows() <= 1){
				?>
					<li style="font-size:11px;padding:0;border:none;">Berita terkait tidak tersedia untuk artikel ini</li>
				<?php
				}else{
					foreach($get_other->result() as $hdl){
						if($hdl->post_url != $this->uri->segment(3)){
				?>
					<li>
					  <a onclick="location.href = '<?php echo base_url();?>index.php/berita/artikel/<?php echo $hdl->post_url;?>';">
						<div class="post-thumbnail"><img src='<?php echo $url_pc;?>uploads/post/original/<?php echo $hdl->post_thumb;?>' alt=""></div>
						<div class="post-infos">
						  <div class="post-title">
							<h4><?php echo $hdl->post_title;?></h4>
						  </div>
						  <div class="post-category red" style="float:left"><?php echo $hdl->kanal_name;?></div>
						  <div class="post-date"><i class="icon ion-android-time"></i><?php echo date('d M Y',strtotime($hdl->post_modify_date));?></div>
						</div>
					  </a>
					</li>
				<?php 
						}
					}
				}
				?>
				</ul>
			</div>
		  </div>
        </div>
      </div>						
    </div>
    <script>
        $("#bottom-adv-close").click(function(){
				$("#bottom-adv-fixed").fadeOut();
		});
    </script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app_kanal.js"></script>