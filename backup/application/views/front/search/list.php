	<div style="position:fixed;bottom:-5px;z-index:9999;">
		<img src="<?php echo $url_pc;?>uploads/advertise/original/ad1.jpg" alt="" style="width:100%;">
	</div>
    <div class="views tabs">
      <!-- Main view -  Home -->
      <div id="view-main" class="view view-main tab active">
        <div class="navbar" style="box-shadow:0 0 10px 0 rgba(0,0,0,.3) !important;">
          <div class="navbar-inner">
            
            <div class="left"><a onclick="location.href = '<?php echo base_url();?>';"><img src="<?php echo $url_pc;?>assets/img/logo_mobile.png" alt=""></a></div>
            <div class="right">
                <a href="#" data-panel="right" class="link open-panel"><i class="demo-icon ion-navicon"></i></a>
            </div>
          </div>
        </div>
        <!-- Main view content -->
        <div class="pages navbar-fixed">
          <div class="page">
            <div id="content-posts" class="page-content pull-to-refresh-content infinite-scroll" data-distance="50">
     
			  <div>
				<img src="<?php echo $url_pc;?>uploads/advertise/original/ad1.jpg" alt="" style="width:100%;">
			  </div>
			  <div class="directori" style="margin-top:-5px;">
				<span>Home</span> / 
				<span>Pencarian</span> / 
				<span>Berita</span>
			  </div>
              <ul class="post-list" id="post-list" style="padding:15px;">
				<div>
					<span style="color:#333;text-transform:none !important;font-size:12px;">Hasil Pencarian  "<strong><?php echo $word;?></strong>", <?php echo number_format($get_data->num_rows(),'0',",",".");?> hasil ditemukan</span>
				</div>
				<hr style="margin:10px 0;border:none;border-bottom:1px solid #f6f6f6;"/>
				<?php 
					if($get_data->num_rows() == 0){
				?>
					<li style="font-size:12px;">Maaf, Pencarian tidak dapat ditemukan</li>
				<?php
					}else{
						foreach($get_data->result() as $sear){
				?>
				<li>
                   <a onclick="location.href = '<?php echo base_url();?>index.php/berita/artikel/<?php echo $sear->post_url;?>';">
                    <div class="post-thumbnail"><img src='<?php echo $url_pc;?>uploads/post/original/<?php echo $sear->post_thumb;?>' alt=""></div>
                    <div class="post-infos">
                      <div class="post-title">
                        <h4><?php echo $sear->post_title;?></h4>
                      </div>
                      <div class="post-category red" style="float:left"><?php echo $sear->kanal_name;?></div>
                      <div class="post-date"><i class="icon ion-android-time"></i><?php echo date('d M Y',strtotime($sear->post_modify_date));?></div>
                    </div>
                  </a>
                </li>
				<?php
						}
					}
				?>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </div>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app_kanal.js"></script>
