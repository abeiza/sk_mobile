	<script>
		$(function(){
			$("#notif-forget").click(function(){
				$("#notif-forget").fadeOut();
			});
			
			$('#forget-act').click(function(){
				 $(".loading-forget").fadeIn();
				 var email_forget = $('#email-forget').val();
				 $.ajax({
					url:"../../berita/get_forget_account/",
					cache:false,
					data: {
					   email_forget : email_forget
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-forget span").remove();
							$(".loading-forget").fadeOut();
							$("#notif-forget").css("display","flex");
							$("#notif-forget").append('<span class="notif-box">Data password anda telah kami reset dan telah kami kirimkan ke email anda.</span>');
							
							
						}else if(result.status == 'logged'){
							$("#notif-forget span").remove();
							$(".loading-forget").fadeOut();
							location.reload();
							
						}else if(result.status == 'invalid'){
							$("#notif-forget span").remove();
							$(".loading-forget").fadeOut();
							$("#notif-forget").css("display","flex");
							$("#notif-forget").append('<span class="notif-box">Maaf, Email yang Anda Masukkan Tidak Terdaftar</span>');
							
						}else{
							$("#notif-forget span").remove();
							$(".loading-forget").fadeOut();
							$("#notif-forget").css("display","flex");
							$("#notif-forget").append('<span  class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
							
						}
					}
				});
			});
		});
	</script>
	<div class="views tabs">
      <!-- Main view -  Home -->
      <div id="view-main" class="view view-main tab active">
        <!-- Main view content -->
        <div class="pages navbar-fixed">
          <div class="page" style="overflow:auto!important">
			<div class="title-post" style="padding:15px;margin-top:45px;">
				<div style="margin:10px 0px;width:100%;float:Left;text-align:center;">
				<img src="<?php echo $url_pc;?>assets/img/logo.png" style="width:70%;"/>
				</div>
				
				<div style="margin:10px 0px;width:100%;float:Left;">
					<div style="width:100%;float:left;margin:5px 0;">
						<label style="width:100%;float:left;font-size:12px;">Your Email</label>
						<input id="email-forget" style="width:100%;float:left;font-size:12px;padding:7px 3px;border-radius:3px;border:1px solid #e1e1e1" id="email" type="text" placeholder="e.g email@domain.com"/>
					</div>
					<div class="loading-forget"><i class="fa fa-spinner fa-spin"></i> Loading . . .</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<div style="width:50%;float:left;">
							<a onclick="location.href = '<?php echo base_url();?>index.php/berita/login';" style="background-color:#4983da;color:#fff;padding:7px 3px;width:80%;float:left;border-radius:3px;text-align:center;margin:0 10px;">Kembali</a>
						</div>
						<div style="width:50%;float:left;">
							<a class="login-btn" id="forget-act" style="background-color:#f58021;color:#fff;padding:7px 3px;width:80%;float:left;border-radius:3px;text-align:center;margin:0 10px;">Kirim</a>
						</div>
					</div>
					<div id="notif-forget"></div>
				</div>
			</div>
		  </div>
        </div>
      </div>						
    </div>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app_kanal.js"></script>