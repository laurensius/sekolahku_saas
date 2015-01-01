<?php
class Mod_Sekolah extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function tambah_sekolah($data){
        $hasil = $this->db->insert("sekolah",$data);
        return $hasil;
    }
    
    public function ambil_semua_sekolah(){
        $hasil = $this->db->get("sekolah");
        return $hasil->result();
    }
    
    public function ambil_sekolah($id){
        $this->db->select("*");
        $this->db->from("sekolah");
        $this->db->where("id",$id);
        $hasil = $this->db->get();
        return $hasil->result();
    }
    
    public function update_sekolah($id,$data){
        $this->db->where('id', $id);
        $this->db->update('sekolah', $data);
        //$this->db->set();
        //echo "id->" . $id;
        //echo $this->db->affected_rows();
    }
    
    public function hasil_cari_nama($nama_sekolah){
        $this->db->select("*");
        $this->db->from("sekolah");
        $this->db->like("nama_sekolah","$nama_sekolah");
        $hasil = $this->db->get();
        return $hasil->result();
    }
    
    
    public function sekolah_order_by_kecamatan(){
        $hasil = $this->db->query('select * from sekolah order by kecamatan');
        return array($hasil->num_rows(), $hasil->result());
    }
    
    public function delete_sekolah($id){
        $tables = array('sekolah', 'visitor');
        $this->db->where('id', $id);
        $this->db->delete($tables);
    }
    
}
