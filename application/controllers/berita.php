<?php
	if(!defined('BASEPATH'))exit('No Direct Script Access Allowed');
	
	class Berita extends CI_Controller{
		function __construct(){
			parent::__construct();
			
			// Load facebook library
    		$this->load->library('facebook');
    		
    		//Load user model
    		$this->load->model('user');
    		$this->load->model('user_google');
    		$this->load->library('google_url_api');
		}
		
		function index(){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		    include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
		    // Google Project API Credentials
    		$clientId = '669121716175-jlblc6h878vuicdb6gd57s3ubpsup6r1.apps.googleusercontent.com';
            $clientSecret = 'Zn1pmxmsSczZtCc1xMXwzQC_';
            $redirectUrl = base_url() . 'index.php/berita/';
            
            // Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
            	$gClient->authenticate();
            	$this->session->set_userdata('token', $gClient->getAccessToken());
            	redirect($redirectUrl);
            }
            
            $token = $this->session->userdata('token');
            if (!empty($token)) {
            	$gClient->setAccessToken($token);
            }
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");			
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged_home',$menu);
				$this->load->view('front/home/home-content',$data);
				$this->load->view('front/global/bottom_main');
			}else if($this->facebook->is_authenticated()){
			    // Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");			
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged_home',$menu);
				$this->load->view('front/home/home-content',$data);
				$this->load->view('front/global/bottom_main');
			}else if ($gClient->getAccessToken()) {
	
            	$userProfile = $google_oauthV2->userinfo->get();
            	// Preparing data for database insertion
            	$userData['oauth_provider'] = 'google';
            	$userData['oauth_uid'] = $userProfile['id'];
            	$userData['first_name'] = $userProfile['given_name'];
            	$userData['last_name'] = $userProfile['family_name'];
            	$userData['email'] = $userProfile['email'];
            	$userData['gender'] = null;
            	$userData['locale'] = $userProfile['locale'];
            	$userData['profile_url'] = $userProfile['link'];
            	$userData['picture_url'] = $userProfile['picture'];
            	
            	$data_int['guest_name'] = $userProfile['given_name']." ".$userProfile['family_name'];
            	$data_int['guest_email'] = $userProfile['email'];
            	$data_int['guest_username'] = null;
            	$data_int['guest_password'] = null;
            	$data_int['guest_status'] = 1;
            	$data_int['guest_log_date'] = date('Y-m-d H:i:s');
            	$data_int['oauth_provider'] = 'google';
            	$data_int['oauth_uid'] = $userProfile['id'];
            	
            	$photo = $userProfile['picture'];
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	$exct = $this->user_google->checkUser_internal($data_int, $photo);
            	
            	// Insert or update user data
            	$userID = $this->user_google->checkUser($userData);
            	if(!empty($userID)){
            		$data['userData'] = $userData;
            		$this->session->set_userdata('userData',$userData);
            	} else {
            	   $data['userData'] = array();
            	}
            	
            	$data['logout_link'] = $this->facebook->logout_url();
	
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");			
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged_home',$menu);
				$this->load->view('front/home/home-content',$data);
				$this->load->view('front/global/bottom_main');
			}else{
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");			
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header_home',$menu);
				$this->load->view('front/home/home-content',$data);
				$this->load->view('front/global/bottom_main');
			}
		}
		
		function sosmed(){
		    $userData = array();
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");			
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged_home',$menu);
				$this->load->view('front/home/home-content',$data);
				$this->load->view('front/global/bottom');
			}else if($this->facebook->is_authenticated()){
			    // Get user facebook profile details
        		$userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
        
                // Preparing data for database insertion
                $userData['oauth_provider'] = 'facebook';
                $userData['oauth_uid'] = $userProfile['id'];
                $userData['first_name'] = $userProfile['first_name'];
                $userData['last_name'] = $userProfile['last_name'];
                $userData['email'] = $userProfile['email'];
                $userData['gender'] = $userProfile['gender'];
                $userData['locale'] = $userProfile['locale'];
                $userData['profile_url'] = 'https://www.facebook.com/'.$userProfile['id'];
                $userData['picture_url'] = $userProfile['picture']['data']['url'];
                
                $data_int['guest_name'] = $userProfile['first_name']." ".$userProfile['last_name'];
                $data_int['guest_email'] = $userProfile['email'];
                $data_int['guest_username'] = null;
                $data_int['guest_password'] = null;
                $data_int['guest_status'] = 1;
                $data_int['guest_log_date'] = date('Y-m-d H:i:s');
        		$data_int['oauth_provider'] = 'facebook';
                $data_int['oauth_uid'] = $userProfile['id'];
                
                $photo = $userProfile['picture']['data']['url'];
                
                // Insert or update user data
                $userID = $this->user->checkUser($userData);
                $exct = $this->user->checkUser_internal($data_int, $photo);
        		
        		// Check user data insert or update status
                if(!empty($userID)){
                    $data['userData'] = $userData;
                    $this->session->set_userdata('userData',$userData);
                }else{
                   $data['userData'] = array();
                }
				
				$data['logout_link'] = $this->facebook->logout_url();
				
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");			
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged_home',$menu);
				$this->load->view('front/home/home-content',$data);
				$this->load->view('front/global/bottom');
			}else{
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by post_modify_date desc limit 14");
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");			
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				// Store users facebook login url
                $data['login_url'] = $this->facebook->login_url();;
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header_home',$menu);
				$this->load->view('front/home/home-content',$data);
				$this->load->view('front/global/bottom');
			}
		}
		
		
		function url(){
		  return sprintf(
		    "%s://%s",
		    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
		    $_SERVER['SERVER_NAME']
		  );
		}
		
		function kanal($name){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$name = urldecode($this->uri->segment(3));
				
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' order by sk_post.objectID desc limit 3");
				
				$menu['name'] = $this->session->userdata('user_name');
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/home/home-kanal',$data);
				$this->load->view('front/global/bottom');
			}else{
				$name = urldecode($this->uri->segment(3));
				
				$data['get_list'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_flag_post, sk_kanal where sk_flag_post.flag_id = sk_post.flag_id and sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' and sk_kanal.kanal_name='".$name."' order by post_modify_date desc limit 14");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_main'] = $this->db->query("select * from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_category.category_name = 'Regular' and sk_kanal.kanal_name='".$name."' and sk_post.flag_id = 'FLG00002' order by sk_post.objectID desc limit 3");
				$query_knl = $this->db->query("select kanal_id from sk_kanal where sk_kanal.kanal_name='".$name."'");
				foreach($query_knl->result() as $k){
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='".$k->kanal_id."'");
				}
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				
				$data['title_main'] = '';
				$data['posted_main'] = '';
				$data['short_main'] = '';
				$data['key_main'] = 'home, beranda, suarakarya, suarakaryanews.com';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$menu);
				$this->load->view('front/home/home-kanal',$data);
				$this->load->view('front/global/bottom');
			}
		}
		
		function artikel($id){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$get_main = $this->db->query("select * from sk_post, sk_kanal, sk_category, sk_profile_back where sk_kanal.kanal_id = sk_category.kanal_id and sk_category.category_id = sk_post.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				//$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				foreach($get_main->result() as $main){
					$data['id_post'] = $main->post_id;
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['pict_main'] = $main->post_pict;
					$data['desc_main'] = $main->post_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['kanal'] = $main->kanal_name;
					$data['key_main'] = $main->post_keywords;
					$data['img'] = "http://suarakaryanews.com/uploads/post/original/".$main->post_pict;
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
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-news' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
						
					
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
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$url = "http://m.suarakaryanews.com/index.php/berita/artikel/".$this->uri->segment(3);
                /* if you want switch debug mode, please replace FALSE with TRUE*/
                $this->google_url_api->enable_debug(FALSE);
                
                /**
                 * shorten example
                 */                 
                
                $short_url = $this->google_url_api->shorten($url);
                //echo $url . " => " . $short_url->id . "<br />";
                //echo 'Response code: ' . $this->google_url_api->get_http_status();
				
				$data['shortDWName'] = $short_url->id;
            	
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/detail/detail',$data);
				$this->load->view('front/global/bottom');
			}else{
				$get_main = $this->db->query("select * from sk_post, sk_kanal, sk_category, sk_profile_back where sk_kanal.kanal_id = sk_category.kanal_id and sk_category.category_id = sk_post.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				//$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				foreach($get_main->result() as $main){
					$data['id_post'] = $main->post_id;
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['pict_main'] = $main->post_pict;
					$data['desc_main'] = $main->post_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['kanal'] = $main->kanal_name;
					$data['key_main'] = $main->post_keywords;
					$data['img'] = "http://suarakaryanews.com/uploads/post/original/".$main->post_pict;
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
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-news' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
						
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
				
				$url = "http://m.suarakaryanews.com/index.php/berita/artikel/".$this->uri->segment(3);
                /* if you want switch debug mode, please replace FALSE with TRUE*/
                $this->google_url_api->enable_debug(FALSE);
                
                /**
                 * shorten example
                 */                 
                
                $short_url = $this->google_url_api->shorten($url);
                //echo $url . " => " . $short_url->id . "<br />";
                //echo 'Response code: ' . $this->google_url_api->get_http_status();
				
				$data['shortDWName'] = $short_url->id;
            	
                // Test: Shorten a URL
                //$data['shortDWName'] = $googer->shorten("http://m.suarakaryanews.com/berita/artikel/".$this->uri->segment(3));
                //echo $shortDWName; // returns http://goo.gl/i002
                
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$menu);
				$this->load->view('front/detail/detail',$data);
				$this->load->view('front/global/bottom');
			}
		}
		
		function comment($id){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$get_main = $this->db->query("select * from sk_post, sk_kanal, sk_category, sk_profile_back where sk_kanal.kanal_id = sk_category.kanal_id and sk_category.category_id = sk_post.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_status='1' and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				//$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				foreach($get_main->result() as $main){
					$data['id_post'] = $main->post_id;
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['pict_main'] = $main->post_pict;
					$data['desc_main'] = $main->post_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['kanal'] = $main->kanal_name;
					$data['key_main'] = $main->post_keywords;
					$data['img'] = "http://suarakaryanews.com/uploads/post/original/".$main->post_pict;
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
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-news' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
						
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
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/detail/comment',$data);
				$this->load->view('front/global/bottom');
			}else{
				$get_main = $this->db->query("select * from sk_post, sk_kanal, sk_category, sk_profile_back where sk_kanal.kanal_id = sk_category.kanal_id and sk_category.category_id = sk_post.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_status='1' and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				//$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				foreach($get_main->result() as $main){
					$data['id_post'] = $main->post_id;
					$data['title_main'] = $main->post_title;
					$data['short_main'] = $main->post_shrt_desc;
					$data['pict_main'] = $main->post_pict;
					$data['desc_main'] = $main->post_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->post_modify_date;
					$data['kanal'] = $main->kanal_name;
					$data['key_main'] = $main->post_keywords;
					$data['img'] = "http://suarakaryanews.com/uploads/post/original/".$main->post_pict;
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
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-news' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
						
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
				$this->load->view('front/detail/comment',$data);
				$this->load->view('front/global/bottom');
			}
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
				$p_senang = round(($senang / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($terhibur == 0){
				$p_terhibur = 0;
			}else{
				$p_terhibur = round(($terhibur / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($terinspirasi == 0){
				$p_terinspirasi = 0;
			}else{	
				$p_terinspirasi = round(($terinspirasi / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($tidak_peduli == 0){
				$p_tidak_peduli = 0;
			}else{	
				$p_tidak_peduli = round(($tidak_peduli / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($terganggu == 0){
				$p_terganggu = 0;
			}else{	
				$p_terganggu = round(($terganggu / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($sedih == 0){
				$p_sedih = 0;
			}else{	
				$p_sedih = round(($sedih / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($cemas == 0){
				$p_cemas = 0;
			}else{	
				$p_cemas = round(($cemas / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
			}
			
			if($marah == 0){
				$p_marah = 0;
			}else{	
				$p_marah = round(($marah / ($senang + $terhibur + $terinspirasi + $tidak_peduli + $terganggu + $sedih + $cemas + $marah)) * 100);
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
		
		function get_reaction_video(){
			$url = $this->input->post('url');
			
			
			$senang = 0;
			$terhibur = 0;
			$terinspirasi = 0;
			$tidak_peduli = 0;
			$terganggu = 0;
			$sedih = 0;
			$cemas = 0;
			$marah = 0;
			
			$query = $this->db->query("select sk_reac_article.reaction_id, sk_reaction.reaction_name, count(sk_reac_article.reaction_id) as c_reac from sk_reac_article, sk_reaction, sk_video where sk_reac_article.post_id = sk_video.video_id and sk_reac_article.reaction_id = sk_reaction.reaction_id 
			and sk_video.video_url = '".$url."' group by sk_video.video_url, sk_reac_article.reaction_id, sk_reaction.reaction_name");
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
		
		function get_reaction_photo(){
			$url = $this->input->post('url');
			
			
			$senang = 0;
			$terhibur = 0;
			$terinspirasi = 0;
			$tidak_peduli = 0;
			$terganggu = 0;
			$sedih = 0;
			$cemas = 0;
			$marah = 0;
			
			$query = $this->db->query("select sk_reac_article.reaction_id, sk_reaction.reaction_name, count(sk_reac_article.reaction_id) as c_reac from sk_reac_article, sk_reaction, sk_photo where sk_reac_article.post_id = sk_photo.pict_id and sk_reac_article.reaction_id = sk_reaction.reaction_id 
			and sk_photo.pict_url = '".$url."' group by sk_photo.pict_url, sk_reac_article.reaction_id, sk_reaction.reaction_name");
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
		
		
		
		function set_reaction_post(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$reaction = $this->input->post("reac");
				$post_id = $this->input->post("post");
				$query_validation = $this->db->query("select * from sk_reac_article, sk_post where sk_reac_article.guest_id = '".$this->session->userdata('user_id')."' and sk_reac_article.post_id = sk_post.post_id and sk_reac_article.post_id = '".$post_id."'");
				if($query_validation->num_rows() == 0 ){
					$data['reaction_id'] = $reaction;
					$data['post_id'] = $post_id;
					$data['guest_id'] = $this->session->userdata('user_id');
					$data['reac_posted_date'] = date("Y-m-d H:s:i");
					
					$post_reaction = $this->sk_model->insert_data('sk_reac_article', $data);
					if($post_reaction){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}else{
					$dataz = array(
						'status' => 'available',
					);
					echo json_encode($dataz);
				}
			}else{				
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		function set_reaction_video(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$reaction = $this->input->post("reac");
				$video_id = $this->input->post("post");
				$query_validation = $this->db->query("select * from sk_reac_article, sk_video where sk_reac_article.guest_id = '".$this->session->userdata('user_id')."' and sk_reac_article.post_id = sk_video.video_id and sk_reac_article.post_id = '".$video_id."'");
				if($query_validation->num_rows() == 0 ){
					$data['reaction_id'] = $reaction;
					$data['post_id'] = $video_id;
					$data['guest_id'] = $this->session->userdata('user_id');
					$data['reac_posted_date'] = date("Y-m-d H:s:i");
					
					$post_reaction = $this->sk_model->insert_data('sk_reac_article', $data);
					if($post_reaction){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}else{
					$dataz = array(
						'status' => 'available',
					);
					echo json_encode($dataz);
				}
			}else{				
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		function set_reaction_photo(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$reaction = $this->input->post("reac");
				$photo_id = $this->input->post("post");
				$query_validation = $this->db->query("select * from sk_reac_article, sk_photo where sk_reac_article.guest_id = '".$this->session->userdata('user_id')."' and sk_reac_article.post_id = sk_photo.pict_id and sk_reac_article.post_id = '".$photo_id."'");
				if($query_validation->num_rows() == 0 ){
					$data['reaction_id'] = $reaction;
					$data['post_id'] = $photo_id;
					$data['guest_id'] = $this->session->userdata('user_id');
					$data['reac_posted_date'] = date("Y-m-d H:s:i");
					
					$post_reaction = $this->sk_model->insert_data('sk_reac_article', $data);
					if($post_reaction){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}else{
					$dataz = array(
						'status' => 'available',
					);
					echo json_encode($dataz);
				}
			}else{				
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		
		
		function get_comment_post(){
			$url = $this->input->post('url');
			$query_comment_post = $this->db->query("select sk_guest.guest_name, sk_guest_profile.guest_profile_pict, sk_comment.comment_post_date, sk_comment.comment_text, sk_comment.comment_order, sk_comment.comment_ref_id, sk_comment.comment_id from sk_comment, sk_post, sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$url."' order by sk_comment.comment_ref_id desc, sk_comment.comment_id");
			$data_list_a = array();
			
			foreach($query_comment_post->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		function get_comment_video(){
			$url = $this->input->post('url');
			$query_comment_post = $this->db->query("select sk_guest.guest_name, sk_guest_profile.guest_profile_pict, sk_comment.comment_post_date, sk_comment.comment_text, sk_comment.comment_order, sk_comment.comment_ref_id, sk_comment.comment_id from sk_comment, sk_video, sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_comment.post_id = sk_video.video_id and sk_comment.guest_id = sk_guest.guest_id and sk_video.video_url = '".$url."' order by sk_comment.comment_ref_id desc, sk_comment.comment_id");
			$data_list_a = array();
			
			foreach($query_comment_post->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		function get_comment_photo(){
			$url = $this->input->post('url');
			$query_comment_post = $this->db->query("select sk_guest.guest_name, sk_guest_profile.guest_profile_pict, sk_comment.comment_post_date, sk_comment.comment_text, sk_comment.comment_order, sk_comment.comment_ref_id, sk_comment.comment_id from sk_comment, sk_photo, sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_comment.post_id = sk_photo.pict_id and sk_comment.guest_id = sk_guest.guest_id and sk_photo.pict_url = '".$url."' order by sk_comment.comment_ref_id desc, sk_comment.comment_id");
			$data_list_a = array();
			
			foreach($query_comment_post->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		
		
		function set_comment_post(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$this->form_validation->set_rules('comment','komentar','required');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$data['comment_id'] = $this->sk_model->getMaxKodelong('sk_comment', 'comment_id', 'CMD');
					$data['guest_id'] = $this->session->userdata("user_id");
					$data['post_id'] = $this->input->post("post");
					$data['comment_order'] = '1';
					$data['comment_flag'] = '0';
					$data['comment_ref_id'] = $data['comment_id'];
					$data['comment_post_date'] = date('Y-m-d H:s:i');
					$data['comment_text'] = $this->input->post("comment");
					
					$post_comment = $this->sk_model->insert_data('sk_comment', $data);
					if($post_comment){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}
			}else{
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		
		function set_comment_post_tanggapan(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$this->form_validation->set_rules('comment','komentar','required');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$data['comment_id'] = $this->sk_model->getMaxKodelong('sk_comment', 'comment_id', 'CMD');
					$data['guest_id'] = $this->session->userdata("user_id");
					$data['post_id'] = $this->input->post("post");
					$data['comment_order'] = '2';
					$data['comment_flag'] = '0';
					$data['comment_ref_id'] = $this->input->post("id_comment");
					$data['comment_post_date'] = date('Y-m-d H:s:i');
					$data['comment_text'] = $this->input->post("comment");
					
					$post_comment = $this->sk_model->insert_data('sk_comment', $data);
					if($post_comment){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}
			}else{
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		function get_filter_index(){
			$filter = $this->input->post('filter');
			$nama_kanal = $this->input->post('kanal');
			
			$query_check_kanal = $this->db->query("select * from sk_kanal where kanal_name = '".$nama_kanal."'");
			if($query_check_kanal->num_rows() == 0){
				$kanal = 'none';
			}else{
				$kanal = $nama_kanal;
			}
			
			if($kanal == 'none'){
				$query_filter = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_post.post_modify_date) = '".date('Y',strtotime($filter))."' and month(sk_post.post_modify_date) = '".date('m',strtotime($filter))."' and day(sk_post.post_modify_date) = '".date('d',strtotime($filter))."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.post_modify_date desc");
			}else{
				$query_filter = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name from sk_post, sk_category, sk_kanal where sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_post.post_modify_date) = '".date('Y',strtotime($filter))."' and month(sk_post.post_modify_date) = '".date('m',strtotime($filter))."' and day(sk_post.post_modify_date) = '".date('d',strtotime($filter))."' and sk_post.flag_id = 'FLG00002' and sk_post.post_status='1' order by sk_post.post_modify_date desc");
			}
			$data_list_a = array();
			
			foreach($query_filter->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		function get_filter_index_video(){
			$filter = $this->input->post('filter');
			$nama_kanal = $this->input->post('kanal');
			
			$query_check_kanal = $this->db->query("select * from sk_kanal where kanal_name = '".$nama_kanal."'");
			if($query_check_kanal->num_rows() == 0){
				$kanal = 'none';
			}else{
				$kanal = $nama_kanal;
			}
			
			if($kanal == 'none'){
				$query_filter = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_video.video_modify_date) = '".date('Y',strtotime($filter))."' and month(sk_video.video_modify_date) = '".date('m',strtotime($filter))."' and day(sk_video.video_modify_date) = '".date('d',strtotime($filter))."' and sk_video.video_status='1' order by sk_video.video_modify_date desc");
			}else{
				$query_filter = $this->db->query("select sk_video.video_title, sk_video.video_url, sk_video.video_modify_date, sk_category.category_name from sk_video, sk_category, sk_kanal where sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_video.video_modify_date) = '".date('Y',strtotime($filter))."' and month(sk_video.video_modify_date) = '".date('m',strtotime($filter))."' and day(sk_video.video_modify_date) = '".date('d',strtotime($filter))."' and sk_video.video_status='1' order by sk_video.video_modify_date desc");
			}
			$data_list_a = array();
			
			foreach($query_filter->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		function get_filter_index_photo(){
			$filter = $this->input->post('filter');
			$nama_kanal = $this->input->post('kanal');
			
			$query_check_kanal = $this->db->query("select * from sk_kanal where kanal_name = '".$nama_kanal."'");
			if($query_check_kanal->num_rows() == 0){
				$kanal = 'none';
			}else{
				$kanal = $nama_kanal;
			}
			
			if($kanal == 'none'){
				$query_filter = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and year(sk_photo.pict_create_date) = '".date('Y',strtotime($filter))."' and month(sk_photo.pict_create_date) = '".date('m',strtotime($filter))."' and day(sk_photo.pict_create_date) = '".date('d',strtotime($filter))."' and sk_photo.pict_status='1' order by sk_photo.pict_create_date desc");
			}else{
				$query_filter = $this->db->query("select sk_photo.pict_title, sk_photo.pict_url, sk_photo.pict_create_date, sk_category.category_name from sk_photo, sk_category, sk_kanal where sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_kanal.kanal_name = '".$kanal."' and year(sk_photo.pict_create_date) = '".date('Y',strtotime($filter))."' and month(sk_photo.pict_create_date) = '".date('m',strtotime($filter))."' and day(sk_photo.pict_create_date) = '".date('d',strtotime($filter))."' and sk_photo.pict_status='1' order by sk_photo.pict_create_date desc");
			}
			$data_list_a = array();
			
			foreach($query_filter->result() as $grid1){
				$data_list_a[] = $grid1;
			}
	
			echo json_encode($data_list_a);
		}
		
		
		function video(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_video_main'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
					and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 1, 18");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'video' and sk_adv_layout.kanal_id='home'");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/video/list',$data);
				$this->load->view('front/global/bottom');
			}else{
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_video_main'] = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category where sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' 
					and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc limit 1, 18");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'video' and sk_adv_layout.kanal_id='home'");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$menu);
				$this->load->view('front/video/list',$data);
				$this->load->view('front/global/bottom');
			}
		}
		
		function video_detail($id){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$id = $this->uri->segment(3);
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_video_main = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' and sk_video.video_url = '".$id."' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc");
				
				
				foreach($get_video_main->result() as $main){
					$data['title_main'] = $main->video_title;
					$data['short_main'] = $main->video_short_desc;
					$data['link'] = $main->video_link;
					$data['desc_main'] = $main->video_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->video_modify_date;
					$data['id_post'] = $main->video_id;
					$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag, sk_kanal, sk_category where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.category_id = sk_category.category_id and sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-video' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->video_keywords;
					$data['img'] = $main->video_link; 
				}
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$url = "http://m.suarakaryanews.com/index.php/berita/video_detail/".$this->uri->segment(3);
                /* if you want switch debug mode, please replace FALSE with TRUE*/
                $this->google_url_api->enable_debug(FALSE);
                
                /**
                 * shorten example
                 */                 
                
                $short_url = $this->google_url_api->shorten($url);
                //echo $url . " => " . $short_url->id . "<br />";
                //echo 'Response code: ' . $this->google_url_api->get_http_status();
				
				$data['shortDWName'] = $short_url->id;
            	
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/video/detail',$data);
				$this->load->view('front/global/bottom');
			}else{
				$id = $this->uri->segment(3);
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_video_main = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' and sk_video.video_url = '".$id."' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc");
				
				
				foreach($get_video_main->result() as $main){
					$data['title_main'] = $main->video_title;
					$data['short_main'] = $main->video_short_desc;
					$data['link'] = $main->video_link;
					$data['desc_main'] = $main->video_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->video_modify_date;
					$data['id_post'] = $main->video_id;
					$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag, sk_kanal, sk_category where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.category_id = sk_category.category_id and sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-video' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->video_keywords;
					$data['img'] = $main->video_link; 
				}
				
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$menu['name'] = $this->session->userdata('user_name');
				$url = "http://m.suarakaryanews.com/index.php/berita/video_detail/".$this->uri->segment(3);
                /* if you want switch debug mode, please replace FALSE with TRUE*/
                $this->google_url_api->enable_debug(FALSE);
                
                /**
                 * shorten example
                 */                 
                
                $short_url = $this->google_url_api->shorten($url);
                //echo $url . " => " . $short_url->id . "<br />";
                //echo 'Response code: ' . $this->google_url_api->get_http_status();
				
				$data['shortDWName'] = $short_url->id;
            	
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$menu);
				$this->load->view('front/video/detail',$data);
				$this->load->view('front/global/bottom');
			}
		}
		
		function video_comment($id){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$get_video_main = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' and sk_video.video_url = '".$id."' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc");
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_video, sk_guest where sk_comment.post_id = sk_video.video_id and sk_comment.guest_id = sk_guest.guest_id and sk_video.video_status='1' and sk_video.video_url = '".$this->uri->segment(3)."'");
				
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				//$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				foreach($get_video_main->result() as $main){
					$data['title_main'] = $main->video_title;
					$data['short_main'] = $main->video_short_desc;
					$data['link'] = $main->video_link;
					$data['desc_main'] = $main->video_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->video_modify_date;
					$data['id_post'] = $main->video_id;
					$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-video' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->video_keywords;
					$data['img'] = $main->video_link; 
				}
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/video/comment',$data);
				$this->load->view('front/global/bottom');
			}else{
				$get_video_main = $this->db->query("select * from sk_video, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_video.video_posted_by = sk_user_back.user_back_id and sk_video.video_status = '1' and sk_video.video_url = '".$id."' 
				and sk_video.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_video.video_modify_date desc");
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_video, sk_guest where sk_comment.post_id = sk_video.video_id and sk_comment.guest_id = sk_guest.guest_id and sk_video.video_status='1' and sk_video.video_url = '".$this->uri->segment(3)."'");
				
				foreach($get_video_main->result() as $main){
					$data['title_main'] = $main->video_title;
					$data['short_main'] = $main->video_short_desc;
					$data['link'] = $main->video_link;
					$data['desc_main'] = $main->video_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->video_modify_date;
					$data['id_post'] = $main->video_id;
					$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-video' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					$data['key_main'] = $main->video_keywords;
					$data['img'] = $main->video_link; 
				}
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$menu);
				$this->load->view('front/video/comment',$data);
				$this->load->view('front/global/bottom');
			}
		}
		
		
		function foto(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_photo_main'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 1, 18");
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'photo' and sk_adv_layout.kanal_id='home'");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/picture/list',$data);
				$this->load->view('front/global/bottom');
			}else{
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['get_photo_main'] = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category where sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_modify_date desc limit 1, 18");
				
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'photo' and sk_adv_layout.kanal_id='home'");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$menu);
				$this->load->view('front/picture/list',$data);
				$this->load->view('front/global/bottom');
			}
		}
		
		function foto_detail($id){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$id = $this->uri->segment(3);
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_photo_main = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' and sk_photo.pict_url = '".$id."' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_create_date desc");
			
				foreach($get_photo_main->result() as $main){
					$data['pict_id'] = $main->pict_id;
					$data['id_post'] = $main->pict_id;
					$data['title_main'] = $main->pict_title;
					$data['short_main'] = $main->pict_short_desc;
					$data['desc_main'] = $main->pict_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->pict_create_date;
					$data['key_main'] = $main->pict_keywords;
					$query_pk_img = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$main->pict_id."' order by ObjectID limit 1");
					foreach($query_pk_img->result() as $pd_main){
						$data['img'] = 'http://suarakaryanews.com/uploads/pict/original/'. $pd_main->pict_detail_url; 
					}
					$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag, sk_kanal, sk_category where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.category_id = sk_category.category_id and sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-photo' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					
				}
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				
				$url = "http://m.suarakaryanews.com/index.php/berita/foto_detail/".$this->uri->segment(3);
                /* if you want switch debug mode, please replace FALSE with TRUE*/
                $this->google_url_api->enable_debug(FALSE);
                
                /**
                 * shorten example
                 */                 
                
                $short_url = $this->google_url_api->shorten($url);
                //echo $url . " => " . $short_url->id . "<br />";
                //echo 'Response code: ' . $this->google_url_api->get_http_status();
				
				$data['shortDWName'] = $short_url->id;
            	
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/picture/detail',$data);
				$this->load->view('front/global/bottom');
				
			}else{
				$id = $this->uri->segment(3);
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$get_photo_main = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' and sk_photo.pict_url = '".$id."' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_create_date desc");
			
				foreach($get_photo_main->result() as $main){
					$data['pict_id'] = $main->pict_id;
					$data['id_post'] = $main->pict_id;
					$data['title_main'] = $main->pict_title;
					$data['short_main'] = $main->pict_short_desc;
					$data['desc_main'] = $main->pict_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->pict_create_date;
					$data['key_main'] = $main->pict_keywords;
					$query_pk_img = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$main->pict_id."' order by ObjectID limit 1");
					foreach($query_pk_img->result() as $pd_main){
						$data['img'] = 'http://suarakaryanews.com/uploads/pict/original/'. $pd_main->pict_detail_url; 
					}
					$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag, sk_kanal, sk_category where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.category_id = sk_category.category_id and sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-photo' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					
				}
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				
				$url = "http://m.suarakaryanews.com/index.php/berita/foto_detail/".$this->uri->segment(3);
                /* if you want switch debug mode, please replace FALSE with TRUE*/
                $this->google_url_api->enable_debug(FALSE);
                
                /**
                 * shorten example
                 */                 
                
                $short_url = $this->google_url_api->shorten($url);
                //echo $url . " => " . $short_url->id . "<br />";
                //echo 'Response code: ' . $this->google_url_api->get_http_status();
				
				$data['shortDWName'] = $short_url->id;
            	
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$menu);
				$this->load->view('front/picture/detail',$data);
				$this->load->view('front/global/bottom');
				
			}
		}
		
		function foto_comment($id){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$get_photo_main = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' and sk_photo.pict_url = '".$id."' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_create_date desc");
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_photo, sk_guest where sk_comment.post_id = sk_photo.pict_id and sk_comment.guest_id = sk_guest.guest_id and sk_photo.pict_status='1' and sk_photo.pict_url = '".$this->uri->segment(3)."'");
				
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				//$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				foreach($get_photo_main->result() as $main){
					$data['pict_id'] = $main->pict_id;
					$data['id_post'] = $main->pict_id;
					$data['title_main'] = $main->pict_title;
					$data['short_main'] = $main->pict_short_desc;
					$data['desc_main'] = $main->pict_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->pict_create_date;
					$data['key_main'] = $main->pict_keywords;
					$query_pk_img = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$main->pict_id."' order by ObjectID limit 1");
					foreach($query_pk_img->result() as $pd_main){
						$data['img'] = 'http://suarakaryanews.com/uploads/pict/original/'. $pd_main->pict_detail_url; 
					}
					$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag, sk_kanal, sk_category where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.category_id = sk_category.category_id and sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-photo' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					
				}
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/picture/comment',$data);
				$this->load->view('front/global/bottom');
			}else{
				$get_photo_main = $this->db->query("select * from sk_photo, sk_kanal, sk_user_back, sk_category, sk_profile_back 
				where sk_profile_back.user_back_id = sk_user_back.user_back_id and sk_photo.pict_posted_by = sk_user_back.user_back_id and sk_photo.pict_status = '1' and sk_photo.pict_url = '".$id."' 
				and sk_photo.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id order by sk_photo.pict_create_date desc");
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_photo, sk_guest where sk_comment.post_id = sk_photo.pict_id and sk_comment.guest_id = sk_guest.guest_id and sk_photo.pict_status='1' and sk_photo.pict_url = '".$this->uri->segment(3)."'");
				
				//$data['get_comment'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."' and sk_comment.comment_ref_id is null order by sk_comment.comment_id desc");
				
				//$data['get_comment_count'] = $this->db->query("select * from sk_comment, sk_post, sk_guest where sk_comment.post_id = sk_post.post_id and sk_comment.guest_id = sk_guest.guest_id and sk_post.post_url = '".$this->uri->segment(3)."'");
				
				foreach($get_photo_main->result() as $main){
					$data['pict_id'] = $main->pict_id;
					$data['id_post'] = $main->pict_id;
					$data['title_main'] = $main->pict_title;
					$data['short_main'] = $main->pict_short_desc;
					$data['desc_main'] = $main->pict_desc;
					$data['posted_main'] = $main->profile_back_name_full;
					$data['date_main'] = $main->pict_create_date;
					$data['key_main'] = $main->pict_keywords;
					$query_pk_img = $this->db->query("select pict_detail_url from sk_photo_detail where ref_pict_id = '".$main->pict_id."' order by ObjectID limit 1");
					foreach($query_pk_img->result() as $pd_main){
						$data['img'] = 'http://suarakaryanews.com/uploads/pict/original/'. $pd_main->pict_detail_url; 
					}
					$data['get_other'] = $this->db->query("select * from sk_post, sk_profile_back, sk_tag, sk_kanal, sk_category where sk_category.kanal_id = sk_kanal.kanal_id and sk_post.category_id = sk_category.category_id and sk_tag.tag_id = sk_post.tag_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = '".$main->tag_id."' order by post_modify_date desc limit 6");
					$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'single-photo' and sk_adv_layout.kanal_id='".$main->kanal_id."'");
					
				}
				
				$menu['name'] = $this->session->userdata('user_name');
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header',$menu);
				$this->load->view('front/picture/comment',$data);
				$this->load->view('front/global/bottom');
			}
		}
		
		function key_index($kanal){
		    $cek = $this->session->userdata('loginsuccess');
			if($cek){
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
    			$data['url_pc'] = 'http://suarakaryanews.com/';
    			$data['url_mobile'] = $this->url();
    			//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
    			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
    			$menu['name'] = $this->session->userdata('user_name');
    			$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
    			$this->load->view('front/global/top',$data);
    			$this->load->view('front/global/header-logged',$menu);
    			$this->load->view('front/key_index/list',$data);
    			$this->load->view('front/global/bottom');
			}else{
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
    			$data['url_pc'] = 'http://suarakaryanews.com/';
    			$data['url_mobile'] = $this->url();
    			//$data['get_commended'] = $this->db->query("select post_title, post_modify_date from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date asc limit 5");
    			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 5");
    			$menu['name'] = $this->session->userdata('user_name');
    			$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
    			$this->load->view('front/global/top',$data);
    			$this->load->view('front/global/header',$menu);
    			$this->load->view('front/key_index/list',$data);
    			$this->load->view('front/global/bottom'); 
			}
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
		
		function search_process(){
			$word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->input->post('search')));
			$url = str_replace(' ', '+', $word);
			header("Location: ".base_url()."index.php/berita/search/".$url); 
		}
		
		function search($word){
		    $cek = $this->session->userdata('loginsuccess');
			if($cek){
			    $word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->uri->segment(3)));
    			$data['word'] = $word;
    			$url = str_replace(' ', '+', $word);
    			//$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
    			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
    			//$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
    						
    			//$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
    			//$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
    			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
    			$data['url_pc'] = 'http://suarakaryanews.com/';
    			$data['url_mobile'] = $this->url();
    			$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.post_title like '%".$word."%' order by sk_post.post_modify_date desc");
    			$menu['name'] = $this->session->userdata('user_name');
    			$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
    			$this->load->view('front/global/top',$data);
    			$this->load->view('front/global/header-logged',$menu);
    			$this->load->view('front/search/list',$data);
    			$this->load->view('front/global/bottom');
			}else{
			    $word = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', urldecode($this->uri->segment(3)));
    			$data['word'] = $word;
    			$url = str_replace(' ', '+', $word);
    			//$get_main = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_post.post_url = '".$this->uri->segment(3)."' order by post_modify_date desc limit 1");
    			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
    			//$menu['get_break'] = $this->db->query("select * from sk_post, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id order by post_modify_date desc limit 6");
    						
    			//$data['get_popular'] = $this->db->query("select post_title, post_modify_date, post_url, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by tag_name, c_counter desc limit 10");
    			//$data['get_commended'] = $this->db->query("SELECT post_title, post_url, post_modify_date, count(sk_comment.post_id) as c_comment FROM `sk_comment`, sk_post where sk_post.post_id = sk_comment.post_id group by sk_comment.post_id order by c_comment desc limit 10");
    			//$data['get_sorot'] = $this->db->query("select tag_name, count(counter_uri) as c_counter from sk_tag, sk_post, sk_log_counter where sk_tag.tag_id = sk_post.tag_id and sk_post.post_url = sk_log_counter.counter_uri group by tag_name order by c_counter desc limit 10");
    			$data['url_pc'] = 'http://suarakaryanews.com/';
    			$data['url_mobile'] = $this->url();
    			$data['get_data'] = $this->db->query("select sk_post.post_title, sk_post.post_url, sk_post.post_modify_date, sk_category.category_name, sk_kanal.kanal_name, sk_profile_back.profile_back_name_full, sk_post.post_shrt_desc, sk_post.post_thumb from sk_post, sk_category, sk_kanal, sk_tag, sk_profile_back where sk_post.post_posted_by = sk_profile_back.user_back_id and sk_tag.tag_id = sk_post.tag_id and sk_post.category_id = sk_category.category_id and sk_category.kanal_id = sk_kanal.kanal_id and sk_post.post_title like '%".$word."%' order by sk_post.post_modify_date desc");
    			$menu['name'] = $this->session->userdata('user_name');
    			$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
    			$this->load->view('front/global/top',$data);
    			$this->load->view('front/global/header',$menu);
    			$this->load->view('front/search/list',$data);
    			$this->load->view('front/global/bottom');
			}
		}
	
		/*function get_data(){
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
		}*/
		
		function get_data(){
			$start = $_POST['start'];
			$limit = $_POST['limit'];
			
			$start1 = $_POST['start1'];
			$limit1 = $_POST['limit1'];
			
			$start2 = $_POST['start2'];
			$limit2 = $_POST['limit2'];
			
			$get_list = $this->db->query("select post_title, post_direct, category_name, post_modify_date, post_thumb, post_url, post_shrt_desc, sk_post.flag_id, profile_back_name_full from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_status='1' and sk_post.post_posted_by = sk_profile_back.user_back_id AND sk_post.flag_id = 'FLG00002' order by post_modify_date desc limit $start, $limit");
			
			$get_list_adventorial = $this->db->query("select post_title, post_direct, post_modify_date, post_thumb, post_url, post_shrt_desc, sk_post.flag_id, flag_name, profile_back_name_full from sk_post, sk_flag_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id AND sk_post.flag_id = 'FLG00001' AND sk_post.flag_id = sk_flag_post.flag_id and sk_post.post_status='1' order by post_modify_date desc limit $start1, $limit1");
		
			$get_list_adv = $this->db->query("select adv_link as post_title, adv_link as post_direct, adv_link as post_modify_date, adv_pict as post_thumb, adv_link as post_url, adv_link as post_shrt_desc, 'adv' as flag_id, adv_link as flag_name, adv_link as profile_back_name_full from sk_adv where position_id='PSB00015' and adv_status='1' order by ObjectID desc limit $start2, $limit2");
										
			$data_list = array();
			
			foreach($get_list->result() as $grid1){
				$data_list[] = $grid1;
			}
			
			foreach($get_list_adventorial->result() as $grid2){
				$data_list[] = $grid2;
			}
			
			foreach($get_list_adv->result() as $grid3){
				$data_list[] = $grid3;
			}
			echo json_encode($data_list);
		}
		
		function get_data_kanal(){
			$start = $_POST['start'];
			$limit = $_POST['limit'];
			
			$kanal = $_POST['kanal'];
			
			$start1 = $_POST['start1'];
			$limit1 = $_POST['limit1'];
			
			$start2 = $_POST['start2'];
			$limit2 = $_POST['limit2'];
			
			$get_list = $this->db->query("select post_title, post_direct, category_name, post_modify_date, post_thumb, post_url, post_shrt_desc, profile_back_name_full from sk_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id and sk_kanal.kanal_name = '".$kanal."' and sk_post.post_status='1' order by post_modify_date desc limit $start, $limit");
			
			$get_list_adventorial = $this->db->query("select post_title, post_direct, post_modify_date, post_thumb, post_url, post_shrt_desc, sk_post.flag_id, flag_name, profile_back_name_full from sk_post, sk_flag_post, sk_profile_back, sk_category, sk_kanal where sk_kanal.kanal_id = sk_category.kanal_id and sk_post.category_id = sk_category.category_id and sk_post.post_posted_by = sk_profile_back.user_back_id AND sk_post.flag_id = 'FLG00001' and sk_post.post_status='1' AND sk_post.flag_id = sk_flag_post.flag_id order by post_modify_date desc limit $start1, $limit1");
		
			$get_list_adv = $this->db->query("select adv_link as post_title, adv_link as post_direct, adv_link as post_modify_date, adv_pict as post_thumb, adv_link as post_url, adv_link as post_shrt_desc, 'adv' as flag_id, adv_link as flag_name, adv_link as profile_back_name_full from sk_adv where position_id='PSB00015' and adv_status='1' order by ObjectID desc limit $start2, $limit2");
			
			
			$data_list = array();
			
			foreach($get_list->result() as $grid1){
				$data_list[] = $grid1;
				
			}
			
			foreach($get_list_adventorial->result() as $grid2){
				$data_list[] = $grid2;
			}
			
			foreach($get_list_adv->result() as $grid3){
				$data_list[] = $grid3;
			}
			echo json_encode($data_list);
		}
	
		function login(){
		    include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
		    include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
		    // Google Project API Credentials
    		$clientId = '669121716175-jlblc6h878vuicdb6gd57s3ubpsup6r1.apps.googleusercontent.com';
            $clientSecret = 'Zn1pmxmsSczZtCc1xMXwzQC_';
            $redirectUrl = base_url() . 'index.php/berita/';
    		
    		// Google Client Configuration
            $gClient = new Google_Client();
            $gClient->setApplicationName('SuaraKaryaNews Login Google Plus');
            $gClient->setClientId($clientId);
            $gClient->setClientSecret($clientSecret);
            $gClient->setRedirectUri($redirectUrl);
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            
            if (isset($_REQUEST['code'])) {
                $gClient->authenticate();
                $this->session->set_userdata('token', $gClient->getAccessToken());
                redirect($redirectUrl);
            }
    
            $token = $this->session->userdata('token');
            if (!empty($token)) {
                $gClient->setAccessToken($token);
            }
			$data['url_pc'] = 'http://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$data['title_main'] = '';
			$data['short_main'] = '';
			$data['posted_main'] = '';
			$data['key_main'] = '';
			$data['img'] = '';
			
			$data['login_url'] = $this->facebook->login_url();;
			$data['google_url'] = $gClient->createAuthUrl();
			$this->load->view('front/global/top',$data);
			$this->load->view('front/login/login',$data);
			$this->load->view('front/global/bottom');
		}
		
		function register(){
    		$data['url_pc'] = 'http://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$data['title_main'] = '';
			$data['short_main'] = '';
			$data['posted_main'] = '';
			$data['key_main'] = '';
			$data['img'] = '';
			$this->load->view('front/global/top',$data);
			$this->load->view('front/dashboard/register',$data);
			$this->load->view('front/global/bottom');
		}
	
		function get_validation_login(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$this->form_validation->set_rules('username','username','trim|required');
				$this->form_validation->set_rules('password','password','trim|required');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$username = $this->input->post("username");
					$password = $this->input->post("password");
					$query_validation = $this->db->query("select * from sk_guest where guest_username = '".$username."' and guest_password = '".$password."' and guest_status=1");
					if($query_validation->num_rows() == 0 ){
						$dataz = array(
							'status' => 'invalid',
						);
						echo json_encode($dataz);
					}else{
						foreach($query_validation->result() as $db){
							$sess['loginsuccess'] = 'success';
							$sess['user_id'] = $db->guest_id;
							$sess['user_profile_id'] = $db->guest_profile_id;
							$sess['user_name'] = $db->guest_name;
							$this->session->set_userdata($sess);
							
							date_default_timezone_set('Asia/Jakarta');
							$data['guest_log_date'] = date("Y-m-d H:i:s");
							$this->sk_model->update_data('sk_guest', 'guest_id', $db->guest_id, $data);
							
						}
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}
				}
			}
		}
		
		function get_logout(){
			$this->session->sess_destroy();
			$cek = $this->session->userdata('login_code_ba');
			if($cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}
		}
		
		function set_update_profile(){
			$cek = $this->session->userdata('loginsuccess');
			if(!$cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$this->form_validation->set_rules('name_profile','nama','trim|required');
				$this->form_validation->set_rules('email_profile','email','trim|required');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$id = $this->session->userdata('user_id');
					$query_profile_check = $this->db->query("select * from sk_guest where guest_id = '".$id."'");
					foreach($query_profile_check->result() as $prf){
						$id_profile = $prf->guest_profile_id;
					}
					$data['guest_profile_name'] = $this->input->post('name_profile');
					$data1['guest_email'] = $this->input->post('email_profile');
					$data['guest_website'] = $this->input->post('website_profile');

					$edit_data1 = $this->sk_model->update_data('sk_guest_profile','guest_profile_id',$id_profile,$data);
					$edit_data2 = $this->sk_model->update_data('sk_guest','guest_id',$id,$data1);
					if($edit_data1 and $edit_data2){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}
			}
		}
		
		function set_update_password(){
			$cek = $this->session->userdata('loginsuccess');
			if(!$cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$this->form_validation->set_rules('change_username','username','trim|required');
				$this->form_validation->set_rules('change_conf','konfirmasi','trim|matches[change_new]');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$id = $this->session->userdata('user_id');
					
					if($this->input->post('change_new') != '' or $this->input->post('change_new') != null){
						$data['guest_password'] = $this->input->post('change_new');
					}else{
						$data['guest_password'] = $this->input->post('change_password');
					}
					
					$data['guest_username'] = $this->input->post('change_username');
					
					$edit_data1 = $this->sk_model->update_data('sk_guest','guest_id',$id,$data);
					if($edit_data1){
						$dataz = array(
							'status' => 'success',
						);
						echo json_encode($dataz);
					}else{
						$dataz = array(
							'status' => 'failed',
						);
						echo json_encode($dataz);
					}
				}
			}
		}
	
		
		function dashboard(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$query_account = $this->db->query("select * from sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_guest.guest_id='".$this->session->userdata('user_id')."'");
				foreach($query_account->result() as $acc){
					//$data[''] = $acc->guest_profile_name;
					$data['name'] = $acc->guest_profile_name;
					$data['gender'] = $acc->guest_profile_gender; 
					$data['email'] = $acc->guest_email;
					$data['website'] = $acc->guest_website;
					$data['pict'] = $acc->guest_profile_pict;
					$data['username'] = $acc->guest_username;
					$data['password'] = $acc->guest_password;
				}
				
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$menu['name'] = $this->session->userdata('user_name');
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['error'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/dashboard/dashboard',$data);
				$this->load->view('front/global/bottom');
			}else{
				Header("Location:".base_url());
			}
		}
		
		function change(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$query_account = $this->db->query("select * from sk_guest, sk_guest_profile where sk_guest.guest_profile_id = sk_guest_profile.guest_profile_id and sk_guest.guest_id='".$this->session->userdata('user_id')."'");
				foreach($query_account->result() as $acc){
					//$data[''] = $acc->guest_profile_name;
					$data['name'] = $acc->guest_profile_name;
					$data['gender'] = $acc->guest_profile_gender; 
					$data['email'] = $acc->guest_email;
					$data['website'] = $acc->guest_website;
					$data['pict'] = $acc->guest_profile_pict;
					$data['username'] = $acc->guest_username;
					$data['password'] = $acc->guest_password;
				}
				$data['title_main'] = '';
				$data['short_main'] = '';
				$data['posted_main'] = '';
				$data['key_main'] = '';
				$data['img'] = '';
				$data['url_pc'] = 'http://suarakaryanews.com/';
				$data['url_mobile'] = $this->url();
				$menu['name'] = $this->session->userdata('user_name');
				
				$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
				
				$data['query_adv'] = $this->db->query("select * from sk_adv, sk_adv_layout where sk_adv.adv_id = sk_adv_layout.adv_id and sk_adv_layout.layout_name = 'home' and sk_adv_layout.kanal_id='home'");
				
				$data['error'] = '';
				
				$this->load->view('front/global/top',$data);
				$this->load->view('front/global/header-logged',$menu);
				$this->load->view('front/dashboard/change',$data);
				$this->load->view('front/global/bottom');
			}else{
				Header("Location:".base_url());
			}
		}
		
		function get_add_account(){
			$cek = $this->session->userdata('loginsuccess');
			if($cek){
				$dataz = array(
					'status' => 'logged',
				);
				echo json_encode($dataz);
			}else{
				$this->form_validation->set_rules('name_reg','nama','trim|required');
				$this->form_validation->set_rules('email_reg','email','trim|required');
				$this->form_validation->set_rules('username_reg','username','trim|required');
				$this->form_validation->set_rules('password_reg','password','trim|required');
				$this->form_validation->set_rules('agree','persyaratan','trim|required');
				$this->form_validation->set_rules('konfirmasi_reg','konfirmasi','trim|required|matches[password_reg]');
				if($this->form_validation->run() == false){
					$dataz = array(
						'status' => 'validation',
					);
					echo json_encode($dataz);
				}else{
					$name = $this->input->post("name_reg");
					$email = $this->input->post("email_reg");
					$username = $this->input->post("username_reg");
					$password = $this->input->post("password_reg");
					$agree = $this->input->post("agree");
					if($agree > 0 or $agree != '' or $agree != null){
						$query_validation = $this->db->query("select * from sk_guest where (guest_username = '".$username."' and guest_password = '".$password."') or guest_email = '".$email."'");
						if($query_validation->num_rows() == 0 ){
							$data['guest_id'] = $this->sk_model->getMaxKodemiddle('sk_guest', 'guest_id', 'GST');
							$data['guest_profile_id'] = $this->sk_model->getMaxKodemiddle('sk_guest', 'guest_profile_id', 'GPF');
							$data['guest_name'] = $name;
							$data['guest_email'] = $email;
							$data['guest_username'] = $username;
							$data['guest_password'] = $password;
							$data['guest_log_date'] = date('Y-m-d H:s:i');
							$data['guest_status'] = 0;
							
							$data_a['guest_id'] = $data['guest_id'];
							$data_a['activate_code'] = md5($data['guest_password']);
							$data_a['url_activate'] = 'http://suarakaryanews.com/index.php/berita/activate/'.$data_a['activate_code'];
							
							$data_b['guest_profile_id'] = $data['guest_profile_id'];
							$data_b['guest_profile_name'] = $data['guest_name'];
							$data_b['guest_profile_email'] = $data['guest_email'];
							
							$query_insert_data = $this->sk_model->insert_data('sk_guest', $data);
							$query_insert_data_activate = $this->sk_model->insert_data('sk_activate', $data_a);
							$query_insert_data_profile = $this->sk_model->insert_data('sk_guest_profile', $data_b);
							if($query_insert_data and $query_insert_data_activate and $query_insert_data_profile){
								$username = 'no.reply.suarakaryanews';
								$sender_email = 'no.reply.suarakaryanews@gmail.com';
								$user_password = 'su4r4k4ry4news';
								$subject = 'Activation Account (SuarakaryaNews.com)';
								$name = $data['guest_name'];
								$url_activate = $data_a['url_activate'];
								$message = '	<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
														<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
															<tbody>
																<tr style="background-image:url(http://suarakaryanews.com/assets/background.jpg);background-size:cover;">
																	<td style="width:100%;padding:0px;" colspan="2">
																		<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																			<tr>
																				<td><span style="color:#fff;font-family:arial;font-size:12px;margin:0px;margin-left:20px;font-weight:normal;">&nbsp;</span></td>
																				<td style="text-align:right"><h1 style="color:#fff;font-family:Andalus,Arial;font-size:32px;margin:0px;margin-right:20px;font-weight:normal;">#ActivationAccount</h1>
																				<span style="text-align:right;color:#fff;margin-right:20px;font-size:12px;">SuarakaryaNews.com menghadirkan berita-berita teraktual dan terpercaya</span></td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td style="width:100%;font-family:calibri;padding:10px;border-bottom:1px solid #f9f9f9;border-top:1px solid #f9f9f9;padding-bottom:30px;padding-top:30px;" colspan="2" align="center">
																		<table style="width:80%;">
																			<tr>
																				<td>
																					<div style="margin-left:10px;color:#999;text-align:center;">
																						<h2>#ActivationAccount</h2>
																						<p>Hallo Mr/Mrs.'.$name.', Silahkan klik link di bawah ini untuk activasi account anda pada SuarakaryaNews.com</p>
																						<p style="margin-top:5px;">'.$url_activate.'</p>
																					</div>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
																<tr>
																	<td style="width:100%;font-family:arial;padding:20px;text-align:center;" colspan="2">
																		<span style="color:#999;font-size:12px;">Email ini dibuat secara otomatis, mohon untuk tidak mengirimkan pesan balasan ke email ini.</span>
																	</td>
																</tr>
																<tr style="border-collapse:collapse;background:#f9f9f9;margin:0;padding:0;">
																	<td style="width:100%;">
																		<table style="width:50%;margin:0 auto;">
																			<tr style="text-align:center;">
																				<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
																					<div style="text-align:center;">
																						<img src="http://suarakaryanews.com/assets/img/logo.png" style="padding-left:10px;padding-top:10px;padding-bottom:10px;" width="100"/>
																					</div>
																					<div style="margin-top:-2px;text-align:center;">
																						<span style="color:#999;font-size:11px;">2016 &copy; SuarakaryaNews.com</span>
																					</div>
																				</td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</tbody>
															</table>
														</div>';
								
								// Configure email library
								$config['protocol'] = 'smtp';
								$config['smtp_host'] = 'ssl://smtp.googlemail.com';
								$config['smtp_port'] = 465;
								$config['smtp_user'] = $sender_email;
								$config['smtp_pass'] = $user_password;
								$config['mailtype'] = 'html';
								$config['charset'] = 'iso-8859-1';
								
								
								// Load email library and passing configured values to email library
								$this->load->library('email', $config);
								$this->email->set_newline("\r\n");
				
								// Sender email address
								$this->email->from($sender_email, $username);
								// Receiver email address
								$this->email->to($data['guest_email']);
								$this->email->cc('evan.abeiza@gmail.com');
								// Subject of email
								$this->email->subject($subject);
								// Message in email
								$this->email->message($message);
								// Action Sending Mesage
								$send_user = $this->email->send();
											
								if($send_user == true){
									$dataz = array(
										'status' => 'success',
									);
									echo json_encode($dataz);
								}
							}else{
								$dataz = array(
									'status' => 'failed',
								);
								echo json_encode($dataz);
							}
						}else{
							$dataz = array(
								'status' => 'available',
							);
							echo json_encode($dataz);
						}
					}else{
						$dataz = array(
							'status' => 'validation',
						);
						echo json_encode($dataz);
					}
				}
			}
		}
	
		
		function get_forget_account(){
			$this->form_validation->set_rules('email_forget','email','trim|required');
			if($this->form_validation->run() == false){
				$dataz = array(
					'status' => 'validation',
				);
				echo json_encode($dataz);
			}else{
				$email_forget = $this->input->post('email_forget');
				
				$query_forget_check = $this->db->query("select * from sk_guest where guest_email = '".$email_forget."' and guest_status = 1");
				if($query_forget_check->num_rows() == 0){
					$dataz = array(
						'status' => 'invalid',
					);
					echo json_encode($dataz);
				}else{
					foreach($query_forget_check->result() as $fgt){
						$id = $fgt->guest_id;
						$data['guest_username'] = $fgt->guest_id;
						$data['guest_password'] = $fgt->guest_id;
						
						$update_forget = $this->sk_model->update_data('sk_guest', 'guest_id', $id, $data);
						if($update_forget){
							$username = 'no.reply.suarakaryanews';
							$sender_email = 'no.reply.suarakaryanews@gmail.com';
							$user_password = 'su4r4k4ry4news';
							$subject = 'Forget Account (SuarakaryaNews.com)';
							$message = '	<div style="background-color:#f9f9f9;font-family:Helvetica,Arial,sans-serif;">
													<table style="margin:1% 5%;background-color:#fff;border-collapse:collapse;width:90%;border:none;">
														<tbody>
															<tr style="background-image:url(http://suarakaryanews.com/assets/background.jpg);background-size:cover;">
																<td style="width:100%;padding:0px;" colspan="2">
																	<table style="width:100%;height:300px;background-color:#000;opacity:0.5">
																		<tr>
																			<td><span style="color:#fff;font-family:arial;font-size:12px;margin:0px;margin-left:20px;font-weight:normal;">&nbsp;</span></td>
																			<td style="text-align:right"><h1 style="color:#fff;font-family:Andalus,Arial;font-size:32px;margin:0px;margin-right:20px;font-weight:normal;">#ForgetAccount</h1>
																			<span style="text-align:right;color:#fff;margin-right:20px;font-size:12px;">SuarakaryaNews.com menghadirkan berita-berita teraktual dan terpercaya</span></td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="width:100%;font-family:calibri;padding:10px;border-bottom:1px solid #f9f9f9;border-top:1px solid #f9f9f9;padding-bottom:30px;padding-top:30px;" colspan="2" align="center">
																	<table style="width:80%;">
																		<tr>
																			<td>
																				<div style="margin-left:10px;color:#999;text-align:center;">
																					<h2>#ForgetAccount</h2>
																					<p>Hallo Mr/Mrs.'.$fgt->guest_name.', Berikut data akun anda yang baru. Mohon untuk mereset username dan password anda jika anda telah login dengan data di bawah ini.</p>
																					<p style="margin-top:5px;">Username : '.$data['guest_username'].'</p>
																					<p style="margin-top:5px;">Password : '.$data['guest_password'].'</p>
																				</div>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="width:100%;font-family:arial;padding:20px;text-align:center;" colspan="2">
																	<span style="color:#999;font-size:12px;">Email ini dibuat secara otomatis, mohon untuk tidak mengirimkan pesan balasan ke email ini.</span>
																</td>
															</tr>
															<tr style="border-collapse:collapse;background:#f9f9f9;margin:0;padding:0;">
																<td style="width:100%;">
																	<table style="width:50%;margin:0 auto;">
																		<tr style="text-align:center;">
																			<td style="width:95%;font-family:arial;padding-top:0px;padding-bottom:10px;padding-right:10px;border-collapse:collapse;text-align:justify">
																				<div style="text-align:center;">
																					<img src="http://suarakaryanews.com/assets/img/logo.png" style="padding-left:10px;padding-top:10px;padding-bottom:10px;" width="100"/>
																				</div>
																				<div style="margin-top:-2px;text-align:center;">
																					<span style="color:#999;font-size:11px;">2016 &copy; SuarakaryaNews.com</span>
																				</div>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</tbody>
														</table>
													</div>';
							
							// Configure email library
							$config['protocol'] = 'smtp';
							$config['smtp_host'] = 'ssl://smtp.googlemail.com';
							$config['smtp_port'] = 465;
							$config['smtp_user'] = $sender_email;
							$config['smtp_pass'] = $user_password;
							$config['mailtype'] = 'html';
							$config['charset'] = 'iso-8859-1';
							
							
							// Load email library and passing configured values to email library
							$this->load->library('email', $config);
							$this->email->set_newline("\r\n");
			
							// Sender email address
							$this->email->from($sender_email, $username);
							// Receiver email address
							$this->email->to($email_forget);
							$this->email->cc('evan.abeiza@gmail.com');
							// Subject of email
							$this->email->subject($subject);
							// Message in email
							$this->email->message($message);
							// Action Sending Mesage
							$send_user = $this->email->send();
							
							$dataz = array(
								'status' => 'success',
							);
							echo json_encode($dataz);
						}else{
							$dataz = array(
								'status' => 'failed',
							);
							echo json_encode($dataz);
						}
					}
				}
			}
		}
	
		function forget(){
			$data['url_pc'] = 'http://suarakaryanews.com/';
			$data['url_mobile'] = $this->url();
			$menu['get_menu'] = $this->db->query("select menu_header, menu_label, menu_url from sk_menu where menu_index='0' and menu_order='0' order by menu_header");
			$data['title_main'] = '';
			$data['short_main'] = '';
			$data['posted_main'] = '';
			$data['key_main'] = '';
			$data['img'] = '';
			$this->load->view('front/global/top',$data);
			$this->load->view('front/register/forget',$data);
			$this->load->view('front/global/bottom');
		}
	}
	
/*End of file berita.php*/
/*Location:.application/controllers/berita.php*/