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
				<span>Foto</span> / 
				<span>Index</span>
			  </div>
			  <div style="padding:15px;">
					<span style="color:#333;text-transform:none !important;font-size:12px;">List Foto</span>
			  </div>
              <!--<ul class="post-list" id="post-list" style="padding:15px;">-->
			  <?php 
				foreach($get_photo_main->result() as $ph_main){
					$query = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$ph_main->pict_id."' order by ObjectID limit 1");
					foreach($query->result() as $pd_main){
			  ?>
				<img src="<?php echo $url_pc;?>uploads/pict/original/<?php echo $pd_main->pict_detail_url?>" style="width:100%;" alt="">
												
					<div style="margin-bottom:5px;padding:15px;margin-top:-5px;background:#f6f6f6;">
					<span style="color:#FD8E23;font-size:11px;"><?php echo $ph_main->kanal_name;?></span>
					<h2 style="font-size:14px;"><a onclick="location.href = '<?php echo base_url();?>index.php/berita/foto_detail/<?php echo $ph_main->pict_url;?>'"><?php echo $ph_main->pict_title;?></a></h2>
					<span style="font-size:11px;"><i class="icon ion-android-time"></i><?php echo date('d M Y', strtotime($ph_main->pict_create_date));?></span>
				  </div>
			 <?php 
				}
			}
			?>
				  
              <!--</ul>-->
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
