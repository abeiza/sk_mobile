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
          <div class="page" style="overflow:auto!important">
			<div class="directori">
				<span>Home</span> / 
				<span><?php echo $kanal;?></span> / 
				<span>Berita</span>
			</div>
			<div class="title-post" style="padding:15px;">
				<h1 style="font-size:18px;"><?php echo $title_main;?></h1>
				<ul class="post-tags">
					<li><i class="fa fa-clock-o"></i><?php echo date('D, d M Y',strtotime($date_main));?></li>
					<li><i class="fa fa-user"></i>by <a href="#"><?php echo $posted_main;?></a></li>
				</ul>
			</div>
			<img src="<?php echo $url_pc;?>uploads/post/original/<?php echo $pict_main;?>" style="width:100%;padding-top:15px;" />
			<div class="text-content" style="padding:10px;">
				<?php echo $desc_main;?>
			</div>
			<div class="tag-section">
				<span>Tags : </span>
				<span class="tag-point"><?php echo $tag_name;?></span>
		    </div>
			<div class="share-section">
				<div>Share</div>
				<div style="float:left;padding-top:0;padding-bottom:0;width:100%;">
					<a class="facebook"><i class="ion-social-facebook"></i></a>
					<a class="twitter"><i class="ion-social-twitter"></i></a>
					<a class="google"><i class="ion-social-googleplus"></i></a>
				</div>
				<div style="float:left;padding-top:0;padding-bottom:0;width:100%;">
					<a class="tag-point" style="background-color:#999;padding:5px 14px;margin:2.5px;"><i class="ion-chatbubbles"></i> Komentar</a>
				</div>
			</div>
			<div style="width:100%;float:left;padding:15px;">
			  <h1 style="font-size:18px;margin-bottom:20px;">Bagaimana Reaksi Anda Tentang Artikel ini?</h1>
			  <hr style="margin-bottom:10px;border:none;border-bottom:1px solid #f6f6f6"/>
				<div class="reaction-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/senang.png"/>
					<div class="desc">
						<h6>Senang</h6>
						<p class="senang-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/terhibur.png"/>
					<div class="desc">
						<h6>Terhibur</h6>
						<p class="terhibur-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/terinspirasi.png"/>
					<div class="desc">
						<h6>Terinspirasi</h6>
						<p class="terinspirasi-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/tidak_peduli.png"/>
					<div class="desc">
						<h6>Tidak Peduli</h6>
						<p class="tidakpeduli-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/terganggu.png"/>
					<div class="desc">
						<h6>Terganggu</h6>
						<p class="terganggu-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/sedih.png"/>
					<div class="desc">
						<h6>Sedih</h6>
						<p class="sedih-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/cemas.png"/>
					<div class="desc">
						<h6>Cemas</h6>
						<p class="cemas-id"><span>0 %</span></p>
					</div>
				</div>
				<div class="reaction-box">
					<img class="icon" src="<?php echo $url_pc;?>assets/img/fwdemojisuarakaryanews/marah.png"/>
					<div class="desc">
						<h6>Marah</h6>
						<p class="marah-id"><span>0 %</span></p>
					</div>
				</div>
			</div>	
			<div style="width:100%;float:left;margin-bottom:50px;padding:15px;">
				<ul class="post-list" id="post-list">
				<div>
					<h1 style="font-size:18px;margin-bottom:20px;">Berita Terkait</h1>
				</div>
				 <hr style="margin-bottom:10px;border:none;border-bottom:1px solid #f6f6f6"/>
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
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app_kanal.js"></script>