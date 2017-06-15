<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Berita extends CI_Controller{
		function __construct(){
			parent::__construct();
		}
		
		function index(){
			$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' order by post_modify_date desc limit 14");
			
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");			
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/home/home-content',$data);
			$this->load->view('front/global/bottom');
		}
		
		function url(){
		  return sprintf(
		    "%s://%s",
		    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
		    $_SERVER['SERVER_NAME']
		  );
		}
		
		function kanal($name){
			$name = urldecode($this->uri->segment(3));
			
			$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' order by sk_post.objectID desc limit 3");
			
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/home/home-kanal',$data);
			$this->load->view('front/global/bottom');
		}
		
		function artikel($id){
			$get_main = $this->db->query("select * from sk_post, sk_kanal, sk_category, sk_profile_back where sk_kanal.kanal_id = sk_category.kanal_id and sk_category.category_id = sk_post.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
			
			//$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."'");
			
			foreach($get_main->result() as $main){
				$data['title_main'] = $main->post_title;
				$data['short_main'] = $main->post_shrt_desc;
				$data['pict_main'] = $main->post_pict;
				$data['desc_main'] = $main->post_desc;
				$data['posted_main'] = $main->profile_back_name_full;
				$data['date_main'] = $main->post_modify_date;
				$data['kanal'] = $main->kanal_name;
				$query_tag = $this->db->query("select sk_tag.tag_id, sk_tag.tag_name from sk_tag, sk_post where sk_tag.tag_id = sk_post.tag_id and sk_post.post_id = '".$main->post_id."'");
				if($query_tag->num_rows() == 0){
					$data['tag_id'] = 'none';
					$data['tag_name'] = 'none';
				}else{
					foreach($query_tag->result() as $tag){
						$data['tag_id'] = $tag->tag_id;
						$data['tag_name'] = $tag->tag_name;
					}
				}
				
				$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag, sk_kanal, sk_category where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.category_id = sk_category.category_id and sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
			
				//$max_before = $this->db->query("select product_id, product_url from purb_product where product_id < '".$prd->product_id."' order by product_id desc limit 1");
				$max_before = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_id < '".$main->post_id."' order by post_modify_date desc limit 1");
				if($max_before->num_rows() == 0){
					$data['before'] = null;
				}else{
					foreach($max_before->result() as $before){
						$data['before'] = $before->post_url;
						$data['before_title'] = $before->post_title;
						$data['before_date'] = $before->post_modify_date;
						$data['before_img'] = $before->post_pict;
					}
				}
				
				//$max_after = $this->db->query("select product_id, product_url from purb_product where product_id > '".$prd->product_id."' order by product_id asc limit 1");
				$max_after = $this->db->query("select * from sk_post, sk_tag, sk_profile_back where sk_post.tag_id = sk_tag.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_id > '".$main->post_id."' order by post_modify_date asc limit 1");
				
				if($max_after->num_rows() == 0){
					$data['after'] = null;
				}else{
					foreach($max_after->result() as $after){
						$data['after'] = $after->post_url;
						$data['after_title'] = $after->post_title;
						$data['after_date'] = $after->post_modify_date;
						$data['after_img'] = $after->post_pict;
					}
				}
			}
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/detail/detail',$data);
			$this->load->view('front/global/bottom');
		}
		
		function get_reaction_post(){
			$url = $this->input->post('url');
			
			
			$senang = 0;
			$terhibur = 0;
			$terinspirasi = 0;
			$tidak_peduli = 0;
			$terganggu = 0;
			$sedih = 0;
			$cemas = 0;
			$marah = 0;
			
			$query = $this->db->query("select sk_reac_article.reaction_id, sk_reaction.reaction_name, count(sk_reac_article.reaction_id) as c_reac from sk_reac_article, sk_reaction, sk_post where sk_reac_article.post_id = sk_post.post_id and sk_reac_article.reaction_id = sk_reaction.reaction_id 
			and sk_post.post_url = '".$url."' group by sk_post.post_url, sk_reac_article.reaction_id, sk_reaction.reaction_name");
			foreach($query->result() as $rct){
				if($rct->reaction_name == 'Senang'){
					$senang = $rct->c_reac;
				}else if($rct->reaction_name == 'Terhibur'){
					$terhibur = $rct->c_reac;
				}else if($rct->reaction_name == 'Terinspirasi'){
					$terinspirasi = $rct->c_reac;
				}else if($rct->reaction_name == 'Tidak Peduli'){
					$tidak_peduli = $rct->c_reac;
				}else if($rct->reaction_name == 'Terganggu'){
					$terganggu = $rct->c_reac;
				}else if($rct->reaction_name == 'Sedih'){
					$sedih = $rct->c_reac;
				}else if($rct->reaction_name == 'Cemas'){
					$cemas = $rct->c_reac;
				}else if($rct->reaction_name == 'Marah'){
					$marah = $rct->c_reac;
				}
			}
			
			
			if($senang == 0){
				$p_senang = 0;
			}else{
				$p_senang = ($senang / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terhibur == 0){
				$p_terhibur = 0;
			}else{
				$p_terhibur = ($terhibur / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terinspirasi == 0){
				$p_terinspirasi = 0;
			}else{	
				$p_terinspirasi = ($terinspirasi / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($tidak_peduli == 0){
				$p_tidak_peduli = 0;
			}else{	
				$p_tidak_peduli = ($tidak_peduli / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($terganggu == 0){
				$p_terganggu = 0;
			}else{	
				$p_terganggu = ($terganggu / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($sedih == 0){
				$p_sedih = 0;
			}else{	
				$p_sedih = ($sedih / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($cemas == 0){
				$p_cemas = 0;
			}else{	
				$p_cemas = ($cemas / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			
			if($marah == 0){
				$p_marah = 0;
			}else{	
				$p_marah = ($marah / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100;
			}
			$data = array(
				'senang' => $p_senang,
				'terhibur' => $p_terhibur,
				'terinspirasi' => $p_terinspirasi,
				'tidak_peduli' => $p_tidak_peduli,
				'terganggu' => $p_terganggu,
				'sedih' => $p_sedih,
				'cemas' => $p_cemas,
				'marah' => $p_marah
			);
				
			echo json_encode($data);
		}
		
		function video(){
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			//$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
			
			//$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
			//$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/video/list',$data);
			$this->load->view('front/global/bottom');
		}
		
		function video_detail(){
			$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = 'Rusunawa+KS+Tubun+Pemprov+Ancam+Beri+Sanksi+Pemenang+Tender' order by post_modify_date desc limit 1");
			
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
			
			$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
			$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
			$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
			
			$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00001' order by post_modify_date desc limit 6");
			
			
			foreach($get_main->result() as $main){
				$data['title_main'] = $main->post_title;
				$data['short_main'] = $main->post_shrt_desc;
				$data['pict_main'] = $main->post_pict;
				$data['desc_main'] = $main->post_desc;
				$data['posted_main'] = $main->profile_back_name_full;
				$data['date_main'] = $main->post_modify_date;
			}
			
			$this->load->view('front/global/top');
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/video/detail',$data);
			$this->load->view('front/global/footer');
			$this->load->view('front/global/bottom');
		}
		
		
		function foto(){
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			//$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
			
			//$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
			//$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/picture/list',$data);
			$this->load->view('front/global/bottom');
		}
		
		function foto_detail(){
			$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = 'Rusunawa+KS+Tubun+Pemprov+Ancam+Beri+Sanksi+Pemenang+Tender' order by post_modify_date desc limit 1");
			
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
			
			$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
			$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
			$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
			
			$data['get_headline'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.category_id = 'CTG00001' order by post_modify_date desc limit 6");
			
			
			foreach($get_main->result() as $main){
				$data['title_main'] = $main->post_title;
				$data['short_main'] = $main->post_shrt_desc;
				$data['pict_main'] = $main->post_pict;
				$data['desc_main'] = $main->post_desc;
				$data['posted_main'] = $main->profile_back_name_full;
				$data['date_main'] = $main->post_modify_date;
			}
			
			$this->load->view('front/global/top');
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/picture/detail',$data);
			$this->load->view('front/global/footer');
			$this->load->view('front/global/bottom');
		}
		
		function key_index($kanal){
			$kanal = urldecode($this->uri->segment(3));
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			//$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
			
			//$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
			//$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
			if($kanal == 'none'){
				$data['get_index'] = $this->db->query("select sk_post.post_title, sk_kanal.kanal_name, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.flag_id = 'FLG00002' order by sk_post.post_modify_date desc");
			}else{
				$data['get_index'] = $this->db->query("select sk_post.post_title, sk_kanal.kanal_name, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and sk_post.flag_id = 'FLG00002' order by sk_post.post_modify_date desc");
			}
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
			
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/key_index/list',$data);
			$this->load->view('front/global/bottom');
		}
		
		function tag($nama){
			$nama = urldecode($this->uri->segment(3));
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
			
			$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
			$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
			$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
			$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_tag.tag_name = '".$nama."' order by sk_post.post_modify_date desc");
			
			$this->load->view('front/global/top');
			$this->load->view('front/global/header2',$menu);
			$this->load->view('front/tag/list',$data);
			$this->load->view('front/global/footer');
			$this->load->view('front/global/bottom');
		}
		
		function dashboard(){
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
			
			$this->load->view('front/dashboard/dashboard_top');
			$this->load->view('front/dashboard/dashboard_header',$menu);
			$this->load->view('front/dashboard/dashboard_main');
			$this->load->view('front/global/footer');
			$this->load->view('front/global/bottom');
		}
	
		function search_process(){
			$word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->input->post('search')));
			$url = str_replace(' ', '+', $word);
			header("Location: ".base_url()."index.php/berita/search/".$url); 
		}
		
		function search($word){
			$word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->uri->segment(3)));
			$data['word'] = $word;
			$url = str_replace(' ', '+', $word);
			//$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			//$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
						
			//$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
			//$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.post_title like '%".$word."%' order by sk_post.post_modify_date desc");
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/global/header',$menu);
			$this->load->view('front/search/list',$data);
			$this->load->view('front/global/bottom');
		}
	
		function get_data(){
			$start = $_POST['start'];
			$limit = $_POST['limit'];
			
			$start1 = $_POST['start1'];
			$limit1 = $_POST['limit1'];
			
			$get_list = $this->db->query("select post_title, category_name, post_modify_date, post_thumb, post_url, post_shrt_desc, sk_post.flag_id, profile_back_name_full from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id AND sk_post.flag_id = 'FLG00002' order by post_modify_date desc limit $start, $limit");
			
			$get_list_adventorial = $this->db->query("select post_title, post_modify_date, post_thumb, post_url, post_shrt_desc, sk_post.flag_id, flag_name, profile_back_name_full from sk_post, sk_flag_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id AND sk_post.flag_id = 'FLG00001' AND sk_post.flag_id = sk_flag_post.flag_id order by post_modify_date desc limit $start1, $limit1");
		
			$data_list = array();
			
			foreach($get_list->result() as $grid1){
				$data_list[] = $grid1;
			}
			
			foreach($get_list_adventorial->result() as $grid2){
				$data_list[] = $grid2;
			}
			echo json_encode($data_list);
		}
		
		function get_data_kanal(){
			$start = $_POST['start'];
			$limit = $_POST['limit'];
			$kanal = $_POST['kanal'];
			
			$get_list = $this->db->query("select post_title, category_name, post_modify_date, post_thumb, post_url, post_shrt_desc, profile_back_name_full from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name = '".$kanal."' order by post_modify_date desc limit $start, $limit");
			
			$data_list = array();
			
			foreach($get_list->result() as $grid1){
				$data_list[] = $grid1;
				
			}
			echo json_encode($data_list);
		}
	
		function login(){
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/login/login',$data);
			$this->load->view('front/global/bottom');
		}
		
		function register(){
			$data['url_pc'] = 'https://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			
			$this->load->view('front/global/top',$data);
			$this->load->view('front/register/register',$data);
			$this->load->view('front/global/bottom');
		}
	}
	
/*End of file berita.php*/
/*Location:.application/controllers/berita.php*/