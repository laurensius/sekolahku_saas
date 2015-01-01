<?php
class Mod_User extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function verifikasi($u,$p){
        $query = $this->db->query("select * from user where username='$u'");
        $data = array();
        if($query->num_rows()==1){
            foreach ($query->result() as $row){
                if($row->password === $p){
                    $data["message"] = "OK";
                }else{
                    $data["message"] = "NOT MATCH";
                }
            }        
        }else
        if($query->num_rows()==0){
            $data["message"] = "NOT OK";
        }
        return $data;
    }
}
