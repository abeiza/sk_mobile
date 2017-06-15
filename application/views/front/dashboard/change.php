	<script>
		$(function(){
			$("#notif-prof").click(function(){
				$("#notif-prof").fadeOut();
			});
			
			$("#notif-password").click(function(){
				$("#notif-password").fadeOut();
			});
			
			
			$('#change-prof').click(function(){
				 $(".loading-prof").fadeIn();
				 var name_profile = $('#name-profile').val();
				 var email_profile = $('#email-profile').val();
				 var website_profile = $('#website-profile').val();
				 
				 $.ajax({
					url:"../../berita/set_update_profile/",
					cache:false,
					data: {
					   name_profile : name_profile,
					   email_profile : email_profile,
					   website_profile : website_profile
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							$("#notif-prof").css("display","flex");
							$("#notif-prof").append('<span class="notif-box">Update profile berhasil dilakukan</span>');
							//location.reload();
							
						}else if(result.status == 'logged'){
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							//location.reload();
							
						}else if(result.status == 'available'){
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							$("#notif-prof").css("display","flex");
							$("#notif-prof").append('<span class="notif-box">Maaf, Username atau Password sudah digunakan. Silahkan cari Username atau Password lain</span>');
							
						}else if(result.status == 'invalid'){
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							$("#notif-prof").css("display","flex");
							$("#notif-prof").append('<span class="notif-box">Maaf, Username atau Password yang Anda Masukkan Salah</span>');
							
						}else{
							$("#notif-prof span").remove();
							$(".loading-prof").fadeOut();
							$("#notif-prof").css("display","flex");
							$("#notif-prof").append('<span class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
							
						}
					}
				});
			});
			
			$('#change-password').click(function(){
				 $(".loading-password").fadeIn();
				 var change_username = $('#username-change').val();
				 var change_password = $('#password-change').val();
				 var change_new = $('#new-change').val();
				 var change_conf = $('#conf-change').val();
				 
				 $.ajax({
					url:"../../berita/set_update_password/",
					cache:false,
					data: {
					   change_username : change_username,
					   change_password : change_password,
					   change_new : change_new,
					   change_conf : change_conf
					},
					type: "POST",
					dataType: 'json',
					success:function(result){
						if(result.status == 'success'){
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							$("#notif-password").css("display","flex");
							$("#notif-password").append('<span class="notif-box">Ubah password berhasil dilakukan</span>');
							//location.reload();
							
						}else if(result.status == 'logged'){
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							//location.reload();
							
						}else if(result.status == 'available'){
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							$("#notif-password").css("display","flex");
							$("#notif-password").append('<span class="notif-box">Maaf, Username atau Password sudah digunakan. Silahkan cari Username atau Password lain</span>');
							
						}else if(result.status == 'invalid'){
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							$("#notif-password").css("display","flex");
							$("#notif-password").append('<span class="notif-box">Maaf, Username atau Password yang Anda Masukkan Salah</span>');
							
						}else{
							$("#notif-password span").remove();
							$(".loading-password").fadeOut();
							$("#notif-password").css("display","flex");
							$("#notif-password").append('<span class="notif-box">Mohon Periksa Kembali Data yang Anda Masukkan</span>');
							
						}
					}
				});
			});
	
		});
	</script>

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
			<div style="margin-top:70px">
				<?php echo $this->session->flashdata('change_result')?>
				<?php echo $error;?>
			</div>
			<div style="text-align:center;margin:auto;">
				<div style="text-align:center;width:100%;margin:15px 0;">
					<label style="width:100%;text-align:center;float:left;">Username : </label>
					<input style="width:80%;padding:5px;border-radius: 3px;border: 1px solid #e1e1e1;" type="text" id="username-change" value="<?php echo $username;?>" id="name-profile"/>
				</div>
				<div style="text-align:center;width:100%;margin:15px 0;">
					<label style="width:100%;text-align:center;float:left;">Password : </label>
					<input style="width:80%;padding:5px;border-radius: 3px;border: 1px solid #e1e1e1;" type="password" class="form-input" id="password-change" value="<?php echo $password;?>" id="gender-profile"/>
				</div>
				<div style="text-align:center;width:100%;margin:15px 0;">
					<label style="width:100%;text-align:center;float:left;">Password Baru : </label>
					<input style="width:80%;padding:5px;border-radius: 3px;border: 1px solid #e1e1e1;" type="password" class="form-input" id="new-change" id="email-profile"/>
				</div>
				<div style="text-align:center;width:100%;margin:15px 0;">
					<label style="width:100%;text-align:center;float:left;">Konfirmasi Password Baru : </label>
					<input style="width:80%;padding:5px;border-radius: 3px;border: 1px solid #e1e1e1;" type="password" class="form-input" id="conf-change" id="website-profile"/>
				</div>
			</div>
			<div style="margin-top:30px;width:100%;">
				<div style="width:80%;margin:auto;text-align:center;">
					<a id="change-password" style="color:#fff;float:left;width:100%;background:#FD8E23;padding:10px;">Ubah</a>
				</div>
				<div class="loading-password"><i class="fa fa-spinner fa-spin"></i> Loading . . .</div>
				<div id="notif-password"></div>
			</div>
			<a  onclick="location.href = '<?php echo base_url();?>index.php/berita/dashboard/';" style="float:left;width:100%;text-align:center;margin:15px 0;font-size:12px;" href="">Back to Profile</a>
		  </div>
        </div>
      </div>

    </div>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app.js"></script>
	<script>
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
				
				$("#notif").click(function(){
					$("#notif").fadeOut();
				});
				
				$("#notif1").click(function(){
					$("#notif1").fadeOut();
				});
			});
		
			$("#ImageBrowse").on("change", function() {
				$("#imageUploadForm").submit();
			});
			
			$("#main-adv-close").click(function(){
    				$("#main-adv-fixed").fadeOut();
    		});
    		
    		$("#bottom-adv-close").click(function(){
    				$("#bottom-adv-fixed").fadeOut();
    		});
		</script>