	<div style="position:fixed;bottom:-5px;z-index:9999;">
		<img src="<?php echo $url_pc;?>uploads/advertise/original/ad1.jpg" alt="" style="width:100%;">
	</div>
	<div id="main-adv-fixed" style="position:fixed;width:100%;height:100%;top:0;left:0;background:rgba(0,0,0,0.4);z-index:9999999;display:flex;">
		<div style="float:left;margin:auto;width:90%;">
			<div>
				<a id="main-adv-close" style="background:#fff;color:#333;padding:5px;border-radius:3px 3px 0 0;font-size:11px;text-decoration:none;cursor:pointer;"><span class="fa fa-close"></span> Close</a>
			</div>
			<img style="margin:auto;width:100%;" src="<?php echo $url_pc.'uploads/advertise/original/imgad.gif'?>"/>
		</div>
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
              <div class="pull-to-refresh-layer">
                <span class="preloader"></span>
                <div class="pull-to-refresh-arrow"></div>
              </div>
			  <div>
				<img src="<?php echo $url_pc;?>uploads/advertise/original/ad1.jpg" alt="" style="width:100%;">
			  </div>
              <ul class="post-list" id="post-list">
			  <?php 
				$i = 1;
				$limit = 0;
				$offset = 1;
				foreach($get_list->result() as $li){
					if($i == 3){
						$get_adv = $this->db->query("select * from sk_post, sk_profile_back, sk_category,sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00001' order by post_modify_date desc limit $limit, $offset");
						foreach($get_adv->result() as $list){
			  ?>
                <li class="promoted">
                  <a onclick="location.href = '<?php echo $list->post_url;?>';">
                    <div class="post-thumbnail"><img src='<?php echo $url_pc;?>uploads/post/original/<?php echo $list->post_thumb;?>' alt=""></div>
                    <div class="post-infos">
                      <div class="post-title">
                        <h4><?php echo $list->post_title;?></h4>
                      </div>
                      <div class="post-category red" style="float:left">Adventorial</div>
                      <div class="post-date"><i class="icon ion-android-time"></i><?php echo date('d M Y',strtotime($list->post_modify_date));?></div>
                    </div>
                  </a>
                </li>
                <?php 
						}
						$i++;
						$limit++;
					}else if(($i % 6) == 0){
						$get_adv = $this->db->query("select * from sk_post, sk_profile_back, sk_category,sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00001' order by post_modify_date desc limit $limit, $offset");
						foreach($get_adv->result() as $list){
				?>
                <li class="promoted">
                  <a onclick="location.href = '<?php echo $list->post_url;?>';">
                    <div class="post-thumbnail"><img src='<?php echo $url_pc;?>uploads/post/original/<?php echo $list->post_thumb;?>' alt=""></div>
                    <div class="post-infos">
                      <div class="post-title">
                        <h4><?php echo $list->post_title;?></h4>
                      </div>
                      <div class="post-category red" style="float:left">Adventorial</div>
                      <div class="post-date"><i class="icon ion-android-time"></i><?php echo date('d M Y',strtotime($list->post_modify_date));?></div>
                    </div>
                  </a>
                </li>
				<?php
							}
							$limit++;
						$i++;
						}else if(($i % 7) == 0){
				?>
				<li class="content-banner">
					<img src="<?php echo $url_pc;?>assets/img/addsense/728x90-white.jpg" style="width:100%;"/>
                </li>
				<?php
						$i++;
						}else{
				?>
				<li>
                  <a onclick="location.href = '<?php echo base_url();?>index.php/berita/artikel/<?php echo $li->post_url;?>';">
                    <div class="post-thumbnail"><img src='<?php echo $url_pc;?>uploads/post/original/<?php echo $li->post_thumb;?>' alt=""></div>
                    <div class="post-infos">
                      <div class="post-title">
                        <h4><?php echo $li->post_title;?></h4>
                      </div>
                      <div class="post-category red" style="float:left"><?php echo $li->kanal_name;?></div>
                      <div class="post-date"><i class="icon ion-android-time"></i><?php echo date('d M Y',strtotime($li->post_modify_date));?></div>
                    </div>
                  </a>
                </li>
               <?php
						$i++;
						}
					}
				?>
              </ul>
              <span id="infinite-loader" class="preloader"></span>
			  <input type="hidden" id="first" value="14" />
			  <input type="hidden" id="limit" value="5" >
			
			  <input type="hidden" id="first1" value="3" />
			  <input type="hidden" id="limit1" value="1" >
            </div>
          </div>
        </div>
      </div>

    </div>
	<script>
		$("#main-adv-close").click(function(){
				$("#main-adv-fixed").fadeOut();
		});
	</script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app.js"></script>