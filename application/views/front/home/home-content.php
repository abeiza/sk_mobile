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
		<?php 
			foreach($query_adv->result() as $pop){
				if($pop->position_id == 'PSB00011'){
		?>
		<div id="main-adv-fixed" style="position:fixed;width:100%;height:100%;top:0;left:0;background:rgba(0,0,0,0.4);z-index:9999999;display:flex;">
    		<div style="float:left;margin:auto;width:90%;">
    			<div>
    				<a id="main-adv-close" style="background:#fff;color:#333;padding:5px;border-radius:3px 3px 0 0;font-size:11px;text-decoration:none;cursor:pointer;"><span class="fa fa-close"></span> Close</a>
    			</div>
			<a onclick="location.href = '<?php echo $pop->adv_link;?>';"><img style="margin:auto;width:100%;" src="<?php echo $url_pc.'uploads/advertise/original/'.$pop->adv_pict;?>" /></a>
		    </div>
        </div>
		<?php 
				}
			}
		?>
    <div class="views tabs">
        <?php 
			foreach($query_adv->result() as $pop){
				if($pop->position_id == 'PSB00017'){
		?>
            <div style="background-image:url('<?php echo $url_pc.'uploads/advertise/original/'.$pop->adv_pict;?>');background-size:contain;background-repeat:no-repeat;background-position:center center;position:fixed;width:100%;height:100%;left:0;top:0;"></div>
		<?php 
				}
			}
		?>
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
        <style>
            #infinite-loader{
                display:none;
            }
            
            #post-list li{
                background-color:#fff;
            }
        </style>
        <!-- Main view content -->
        <div class="pages navbar-fixed">
          <div class="page">
            <div id="content-posts" class="page-content pull-to-refresh-content infinite-scroll" data-distance="50">
              <div class="pull-to-refresh-layer">
                <span class="preloader"></span>
                <div class="pull-to-refresh-arrow"></div>
              </div>
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
    		  <ul class="post-list" id="post-list" style="position:absolute">
			  <?php 
				$i = 1;
				$limit = 0;
				$limit_adv = 0;
				$offset = 1;
				foreach($get_list->result() as $li){
					if($i == 3){
						$get_adv = $this->db->query("select * from sk_post, sk_profile_back, sk_category,sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00001' and sk_post.post_status='1' order by post_modify_date desc limit $limit, $offset");
						foreach($get_adv->result() as $list){
			  ?>
                <li class="promoted">
                  <a onclick="location.href = '<?php echo $list->post_url;?>';">
                    <div class="post-thumbnail"><img src='<?php echo $url_pc;?>uploads/post/original/<?php echo $list->post_thumb;?>' alt=""></div>
                    <div class="post-infos">
                      <div class="post-title">
                        <h4><?php echo $list->post_title;?></h4>
                      </div>
                      <div class="post-category red" style="float:left">Advertorial</div>
                      <div class="post-date"><i class="icon ion-android-time"></i><?php echo date('d M Y',strtotime($list->post_modify_date));?></div>
                    </div>
                  </a>
                </li>
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
						}
						$i++;
						$limit++;
					}else if(($i % 6) == 0){
						$get_adv = $this->db->query("select * from sk_post, sk_profile_back, sk_category,sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00001' and sk_post.post_status='1' order by post_modify_date desc limit $limit, $offset");
						foreach($get_adv->result() as $list){
				?>
                <li class="promoted">
                  <a onclick="location.href = '<?php echo $list->post_url;?>';">
                    <div class="post-thumbnail"><img src='<?php echo $url_pc;?>uploads/post/original/<?php echo $list->post_thumb;?>' alt=""></div>
                    <div class="post-infos">
                      <div class="post-title">
                        <h4><?php echo $list->post_title;?></h4>
                      </div>
                      <div class="post-category red" style="float:left">Advertorial</div>
                      <div class="post-date"><i class="icon ion-android-time"></i><?php echo date('d M Y',strtotime($list->post_modify_date));?></div>
                    </div>
                  </a>
                </li>
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
							}
							$limit++;
						$i++;
						}else if(($i % 7) == 0){
							$get_adv = $this->db->query("select * from sk_adv where position_id='PSB00015' and adv_status='1' order by ObjectID desc limit $limit_adv, $offset");
							foreach($get_adv->result() as $adv){
				?>
				<li class="content-banner">
					<img src="<?php echo $url_pc;?>uploads/advertise/original/<?php echo $adv->adv_pict;?>" style="width:100%;"/>
                </li>
                <?php 
        			foreach($query_adv->result() as $pop){
        				if($pop->position_id == 'PSB00017'){
        		?>
                <li style="background:transparent;height:200px;">
                    <a onclick="location.href = '<?php echo $pop->adv_link;?>';" style="width:100%;height:100%;float:left;">&nbsp;</a>    
                </li>
                <?php 
        				}
        			}
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
							}
							$limit_adv++;
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
			
			  <input type="hidden" id="first2" value="2" />
			  <input type="hidden" id="limit2" value="1" >
            </div>
          </div>
        </div>
      </div>

    </div>
	<script>
		$("#main-adv-close").click(function(){
				$("#main-adv-fixed").fadeOut();
		});
		
		$("#bottom-adv-close").click(function(){
				$("#bottom-adv-fixed").fadeOut();
		});
	</script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/framework7.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/app.js"></script>