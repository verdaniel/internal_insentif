<?php
class Insentif_model_super_kcc extends CI_model{

    function get_kcc_under_super_kcc($super_kcc_id)
    {
        $CI=&get_instance();
        $this->db2=$CI->load->database('login', TRUE);
        $query = $this->db2->query("SELECT 
            distributor_id
        FROM
            super_kcc_relations
        WHERE super_kcc_id = '".$super_kcc_id."'
        "
        );
        $q_result= $query->result_array();
        
        $jumlah_KCC_bawahan= count($q_result);

        $result=[];
        array_push($result,$q_result,$jumlah_KCC_bawahan);
        return $result;
    }

    function get_super_kcc_name($super_kcc_id)
    {   
        $CI=&get_instance();
        $this->db2=$CI->load->database('login', TRUE);
        $query = $this->db2->query("SELECT 
            username, first_name, last_name
        FROM
            insentif_login
        WHERE username= '".$super_kcc_id."'
        "
        );
        return $query->result_array();
    }
}