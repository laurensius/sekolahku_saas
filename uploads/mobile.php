<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mobile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mod_user');
        $this->load->model('mod_sekolah');
        $this->load->model('mod_visitor');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 23 Jul 2013 05:00:00 GMT");

    }
    
    public function index(){
        $this->load->view('mobile/current');
    }
    
    public function current(){
//        $lat = $this->uri->segment(3);
//        $lng = $this->uri->segment(4);
        $content["data"] = $this->mod_sekolah->ambil_semua_sekolah();
        $this->load->view('mobile/current',$content);
    }
    
    public function other(){
        $this->load->view('mobile/other');
    }
    
    public function hasilother(){
        $content["data"] = $this->mod_sekolah->ambil_semua_sekolah();
        $this->load->view('mobile/hasilother',$content);
    }
    
    public function detail(){
//        $lat = $this->uri->segment(3);
//        $lng = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $content["data"] = $this->mod_sekolah->ambil_sekolah($id);
        $this->load->view('mobile/detail',$content);
        
        $cek_visitor = $this->mod_visitor->cek_visitor($id);
        if($cek_visitor[0]>0){
            $jumlah = 0;
            foreach($cek_visitor[1] as $rw){
                $jumlah = $rw->jumlah;
            }
            $jumlah++;
            $data = array("jumlah"=>$jumlah);
            $this->mod_visitor->update_visitor($id,$data);
        }else{
            $data = array("id" => $this->uri->segment(5),
                          "jumlah" => 1);
            $this->mod_visitor->insert_visitor($data);
        }
    }
    
    public function detailother(){
//        $lat = $this->uri->segment(3);
//        $lng = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $content["data"] = $this->mod_sekolah->ambil_sekolah($id);
        $this->load->view('mobile/detailother',$content);
        
        $cek_visitor = $this->mod_visitor->cek_visitor($id);
        if($cek_visitor[0]>0){
            $jumlah = 0;
            foreach($cek_visitor[1] as $rw){
                $jumlah = $rw->jumlah;
            }
            $jumlah++;
            $data = array("jumlah"=>$jumlah);
            $this->mod_visitor->update_visitor($id,$data);
        }else{
            $data = array("id" => $this->uri->segment(5),
                          "jumlah" => 1);
            $this->mod_visitor->insert_visitor($data);
        }
    }
    
    public function hasilcarinama(){
//        $lat = $this->uri->segment(3);
//        $lng = $this->uri->segment(4);
        $nama_sekolah = str_ireplace("%20"," ", $this->uri->segment(5));
        $content["data"] = $this->mod_sekolah->hasil_cari_nama($nama_sekolah);
        $this->load->view('mobile/hasilcarinama',$content);
    }
    
    public function detailhasilcarinama(){
//        $lat = $this->uri->segment(3);
//        $lng = $this->uri->segment(4);
        $id = $this->uri->segment(5);
        $content["data"] = $this->mod_sekolah->ambil_sekolah($id);
        $this->load->view('mobile/detailhasilcarinama',$content);
        
        $cek_visitor = $this->mod_visitor->cek_visitor($id);
        if($cek_visitor[0]>0){
            $jumlah = 0;
            foreach($cek_visitor[1] as $rw){
                $jumlah = $rw->jumlah;
            }
            $jumlah++;
            $data = array("jumlah"=>$jumlah);
            $this->mod_visitor->update_visitor($id,$data);
        }else{
            $data = array("id" => $this->uri->segment(5),
                          "jumlah" => 1);
            $this->mod_visitor->insert_visitor($data);
        }
    }

}

/* End of file user.php */
/* Location: ./application/controllers/mobile.php */