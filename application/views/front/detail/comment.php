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
	function loadCommentPost(){
		var url = '<?php echo $this->uri->segment(3);?>';
			 $.ajax({
				url:"../../berita/get_comment_post/",
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
										'<img alt="" class="img-comment" src="<?php echo $url_pc;?>uploads/user/original/'+data.guest_profile_pict+'"/>'+
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
											'<img alt="" class="img-comment" src="<?php echo $url_pc;?>uploads/user/original/'+data.guest_profile_pict+'"/>'+
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
				url:"../../berita/get_comment_post/",
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
										'<img alt="" class="img-comment" src="<?php echo $url_pc;?>uploads/user/original/'+data.guest_profile_pict+'"/>'+
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
											'<img alt="" class="img-comment" src="<?php echo $url_pc;?>uploads/user/original/'+data.guest_profile_pict+'"/>'+
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
					}else if(result.status == 'validation'){
						$("#notif-reaction span").remove();
						$("#notif-reaction").css("display","flex");
						$("#notif-reaction").append('<span class="notif-box">Maaf, Anda belum mengisikan komentar pada kolom komentar.</span>');
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
					}else if(result.status == 'validation'){
						$("#notif-reaction span").remove();
						$("#notif-reaction").css("display","flex");
						$("#notif-reaction").append('<span class="notif-box">Maaf, Anda belum mengisikan komentar pada kolom komentar.</span>');
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
	<div id="box-reply-up" style="background-color:rgba(225,225,225,0.3);position:fixed;top:0;left:0;width:100%;height:100%;z-index:9999999;display:none;align-items:center;">
		<div id="reply-pop" style="width:500px;background-color:#fff;margin:auto;display:none;">
			<?php 
				$attibute = array("style"=>"padding:30px;width:100%");
				echo form_open("",$attibute);
			?>
				<div style="text-align:right;">
					<span id="reply-close" class="fa fa-close">Close</span>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="contact-form-box">
							<div class="title-section">
								<h1><span>Tanggapan Anda</span> <span class="email-not-published"></span></h1>
							</div>
							<form id="comment-form" style="margin-bottom:20px;">
								<label for="comment">Komentar*</label>
								<input type="hidden" id="id-tanggapan"/>
								<textarea id="comment-tanggapan" name="comment" class="comment" style="width:100%;height:100px;border-radius:3px;"></textarea>
								<a id="submit-comment-tanggapan" class="submit-comment">
									<i class="fa fa-comment"></i> Post Comment
								</a>
							</form>
						</div>
					</div>
				</div>
			<?php echo form_close();?>
		</div>
	</div>
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
				<span><?php echo $kanal;?></span> / 
				<span>Komentar</span>
			</div>
			<div class="title-post" style="padding:15px;">
				<h1 style="font-size:18px;"><?php echo $title_main;?></h1>
				<ul class="post-tags">
					<li><i class="fa fa-clock-o" style="margin-right:5px;"></i><?php echo date('D, d M Y',strtotime($date_main));?></li>
					<li><i class="fa fa-user" style="margin-right:5px;"></i>by <a href="#"><?php echo $posted_main;?></a></li>
				</ul>
			</div>
			<div class="text-content" style="padding:10px;margin-top:10px;text-align:justify;">
				<?php echo $short_main;?>
			</div>
			<div style="width:100%;float:left;padding:15px;margin-bottom:50px;">
			  <!-- contact form box -->
				<div class="contact-form-box">
					<div class="title-section" style="margin-top:20px;">
						<h1><span>Komentar</span> <span class="email-not-published"></span></h1>
					</div>
					<form id="comment-form" style="margin-bottom:20px;">
						<label for="comment">Comment*</label>
						<textarea id="comment" name="comment" class="comment" style="width: 100%;height: 100px;border-radius: 3px;"></textarea>
						<a id="submit-comment" class="submit-comment" style="padding:10px;margin-top:10px;background-color:#333;color:#fff;float:left;border-radius:3px;">
							<i class="fa fa-comment"></i> Post Comment
						</a>
					</form>
				</div>
				<!-- End contact form box -->
				<input type="hidden" id="post" value="<?php echo $id_post;?>"/>
				<!-- comment area box -->
				<div class="comment-area-box" style="width:100%;float:left;">
					<div class="title-section">
						<h1><span><?php echo $get_comment_count->num_rows?> Komentar</span></h1>
					</div>
					<ul class="comment-tree" id="comment-tree">
						<div id="comment-list"></div>
					</ul>
				</div>
				<!-- End comment area box -->
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