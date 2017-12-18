<?php
class Insentif_model_kcc_internal extends CI_Model{
    
    function get_kcc_internal()
    {
        $CI = &get_instance();
        $this->db2 = $CI->load->database('login',TRUE);
        $query = $this->db2->query("SELECT 
            username, first_name, last_name
        FROM
            insentif_login
        WHERE 
            authority = 3
        "
        );
        return $query->result_array();        
    }

    function get_kcc_internal_name($kcc_internal)
    {
        $query = $this->db->query("SELECT 
                concat(first_name, ' ', last_name) as name
            FROM
                ipay.ipay_distributor
            WHERE
                distributor_id = '".$kcc_internal."'
            "
        );
        return $query->result_array();        
    }

    function get_cvs($kcc_internal){
        $query = $this->db->query("SELECT 
                beatguy_id, first_name, last_name, status
            FROM
                ipay_beatguy
            WHERE
                distributor_id = '".$kcc_internal."'
            ORDER BY status DESC
            "
        );
        $q_result= $query->result_array();
        // print_r($q_result);
        return $q_result;
    }

    // untuk set target SPV (sebagai pengali)
    function get_cvs_active($kcc_internal){$query = $this->db->query("SELECT 
            count(beatguy_id) as jumlah_aktif
        FROM
            ipay.ipay_beatguy
        WHERE
            distributor_id = '".$kcc_internal."'
            and status = 1 
            "
        );
        $q_result= $query->result_array();
        // print_r($q_result);
        return $q_result;
    }

    
    //  ##################### USR #########################
    function get_cvs_usr_achieve($bulan, $tahun, $kcc_internal){
        $query = $this->db->query("SELECT 
                c.beatguy_id, d.usr
            FROM
                ipay_beatguy c
                    LEFT JOIN
                (SELECT 
                    a.beatguyid, COUNT(a.retailerid) AS usr
                FROM
                    ipay_retailer_daily_payments a
                INNER JOIN (SELECT 
                    retailerid, SUM(amount) AS topup
                FROM
                    ipay_retailer_daily_payments
                WHERE
                    dateofpayment BETWEEN '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59'
                        AND distributorid = '".$kcc_internal."'
                GROUP BY retailerid
                HAVING topup >= 1000000) b ON a.retailerid = b.retailerid
                WHERE
                    a.dateofpayment BETWEEN '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59'
                        AND a.distributorid = '".$kcc_internal."'
                GROUP BY a.beatguyid) d ON d.beatguyid = c.beatguy_id
            WHERE
                c.distributor_id = '".$kcc_internal."'
            ORDER BY status DESC
            "
        );
        $q_result= $query->result_array();
        // print_r($q_result);
        return $q_result;
    }

    function get_cvs_usr_minus($bulan, $tahun, $kcc_internal){
        $query = $this->db->query("SELECT 
            c.beatguy_id, d.usr_minus
        FROM
            ipay_beatguy c
                LEFT JOIN
            (SELECT 
                a.beatguy_id, COUNT(a.retailer_id) AS usr_minus
            FROM
                ipay_retailer a
            INNER JOIN (SELECT 
                b.retailer_id, b.retailer_credit_limit
            FROM
                ipay_retailer_credit_details b
            WHERE
                retailer_credit_limit < 0
                    AND b.distributor_id = '".$kcc_internal."') b ON a.retailer_id = b.retailer_id
            WHERE
                a.distributer_id = '".$kcc_internal."'
            GROUP BY a.beatguy_id) d ON c.beatguy_id = d.beatguy_id
        WHERE
            c.distributor_id = '".$kcc_internal."' 
            "
        );
        $q_result= $query->result_array();
        // print_r($q_result);
        return $q_result;
    }
    //  ##################### DNL #########################
    // transaksi tipe LP saja
    function get_cvs_dnl($bulan, $tahun, $kcc_internal){
        $query = $this->db->query("SELECT 
            c.beatguy_id, d.dnl
        FROM
            ipay_beatguy c
                LEFT JOIN
            (SELECT 
                b.beatguy_id, COUNT(a.KCP_ID) AS dnl
            FROM
                ipex.IPEX_LOAN_PAYMENT_DETAILS a
            INNER JOIN (SELECT 
                retailer_id, beatguy_id
            FROM
                ipay.ipay_retailer
            WHERE
                distributer_id = '".$kcc_internal."') b ON a.KCP_ID = b.retailer_id
            WHERE
                PRODUCT_NAME = 'Saldo Kioson'
                    AND a.amount >= 1000000
                    AND status = 'success'
                    AND TRANSACTION_DATE_ONLY BETWEEN '01-".$bulan."-".$tahun."' AND '31-".$bulan."-".$tahun."'
            GROUP BY b.beatguy_id) d ON c.beatguy_id = d.beatguy_id
        WHERE
            distributor_id = '".$kcc_internal."'
        ORDER BY status DESC
            "
        );
        return $query->result_array();
    }
    //  ##################### TOP UP #########################
    function get_cvs_tu_raw($bulan, $tahun, $kcc_internal){
        $query = $this->db->query("SELECT 
            c.beatguy_id, d.topup
        FROM
            ipay_beatguy c
                LEFT JOIN
            (SELECT 
                a.beatguyid, SUM(a.amount) AS topup
            FROM
                ipay_retailer_daily_payments a
            WHERE
                a.dateofpayment BETWEEN '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59'
                    AND a.distributorid = '".$kcc_internal."'
            GROUP BY a.beatguyid) d ON d.beatguyid = c.beatguy_id
        WHERE
            c.distributor_id = '".$kcc_internal."'
        ORDER BY status DESC
            "
        );
        $q_result= $query->result_array();
        // print_r($q_result);
        return $q_result;
    }

    function get_cvs_tu_negative_balance($bulan, $tahun, $kcc_internal){$query = $this->db->query("SELECT 
            c.beatguy_id, d.tu_negative_balance
        FROM
            ipay_beatguy c
                LEFT JOIN
            (SELECT 
                a.beatguy_id,
                    SUM(b.retailer_credit_limit) AS tu_negative_balance
            FROM
                ipay_retailer a
            INNER JOIN (SELECT 
                b.retailer_id, b.retailer_credit_limit
            FROM
                ipay_retailer_credit_details b
            WHERE
                retailer_credit_limit < 0
                    AND b.distributor_id = '".$kcc_internal."') b ON a.retailer_id = b.retailer_id
            WHERE
                a.distributer_id = '".$kcc_internal."' 
            GROUP BY a.beatguy_id) d ON c.beatguy_id = d.beatguy_id
        WHERE
            c.distributor_id = '".$kcc_internal."' 
            "
        );
        return $query->result_array();
    }

    //  ##################### TRANSACTIONS #########################
    // semua transaksi, termasuk MT
    function get_cvs_trx_all($bulan, $tahun, $kcc_internal){
        $query = $this->db->query("SELECT 
            b.beatguy_id, SUM(a.amount) AS trx_all
        FROM
            ipay_transactions a
                INNER JOIN
            (SELECT 
                beatguy_id, retailer_id
            FROM
                ipay_retailer
            WHERE
                distributer_id = '".$kcc_internal."') b ON a.retailer_id = b.retailer_id
        WHERE
            a.transaction_date_only BETWEEN '".$tahun."-".$bulan."-01' AND '".$tahun."-".$bulan."-31'
                AND a.distributer_id = '".$kcc_internal."'
                AND a.cancelled_reference_id IS NULL
                AND a.payment_status = 'received'
                AND a.order_status = 'success'
        GROUP BY b.beatguy_id
            "
        );
        return $query->result_array();
    }

    // transaksi tipe MT saja
    function get_cvs_trx_mt($bulan, $tahun, $kcc_internal){
        $query = $this->db->query("SELECT 
            b.beatguy_id, SUM(a.amount) AS trx_money_transfer
        FROM
            ipay_transactions a
                INNER JOIN
            (SELECT 
                beatguy_id, retailer_id
            FROM
                ipay_retailer
            WHERE
                distributer_id = '".$kcc_internal."') b ON a.retailer_id = b.retailer_id
        WHERE
            a.transaction_date_only BETWEEN '".$tahun."-".$bulan."-01' AND '".$tahun."-".$bulan."-31'
                AND a.distributer_id = '".$kcc_internal."'
                AND a.cancelled_reference_id IS NULL
                AND a.payment_status = 'received'
                AND a.order_status = 'success'
                AND a.transaction_type = 'MT'
        GROUP BY b.beatguy_id
            "
        );
        return $query->result_array();
    }
    //  ##################### USPR #########################

    function get_cvs_uspr($bulan, $tahun, $kcc_internal){

        
        $query = $this->db->query("SELECT 
            f.beatguy_id, e.uspr_actual
        FROM
            ipay.ipay_beatguy f
                LEFT JOIN
            (SELECT 
                d.beatguy_id, COUNT(c.retailer_id) AS uspr_actual
            FROM
                ipex.IPEX_ECOMMERCE_SERV_TRANS_DETAILS a
            INNER JOIN ipex.IPEX_ECOMMERCE_PRODUCTS b ON a.product_id = b.product_id
            INNER JOIN ipay.ipay_transactions c ON c.ipay_vendor_ref_id = a.ipex_order_id
            INNER JOIN ipay.ipay_retailer d ON c.retailer_id = d.retailer_id
            WHERE
                (b.product_name LIKE 'samsung%'
                    OR b.product_name LIKE 'galaxy%')
                    AND b.product_name NOT LIKE '%headset%'
                    AND b.product_name NOT LIKE '%micro sd%'
                    AND b.product_name NOT LIKE '%otg%'
                    AND b.product_name NOT LIKE '%tab%'
                    AND b.product_name NOT LIKE '%ac%pk%'
                    AND b.product_name NOT LIKE '%tv%'
                    AND b.product_name NOT LIKE '%headset%'
                    AND c.transaction_type = 'EP'
                    AND c.transaction_date_only BETWEEN '".$tahun."-".$bulan."-01' AND '".$tahun."-".$bulan."-31'
                    AND c.cancelled_reference_id IS NULL
                    AND c.payment_status = 'received'
                    AND c.order_status = 'success'
                    AND d.distributer_id = '".$kcc_internal."'
            GROUP BY d.beatguy_id) e ON f.beatguy_id = e.beatguy_id
        WHERE
            f.distributor_id = '".$kcc_internal."' 
            "
        );
        return $query->result_array();
    }
}