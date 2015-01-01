<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mod_user');
        $this->load->model('mod_sekolah');
        $this->load->model('mod_visitor');
        $this->load->library('user_agent');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 23 Jul 2013 05:00:00 GMT");
    }
    
    public function index(){
        if($this->session->userdata("s_a_username") && $this->session->userdata("s_a_password")){
            redirect(site_url().'/user/dashboard');
        }else{
            $content["message"] = "Silahkan Anda Login!";
            $content["isi_body"] = "";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }
    }

    public function verifikasi(){        
        $u = mysql_real_escape_string($this->input->post('username'));
        $p = mysql_real_escape_string($this->input->post('password'));
        $hasil = $this->mod_user->verifikasi($u,$p);
        if($hasil["message"]==="OK"){
            $this->buat_session($u,$p);
            redirect(site_url().'/user/dashboard', 'refresh');
        }else
        if($hasil["message"]==="NOT OK"){
            $content["message"] = "Whoopss! Username tidak terdaftar!";
            $content["isi_body"] = "";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }else
        if($hasil["message"]==="NOT MATCH"){
            $content["message"] = "Whoopss! Username dan Password tidak cocok!";
            $content["isi_body"] = "";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }
    }    
    
    public function buat_session($u,$p){
        $data_session = array(
            "s_a_username"=>$u,
            "s_a_password"=>$p
        );
        $this->session->set_userdata($data_session);
    }

    public function dashboard(){
        if($this->session->userdata("s_a_username") && $this->session->userdata("s_a_password")){  
            $content["message"] = "";
            $content["u"] = $this->session->userdata("s_a_username");
            $content["p"] = $this->session->userdata("s_a_password");
            $content["data"] = $this->mod_sekolah->sekolah_order_by_kecamatan();
            $content["child"] = $this->load->view('user/2_body_reg_1_dashboard',$content,true);
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_reg',$content);
            $this->load->view('user/3_footer');
        }else{
            $content["message"] = "Silahkan login!";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }   
    }
    
    public function kelola(){
        if($this->session->userdata("s_a_username") && $this->session->userdata("s_a_password")){  
            $content["message"] = "";
            $content["u"] = $this->session->userdata("s_a_username");
            $content["p"] = $this->session->userdata("s_a_password");
            if($this->uri->segment(3)=="lihat_data"){
                $content["data"] = $this->mod_sekolah->ambil_semua_sekolah();
                $content["child"] = $this->load->view('user/2_body_reg_2_1_lihat_data',$content,true);
            }else
            if($this->uri->segment(3)=="tambah_data"){
                if($this->uri->segment(4) != null || $this->uri->segment(4) != ""){
                    $content["message"] = "Tambah data gagal";
                }   
                $content["child"] = $this->load->view('user/2_body_reg_2_2_tambah_data','',true);
            }else
            if($this->uri->segment(3)=="ubah_data"){
                $content["data"] = $this->mod_sekolah->ambil_sekolah($this->uri->segment(4));
                $content["child"] = $this->load->view('user/2_body_reg_2_3_ubah_data',$content,true);
            }else
            if($this->uri->segment(3)=="detail_data"){
                $content["data"] = $this->mod_sekolah->ambil_sekolah($this->uri->segment(4));
                $content["child"] = $this->load->view('user/2_body_reg_2_1_1_detail_data',$content,true);
            }else
            if($this->uri->segment(3)=="delete_data"){
                $this->mod_sekolah->delete_sekolah($this->uri->segment(4));
                redirect(site_url().'/user/kelola/lihat_data', 'refresh');
            }
            else{
                $content["data"] = $this->mod_sekolah->ambil_semua_sekolah();
                $content["child"] = $this->load->view('user/2_body_reg_2_1_lihat_data',$content,true);
            }
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_reg',$content);
            $this->load->view('user/3_footer');
        }else{
            $content["message"] = "Silahkan login!";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }
    }
    
    public function tambah_data(){
        if($this->session->userdata("s_a_username") && $this->session->userdata("s_a_password")){  
            if (empty($_FILES['foto']['name'])==true) {
                $nama_foto = "default.png";
            }else{
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']	= '2048';
                $config['overwrite'] = 'true';
                $config['encrypt_name'] = 'true';  
                $config['remove_spaces'] = 'true';  
                $config['file_name'] = mysql_real_escape_string($this->input->post("nama_sekolah"));  
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('foto')){ 
                    echo $this->upload->display_errors();
                }else{ 
                    $detail = $this->upload->data();
                    $nama_foto = $detail["orig_name"];
                }
            }
            
            $data = array(
                "id" => "",
                "nama_sekolah" => mysql_real_escape_string($this->input->post("nama_sekolah")), 
                "akreditasi" => mysql_real_escape_string($this->input->post("akreditasi")), 
                "foto" => $nama_foto, 
                "url" => mysql_real_escape_string($this->input->post("url")), 
                "email" => mysql_real_escape_string($this->input->post("email")), 
                "kelurahan" => mysql_real_escape_string($this->input->post("kelurahan")), 
                "kecamatan" => mysql_real_escape_string($this->input->post("kecamatan")), 
                "alamat" => mysql_real_escape_string($this->input->post("alamat")), 
                "keterangan" => mysql_real_escape_string($this->input->post("keterangan")), 
                "longitude" => mysql_real_escape_string($this->input->post("longitude")), 
                "latitude" => mysql_real_escape_string($this->input->post("latitude")));

            $before = $this->db->count_all_results('sekolah');
            $this->mod_sekolah->tambah_sekolah($data);
            $after = $this->db->count_all_results('sekolah');

            if($before==$after){
                $content["message"] = "Insert data gagal";
                redirect(site_url()."/user/kelola/tambah_data/gagal");
            }else
            if($before<$after){
                $content["message"] = "Insert data sukses";
                redirect(site_url()."/user/kelola/lihat_data/sukses");
            }
        }else{
            $content["message"] = "Silahkan login!";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }
    }

    public function update_data(){
        if($this->session->userdata("s_a_username") && $this->session->userdata("s_a_password") && $this->uri->segment(3)!= "" ){  
            $data = array();
            if (empty($_FILES['foto']['name'])==true) {
                $data = array(
                    "nama_sekolah" => mysql_real_escape_string($this->input->post("nama_sekolah")), 
                    "akreditasi" => mysql_real_escape_string($this->input->post("akreditasi")), 
                    "url" => mysql_real_escape_string($this->input->post("url")), 
                    "email" => mysql_real_escape_string($this->input->post("email")), 
                    "kelurahan" => mysql_real_escape_string($this->input->post("kelurahan")), 
                    "kecamatan" => mysql_real_escape_string($this->input->post("kecamatan")), 
                    "alamat" => mysql_real_escape_string($this->input->post("alamat")), 
                    "keterangan" => mysql_real_escape_string($this->input->post("keterangan")), 
                    "longitude" => mysql_real_escape_string($this->input->post("longitude")), 
                    "latitude" => mysql_real_escape_string($this->input->post("latitude")));
            }else{
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']	= '2048';
                $config['overwrite'] = 'true';
                $config['encrypt_name'] = 'true';  
                $config['remove_spaces'] = 'true';  
                $config['file_name'] = mysql_real_escape_string($this->input->post("nama_sekolah"));  
                $this->load->library('upload', $config);
                if(!$this->upload->do_upload('foto')){ 
                    echo $this->upload->display_errors();
                }else{ 
                    $detail = $this->upload->data();
                    $nama_foto = $detail["orig_name"];
                    $data = array(
                        "nama_sekolah" => mysql_real_escape_string($this->input->post("nama_sekolah")), 
                        "akreditasi" => mysql_real_escape_string($this->input->post("akreditasi")), 
                        "foto" => $nama_foto, 
                        "url" => mysql_real_escape_string($this->input->post("url")), 
                        "email" => mysql_real_escape_string($this->input->post("email")), 
                        "kelurahan" => mysql_real_escape_string($this->input->post("kelurahan")), 
                        "kecamatan" => mysql_real_escape_string($this->input->post("kecamatan")), 
                        "alamat" => mysql_real_escape_string($this->input->post("alamat")), 
                        "keterangan" => mysql_real_escape_string($this->input->post("keterangan")), 
                        "longitude" => mysql_real_escape_string($this->input->post("longitude")), 
                        "latitude" => mysql_real_escape_string($this->input->post("latitude")));
                }
            }
            echo $this->mod_sekolah->update_sekolah($this->uri->segment(3),$data);
            $content["message"] = "Update data sukses";
            redirect(site_url()."/user/kelola/lihat_data/");
        }else{
            $content["message"] = "Silahkan login!";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }
    }
    
    public function logout(){
        if($this->session->userdata("s_a_username") && $this->session->userdata("s_a_password")){  
            $this->session->sess_destroy();
            $content["message"] = "Anda baru saja keluar dari sistem!";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }else{
            $content["message"] = "Silahkan login!";
            $this->load->view('user/1_header');
            $this->load->view('user/2_body_unreg', $content);
            $this->load->view('user/3_footer');
        }
    }
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */