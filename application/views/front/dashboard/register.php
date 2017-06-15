<script>
	$(function(){
		$("#notif-reg").click(function(){
			$('#name_reg').val('');
			$('#email_reg').val('');
			$('#username_reg').val('');
			$('#password_reg').val('');
			$('#konfirmasi_reg').val('');
			$('#agree').prop('checked', false); 
			$("#notif-reg").fadeOut();
		});
		
		$('#reg-act').click(function(){
			 $(".loading-reg").fadeIn();
			 var name_reg = $('#name_reg').val();
			 var email_reg = $('#email_reg').val();
			 var username_reg = $('#username_reg').val();
			 var password_reg = $('#password_reg').val();
			 var konfirmasi_reg = $('#konfirmasi_reg').val();
			 var agree = $('#agree:checked').val();
			 
			 $.ajax({
				url:"../../berita/get_add_account/",
				cache:false,
				data: {
				   name_reg : name_reg,
				   email_reg : email_reg,
				   username_reg : username_reg,
				   password_reg : password_reg,
				   konfirmasi_reg : konfirmasi_reg,
				   agree : agree
				},
				type: "POST",
				dataType: 'json',
				success:function(result){
					if(result.status == 'success'){
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						$("#notif-reg").css("display","flex");
						$("#notif-reg").append('<span class="notif-box">Link activation telah kami kirimkan ke email anda<br/>Silahkan kembali ke email anda untuk mengaktifkan account anda.</span>');
						//location.reload();
						
					}else if(result.status == 'logged'){
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						//location.reload();
						
					}else if(result.status == 'available'){
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						$("#notif-reg").css("display","flex");
						$("#notif-reg").append('<span class="notif-box">Maaf, Username atau Password sudah digunakan. Silahkan cari Username atau Password lain</span>');
						
					}else if(result.status == 'invalid'){
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						$("#notif-reg").css("display","flex");
						$("#notif-reg").append('<span class="notif-box">Maaf, Username atau Password yang Anda Masukkan Salah</span>');
						
					}else{
						$("#notif-reg span").remove();
						$(".loading-reg").fadeOut();
						$("#notif-reg").css("display","flex");
						$("#notif-reg").append('<span class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
						
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
						<label style="width:100%;float:left;font-size:12px;">Nama Lengkap</label>
						<input id="name_reg" style="width:100%;float:left;font-size:12px;padding:7px 3px;border-radius:3px;border:1px solid #e1e1e1" type="text"  name="name"/>
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<label style="width:100%;float:left;font-size:12px;">Username</label>
						<input id="username_reg" style="width:100%;float:left;font-size:12px;padding:7px 3px;border-radius:3px;border:1px solid #e1e1e1" type="text"  name="username"/>
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<label style="width:100%;float:left;font-size:12px;">Email</label>
						<input id="email_reg" style="width:100%;float:left;font-size:12px;padding:7px 3px;border-radius:3px;border:1px solid #e1e1e1" type="email"  name="email"/>
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<label style="width:100%;float:left;font-size:12px;">Password</label>
						<input id="password_reg" style="width:100%;float:left;font-size:12px;padding:7px 3px;border-radius:3px;border:1px solid #e1e1e1" type="password"  name="password"/>
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<label style="width:100%;float:left;font-size:12px;">Konfirmasi Password</label>
						<input id="konfirmasi_reg" style="width:100%;float:left;font-size:12px;padding:7px 3px;border-radius:3px;border:1px solid #e1e1e1" type="password"  name="konfirmasi"/>
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<div style="width:100%;float:left;">
							<input id="agree" type="checkbox" name="agree" value="1">
							<label for='agree'>Saya setuju dengan <a>Syarat dan Ketentuan</a> yang berlaku</label>
						</div>
						<a id="reg-act" style="float:left;text-align:center;border:1px solid #f58021;background-color:#f58021;padding:7px 0;color:#fff;font-size:12px;width:100%;border-radius:3px;">Daftar</a>
						<div class="loading-reg"><i class="fa fa-spinner fa-spin"></i> Loading . . .</div>
					</div>
					<div id="notif-reg"></div>
					<!--<div style="width:100%;float:left;margin:25px 0;">
						<hr style="border:0;border-bottom:1px solid #e1e1e1;float:left;width:100%;"/>
						<div style="width:100%;float:left;text-align:center;margin-top:-10px;">
							<span style="background-color:#fff;padding:0 5px;font-size:12px;color:#999">atau</span>
						</div>
					</div>
					<div style="width:100%;float:left;margin:5px 0;">
						<div style="width:50%;float:left;">
							<a style="background-color:#4983da;color:#fff;padding:7px 3px;width:80%;float:left;border-radius:3px;text-align:center;margin:0 10px;"><i class="ion-social-facebook" style="margin-right:5px;"></i> Facebook</a>
						</div>
						<div style="width:50%;float:left;">
							<a style="background-color:#f14133;color:#fff;padding:7px 3px;width:80%;float:left;border-radius:3px;text-align:center;margin:0 10px;"><i class="ion-social-googleplus" style="margin-right:5px;"></i> Google+</a>
						</div>
					</div>-->
					<div style="width:100%;float:left;margin:5px 0;">
						<span style="font-size:12px;color:#999;">Anda sudah memiliki akun? <a onclick="location.href = '<?php echo base_url();?>index.php/berita/login';">Masuk</a></span>
					</div>
				</div>
			</div>
		  </div>
        </div>
      </div>						
    </div>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app_kanal.js"></script>