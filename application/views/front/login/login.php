    <script>
		$(function(){
			$("#notif-login").click(function(){
				$("#notif-login").fadeOut();
			});
			$('#login-act').click(function(){
				 $(".loading-login").fadeIn();
				 var username = $('#username').val();
				 var password = $('#password').val();
				 $.ajax({
					url:"../../berita/get_validation_login/",
					cache:false,
					data: {
					   username : username,
					   password : password
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
						    $("#notif-login span").remove();
							$(".loading-login").fadeOut();
							window.location = "http://m.suarakaryanews.com/";
							
						}else if(result.status == 'logged'){
							$("#notif-login span").remove();
							$(".loading-login").fadeOut();
							window.location = "http://m.suarakaryanews.com/index.php/berita/dashboard/";
							
						}else if(result.status == 'invalid'){
							$("#notif-login span").remove();
							$(".loading-login").fadeOut();
							$("#notif-login").css("display","flex");
							$("#notif-login").append('<span class="notif-box">Maaf, Username atau Password yang Anda Masukkan Salah</span>');
							
						}else{
							$("#notif-login span").remove();
							$(".loading-login").fadeOut();
							$("#notif-login").css("display","flex");
							$("#notif-login").append('<span  class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
							
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
						<label style="width:100%;float:left;font-size:12px;">Username</label>
						<input style="width:100%;float:left;font-size:12px;padding:7px 3px;border-radius:3px;border:1px solid #e1e1e1" id="username" type="text" />
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<label style="width:100%;float:left;font-size:12px;">Password</label>
						<input style="width:100%;float:left;font-size:12px;padding:7px 3px;border-radius:3px;border:1px solid #e1e1e1" id="password" type="password" />
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<a style="float:right;font-size:12px;margin:10px 0;" onclick="location.href = '<?php echo base_url();?>index.php/berita/forget';">Lupa Password?</a>
						<a style="width:100%;float:left;text-align:center;border:1px solid #f58021;background-color:#f58021;padding:7px 0;color:#fff;font-size:12px;width:100%;border-radius:3px;" id="login-act">Masuk</a>
					</div>
					<div class="loading-login"><i class="fa fa-spinner fa-spin"></i> Loading . . .</div>
					<div id="notif-login"></div>
					<div style="width:100%;float:left;margin:25px 0;">
						<hr style="border:0;border-bottom:1px solid #e1e1e1;float:left;width:100%;"/>
						<div style="width:100%;float:left;text-align:center;margin-top:-10px;">
							<span style="background-color:#fff;padding:0 5px;font-size:12px;color:#999">atau</span>
						</div>
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<div style="width:50%;float:left;">
							<a onclick="location.href = '<?php echo $login_url;?>'" style="background-color:#4983da;color:#fff;padding:7px 3px;width:80%;float:left;border-radius:3px;text-align:center;margin:0 10px;"><i class="ion-social-facebook" style="margin-right:5px;"></i> Facebook</a>
						</div>
						<div style="width:50%;float:left;">
							<a onclick="location.href = '<?php echo $google_url;?>'" style="background-color:#f14133;color:#fff;padding:7px 3px;width:80%;float:left;border-radius:3px;text-align:center;margin:0 10px;"><i class="ion-social-googleplus" style="margin-right:5px;"></i> Google+</a>
						</div>
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<span style="font-size:12px;color:#999;">Anda belum memiliki akun? <a onclick="location.href = '<?php echo base_url();?>index.php/berita/register';">Daftar Sekarang</a></span>
					</div>
				</div>
			</div>
		  </div>
        </div>
      </div>						
    </div>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app_kanal.js"></script>