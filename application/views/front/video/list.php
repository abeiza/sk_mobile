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
          <div class="page">
            <div id="content-posts" class="page-content pull-to-refresh-content infinite-scroll" data-distance="50">
     
			  <?php 
    				foreach($query_adv->result() as $pop){
    					if($pop->position_id == 'PSB00001'){
    			?>
    			<div>
    				<a onclick="location.href = '<?php echo $pop->adv_link;?>';"><img style="margin:auto;width:100%;" src="<?php echo $url_pc.'uploads/advertise/original/'.$pop->adv_pict;?>" /></a>
    			</div>
    			<?php 
    					}
    				}
    			?>
			  <div class="directori" style="margin-top:-5px;">
				<span>Home</span> / 
				<span>Video</span> / 
				<span>Index</span>
			  </div>
              <!--<ul class="post-list" id="post-list" style="padding:15px;">-->
				<div style="padding:15px;">
					<span style="color:#333;text-transform:none !important;font-size:12px;">List Video</span>
				</div>
				<?php 
					foreach($get_video_main->result() as $vi){
				?>
				  <iframe class="full-width" style="margin:0;width:100%;" src="<?php echo $vi->video_link?>" height="360" allowfullscreen></iframe>
				  <div style="margin-bottom:5px;padding:15px;margin-top:-5px;background:#f6f6f6;">
					<span style="color:#FD8E23;font-size:11px;"><?php echo $vi->category_name;?></span>
					<h2 style="font-size:14px;"><a onclick="location.href = '<?php echo base_url();?>index.php/berita/video_detail/<?php echo $vi->video_url;?>';" ><?php echo $vi->video_title;?></a></h2>
					<p style="font-size:12px;color:#555"><?php echo $vi->video_short_desc;?></p>
					<span style="font-size:11px;"><i class="icon ion-android-time"></i><?php echo date('d M Y', strtotime($vi->video_modify_date));?></span>
				  </div>
				<?php
					}
				?>
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
