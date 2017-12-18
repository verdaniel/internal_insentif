<?php
class Insentif_model_kcc_external extends CI_Model{
    
    // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% retailer %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    function get_distributor()
    {
        $query = $this->db->query("SELECT 
            distributor_id, first_name, last_name
        FROM
            ipay_distributor
        WHERE
            status = '1' 
                AND distributor_id != 'N/A'
                AND distributor_id != 'D1Q'
                AND distributor_id != 'D0J'
                AND distributor_id != 'D0U'
                AND distributor_id != 'D1F'
                AND distributor_id != 'D1S'
                AND distributor_id != 'D1T'
                AND distributor_id != 'D0R'
                AND distributor_id != 'D0Y'
                AND distributor_id != 'D0D'
                AND distributor_id != 'D0G'
                AND distributor_id != 'D1X'
                AND distributor_id != 'D0C'
                AND distributor_id != 'D0E'
                AND distributor_id != 'D0N'
                AND distributor_id != 'D1R'
                AND distributor_id != 'D0T'
                AND distributor_id != 'D0I'
                AND distributor_id != 'D1G'
                AND distributor_id != 'D0F'
                AND distributor_id != 'D0H'
                AND distributor_id != 'D1R'
                AND distributor_id != 'D0L'
                AND distributor_id != 'D0V'
                AND distributor_id != 'D0A'
                AND distributor_id != 'D0B'
                "
        );
        // $result= $query->result_array();
        // print_r($result);
        return $query->result_array();
    }
    function get_distributor_name($dist_id)
    {
        $query = $this->db->query("SELECT 
            first_name, last_name
        FROM
            ipay_distributor
        WHERE
            distributor_id = '".$dist_id."'"
        );
        // $result= $query->result_array();
        // print_r($result);
        return $query->result_array();
    }

    // ###################### AKUISISI ##############################
    function get_new_acquisition_tu($dist_id, $bulan, $tahun)
    {
        
        $query = $this->db->query("SELECT 
        p.retailerid, p.amount,c.first_name, c.last_name
        FROM
        ipay_retailer_daily_payments p
        INNER JOIN
                ipay_retailer c ON p.retailerid = c.retailer_id
            INNER JOIN
        (SELECT 
            MIN(id) AS ids
        FROM
            ipay_retailer_daily_payments
        GROUP BY retailerid) t1 ON t1.ids = p.id
        AND p.dateofpayment BETWEEN '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59'
        AND c.activated_date BETWEEN '".$tahun."-".$bulan."-01' AND '".$tahun."-".$bulan."-31'
        AND c.distributer_id = '".$dist_id."'
        having amount > '200000'"
        );
        $q_result= $query->result_array();
        
        $jumlah_KCP= count($q_result);
    
        $result=[];
        array_push($result, $q_result, $jumlah_KCP);
        return $result;
    }

    //query untuk dapat list yang terakuisisi satu bulan sebelum bulan terpilih
    // dengan TopUp >=200rb maupun tidak
    function get_acquisition_list($dist_id, $bulan, $tahun) 
    {
        $query = $this->db->query("SELECT 
            distinct(retailer_id), first_name, last_name
        FROM
            ipay_retailer
        WHERE
            distributer_id = '".$dist_id."'
        AND activated_date Between '".$tahun."-".($bulan-1)."-01' AND '".$tahun."-".($bulan-1)."-31'
        AND status = '1'"
        );
        return $query->result_array();
    }

    //list KCP yang topup pada bulan terpilih (untuk hitung churn)
    function topup_list($dist_id, $bulan, $tahun) 
    {
        
        $query = $this->db->query("SELECT DISTINCT
            (retailerid)
        FROM
            ipay_retailer_daily_payments a
        INNER JOIN
            ipay_retailer b ON a.retailerid = b.retailer_id
        WHERE
            dateofpayment BETWEEN '".$tahun."-".($bulan)."-01 00:00:00'  AND '".$tahun."-".($bulan)."-31 23:59:59'
                AND b.distributer_id = '".$dist_id."'"
        );
        // $result = $query->result_array();
        // print_r($result);
        return $query->result_array();
    }

    // ###################### TOP UP ##############################
    function get_topup_slab1($dist_id, $bulan, $tahun)
    {
        $query = $this->db->query("SELECT 
            b.retailer_id,
            b.first_name,
            b.last_name,
            COUNT(a.retailerid) AS 'freq',
            SUM(a.amount) AS 'total'
        FROM
            ipay_retailer_daily_payments a
                LEFT JOIN
            ipay_retailer b ON (b.retailer_id = a.retailerid)
        WHERE
            dateofpayment BETWEEN '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59'
                AND b.distributer_id = '".$dist_id."'
        GROUP BY retailerid
        HAVING total < 1500000"
        );
        $q_result= $query->result_array();

        $jumlah_KCP= count($q_result);
        $qty_topup=0;
        $sum_topup=0;
        for ($i=0; $i < $jumlah_KCP ; $i++) { 
            $qty_topup += $q_result[$i]['freq'];
            $sum_topup += $q_result[$i]['total'];
        }
    
        $result=[];
        array_push($result, $q_result, $jumlah_KCP, $qty_topup, $sum_topup);
        return $result;
    }
    function get_topup_slab2($dist_id, $bulan, $tahun)
    {
        $query = $this->db->query("SELECT 
            b.retailer_id,
            b.first_name,
            b.last_name,
            COUNT(a.retailerid) AS 'freq',
            SUM(a.amount) AS 'total'
        FROM
            ipay_retailer_daily_payments a
                LEFT JOIN
            ipay_retailer b ON (b.retailer_id = a.retailerid)
        WHERE
            dateofpayment BETWEEN '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59'
                AND b.distributer_id = '".$dist_id."'
        GROUP BY retailerid
        HAVING total between 1500000 and 3999999"
        );
        $q_result= $query->result_array();

        $jumlah_KCP= count($q_result);
        $qty_topup=0;
        $sum_topup=0;
        for ($i=0; $i < $jumlah_KCP ; $i++) { 
            $qty_topup += $q_result[$i]['freq'];
            $sum_topup += $q_result[$i]['total'];
        }
        
        $result=[];
        array_push($result, $q_result, $jumlah_KCP, $qty_topup, $sum_topup);
        
        return $result;
    }
    function get_topup_slab3($dist_id, $bulan, $tahun)
    {
        $query = $this->db->query("SELECT 
            b.retailer_id,
            b.first_name,
            b.last_name,
            COUNT(a.retailerid) AS 'freq',
            SUM(a.amount) AS 'total'
        FROM
            ipay_retailer_daily_payments a
                LEFT JOIN
            ipay_retailer b ON (b.retailer_id = a.retailerid)
        WHERE
            dateofpayment BETWEEN '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59'
                AND b.distributer_id = '".$dist_id."'
        GROUP BY retailerid
        HAVING total >= 4000000"
        );
        $q_result= $query->result_array();

        $jumlah_KCP= count($q_result);
        $qty_topup=0;
        $sum_topup=0;
        for ($i=0; $i < $jumlah_KCP ; $i++) { 
            $qty_topup += $q_result[$i]['freq'];
            $sum_topup += $q_result[$i]['total'];
        }
        
        $result=[];
        array_push($result, $q_result, $jumlah_KCP, $qty_topup, $sum_topup);
        
        return $result;
    }

    // ###################### TRANSACTION ##############################
    function get_transaction($dist_id, $bulan)
    {
        $query = $this->db->query("SELECT 
            b.retailer_id,
            b.first_name,
            b.last_name,
            COUNT(a.retailer_id) AS 'freq',
            SUM(a.amount) AS 'total'
        FROM
            ipay_transactions a
                LEFT JOIN
            ipay_retailer b ON (b.retailer_id = a.retailer_id)
        WHERE
            transaction_date_only BETWEEN '".date('Y')."-".$bulan."-01' AND '".date('Y')."-".$bulan."-31'
                AND b.distributer_id = '".$dist_id."'
                AND cancelled_reference_id IS NULL
                AND payment_status = 'received'
                AND order_status = 'success'
                AND transaction_type != 'MT'
                AND transaction_type != 'LP'
        GROUP BY b.retailer_id"
        );
        
        $query2 = $this->db->query("SELECT 
            c.retailer_id,
            c.first_name,
            c.last_name,
            COUNT(b.retailer_id) AS freq,
            SUM(b.amount) AS total
        FROM
            ipay.ipay_loanprogram_trans_details a
                INNER JOIN
            ipay_transactions b ON a.ipayorder_id = b.order_id
                INNER JOIN
            ipay_retailer c ON b.retailer_id = c.retailer_id
        WHERE
            a.transactiontype = 'LOANSUBMISSION'
                AND a.status = 'SUCCESS'
                AND c.distributer_id = '".$dist_id."'
                AND b.TRANSACTION_DATE_only BETWEEN '".date('Y')."-".$bulan."-01' AND '".date('Y')."-".$bulan."-31'
        GROUP BY (c.retailer_id)"
        );

        // hasil query semua transaksi kecuali MT dan LP
        $q_result_trx= $query->result_array();

        // hasil query semua transaksi LP
        $q_result_lp= $query2->result_array();

        // value default => $q_result_trx
        $q_result_all=$q_result_trx;

        $jumlah_KCP_all= count($q_result_all);
        $jumlah_KCP_lp= count($q_result_lp);
        $slab_1=[];
        $slab_2=[];
        $slab_3=[];

        // overwrite jika ada LP
        for ($o=0; $o <$jumlah_KCP_lp ; $o++) { 
            $hasElement=0;
            for ($i=0; $i <$jumlah_KCP_all ; $i++) { 
                if ($q_result_all[$i]['retailer_id'] == $q_result_lp[$o]['retailer_id']) {
                    $freq= $q_result_all[$i]['freq'] + $q_result_lp[$o]['freq'];
                    $total= $q_result_all[$i]['total'] + $q_result_lp[$o]['total'];
                    $q_result_all[$i]=[
                                    'retailer_id'=>$q_result_all[$i]['retailer_id'], 
                                    'first_name'=>$q_result_all[$i]['first_name'], 
                                    'last_name'=>$q_result_all[$i]['last_name'], 
                                    'freq'=>$freq, 
                                    'total'=>$total
                                ];
                }
            }
            // cek apakah ada id lp yang belum ada dalam q_aquisisi_all, jika ada yang belum => push
            foreach($q_result_trx as $aa){
                if(!empty(array_search($q_result_lp[$o]['retailer_id'],$aa))){
                    $hasElement++;
                }
            }
            // jika tidak ada id nya => push
            if($hasElement ==0){
                $q_result_all[]=$q_result_lp[$o];
            }
        }
            
        for ($o=0; $o <count($q_result_all) ; $o++) { 
            // pembagian slab
            // slab 1
            if ($q_result_all[$o]['total']<1500000) {
                $slab_1[]=$q_result_all[$o];
            }
            // slab 2
            elseif ($q_result_all[$o]['total']<4000000) {
                $slab_2[]=$q_result_all[$o];
            }
            // slab 3
            else {
                $slab_3[]=$q_result_all[$o];
            }
        }
        
        
        // slab1
        $jumlah_KCP_slab_1= count($slab_1);
        $qty_trans_slab_1=0;
        $sum_trans_slab_1=0;
        for ($i=0; $i < $jumlah_KCP_slab_1 ; $i++) { 
            $qty_trans_slab_1 += $slab_1[$i]['freq'];
            $sum_trans_slab_1 += $slab_1[$i]['total'];
        }
        $result_slab_1=[];
        array_push($result_slab_1, $slab_1, $jumlah_KCP_slab_1, $qty_trans_slab_1, $sum_trans_slab_1);

        // slab2
        $jumlah_KCP_slab_2= count($slab_2);
        $qty_trans_slab_2=0;
        $sum_trans_slab_2=0;
        for ($i=0; $i < $jumlah_KCP_slab_2 ; $i++) { 
            $qty_trans_slab_2 += $slab_2[$i]['freq'];
            $sum_trans_slab_2 += $slab_2[$i]['total'];
        }
        
        $result_slab_2=[];
        array_push($result_slab_2, $slab_2, $jumlah_KCP_slab_2, $qty_trans_slab_2, $sum_trans_slab_2);

        // slab3
        $jumlah_KCP_slab_3= count($slab_3);
        $qty_trans_slab_3=0;
        $sum_trans_slab_3=0;
        for ($i=0; $i < $jumlah_KCP_slab_3 ; $i++) { 
            $qty_trans_slab_3 += $slab_3[$i]['freq'];
            $sum_trans_slab_3 += $slab_3[$i]['total'];
        }
        
        $result_slab_3=[];
        array_push($result_slab_3, $slab_3, $jumlah_KCP_slab_3, $qty_trans_slab_3, $sum_trans_slab_3);

        // untuk direturn
        $result=[];
        array_push($result, $result_slab_1, $result_slab_2, $result_slab_3);
        
        return $result;
    }

    // %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% retailer %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    function get_region()
    {
        $query = $this->db->query("SELECT 
            distinct(b.state)
        FROM
            ipay_distributor a
                INNER JOIN
            ipay_d_address_details b ON b.address_id = a.address_id
        WHERE
            status = '1'
                AND distributor_id IN ('D0J' , 'D0U',
                'D1F',
                'D1S',
                'D1T',
                'D0R',
                'D0Y',
                'D0D',
                'D0G',
                'D1X',
                'D0C',
                'D0E',
                'D0N',
                'D1R',
                'D0T',
                'D0I',
                'D1G',
                'D0F',
                'D0H')
                "
        );
        return $query->result_array();
    }

    function get_cvs($region){$query = $this->db->query("SELECT 
        a.beatguy_id,
        a.first_name AS cvs_fn,
        a.last_name AS cvs_ln,
        b.distributor_id,
        b.first_name AS dist_fn,
        b.last_name AS dist_ln
    FROM
        ipay_beatguy a
            INNER JOIN
        ipay_distributor b ON a.distributor_id = b.distributor_id
            INNER JOIN
        ipay_d_address_details c ON b.address_id = c.address_id
    WHERE
        a.status = '1'
            AND a.distributor_id IN ('D0J' , 'D0U',
            'D1F',
            'D1S',
            'D1T',
            'D0R',
            'D0Y',
            'D0D',
            'D0G',
            'D1X',
            'D0C',
            'D0E',
            'D0N',
            'D1R',
            'D0T',
            'D0I',
            'D1G',
            'D0F',
            'D0H')
            AND state = '".$region."'
            "
        );
        return $query->result_array();
    }

    function get_cvs_tu($bulan, $tahun){$query = $this->db->query("SELECT 
        beatguyid, sum(amount) as total_tu
    FROM
        ipay_retailer_daily_payments
    WHERE
        dateofpayment BETWEEN '".$tahun."-".$bulan."-01 00:00:00' AND '".$tahun."-".$bulan."-31 23:59:59'
            AND distributorid IN ('D0J' , 'D0U',
            'D1F',
            'D1S',
            'D1T',
            'D0R',
            'D0Y',
            'D0D',
            'D0G',
            'D1X',
            'D0C',
            'D0E',
            'D0N',
            'D1R',
            'D0T',
            'D0I',
            'D1G',
            'D0F',
            'D0H')
            and beatguyid like 'B%'
            group by beatguyid
            "
        );
        return $query->result_array();
    }

    function get_cvs_tu_negative_balance($bulan, $tahun){$query = $this->db->query("SELECT 
        a.retailer_id, a.retailer_credit_limit
    FROM
        ipay_retailer_credit_details a
        inner join ipay_retailer b on a.retailer_id =b.retailer_id
    WHERE
        retailer_credit_limit < 0
        AND distributor_id IN ('D0J' , 'D0U',
                'D1F',
                'D1S',
                'D1T',
                'D0R',
                'D0Y',
                'D0D',
                'D0G',
                'D1X',
                'D0C',
                'D0E',
                'D0N',
                'D1R',
                'D0T',
                'D0I',
                'D1G',
                'D0F',
                'D0H')
                "
        );
        return $query->result_array();
    }
}