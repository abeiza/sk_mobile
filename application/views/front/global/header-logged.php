	<script>
	$(function() {
		$('#logout-act').click(function(){
			 var username = $('#username').val();
			 var password = $('#password').val();
			 $.ajax({
				url:"<?php echo base_url();?>index.php/berita/get_logout/",
				cache:false,
				type: "POST",
				dataType: 'json',
				success:function(result){
					location.reload();
				}
			});
		});		  
	});
	</script>
<!-- Swipe Pannel -->
	<div class="panel panel-right panel-reveal">
		<div style="width:84%;float:left;margin:8%;margin-bottom:-10px;">
			<div style="width:50%;float:left;"><i class='ion-ios-person' style="padding:5px 10px;border:1px solid #fff;border-radius:100%;float:left;margin-right:5px;"></i> <h6 style="font-size:12px;padding-top:5px;"><?php echo $name?></h6></div>
			<div style="width:50%;float:left;"><h5 style="float:right;border-left:1px dotted #fff;padding:5px;color:#fff;"><a style="color:#fff;" onclick="location.href = '<?php echo base_url();?>index.php/berita/dashboard/';">Profil</a></h5><h5 style="float:right;padding:5px;"><a style="color:#fff;" id="logout-act">Keluar</a></h5></div>
		</div>
	<?php 
	$attribute = array("id"=>"search-form");
	echo form_open('berita/search_process/', $attribute);?>
      <input type="text" id="search-input" class="search-bar" name="search" placeholder="Search ...">
	  <button type="submit" class="btn-search"><i class="ion-ios-search"></i></button>
      </form>
      <span class="title-categories">Menu Kanal</span>
      <ul id="categorie-list" style="margin-bottom:50px;">
	  <?php foreach($get_menu->result() as $menu){?>
        <li><a style="color:#fff;" onclick="location.href = '<?php echo base_url();?>index.php/berita/kanal/<?php echo $menu->menu_label;?>';"><?php echo $menu->menu_label;?></a></li>
	  <?php 
		}
	  ?>
		<li><a style="color:#fff;" onclick="location.href = '<?php echo base_url();?>index.php/berita/video/';">Video</a></li>
		<li><a style="color:#fff;" onclick="location.href = '<?php echo base_url();?>index.php/berita/foto/';">Gambar</a></li>
		<li><a style="color:#fff;" onclick="location.href = '<?php echo base_url();?>index.php/berita/key_index/none/';">Index</a></li>
		
      </ul>
    </div>
