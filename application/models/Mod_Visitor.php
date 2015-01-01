<?php
class Mod_Visitor extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function cek_visitor($id){
        $this->db->select("*");
        $this->db->from("visitor");
        $this->db->where("id",$id);
        $hasil = $this->db->get();
        return array($hasil->num_rows(),$hasil->result());
    }
    
    public function insert_visitor($data){
        $hasil = $this->db->insert("visitor",$data);
        return $hasil;
    }
    
    public function update_visitor($id, $data){
        $this->db->where('id', $id);
        $this->db->update('visitor', $data);
    }

     public function ambil_semua_visitor(){
        $hasil = $this->db->get("visitor");
        return array($hasil->num_rows(),$hasil->result());
    }
}
