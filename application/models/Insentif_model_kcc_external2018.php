<?php
class Insentif_model_kcc_external2018 extends CI_Model{
// !!!!!! JANGAN LUPA (2017) GANTI TAHUN KE (".$tahun.") NANTI !!!!!!!!

// ###################### AKUISISI ##############################

    function get_active_kcp($dist_id, $bulan, $tahun)
    {
        $query = $this->db->query("SELECT 
            p.retailerid,
            SUM(p.amount) AS total,
            c.first_name,
            c.last_name
        FROM
            ipay_retailer_daily_payments p
                INNER JOIN
            ipay_retailer c ON p.retailerid = c.retailer_id
                AND p.dateofpayment BETWEEN '2017-".$bulan."-01 00:00:00' AND '2017-".$bulan."-31 23:59:59'
                AND c.distributer_id = '".$dist_id."'
        GROUP BY p.retailerid
        HAVING total >= 200000"
        );
        $q_result= $query->result_array();
        
        $jumlah_KCP= count($q_result);

        $result=[];
        array_push($result, $q_result, $jumlah_KCP);
        return $result;
    }

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
        AND p.dateofpayment BETWEEN '2017-".$bulan."-01 00:00:00' AND '2017-".$bulan."-31 23:59:59'
        AND c.activated_date BETWEEN '2017-".$bulan."-01' AND '2017-".$bulan."-31'
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
        AND activated_date Between '2017-".($bulan-1)."-01' AND '2017-".($bulan-1)."-31'
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
            dateofpayment BETWEEN '2017-".($bulan)."-01 00:00:00'  AND '2017-".($bulan)."-31 23:59:59'
                AND b.distributer_id = '".$dist_id."'"
        );
        // $result = $query->result_array();
        // print_r($result);
        return $query->result_array();
    }

// ########################### TRANSACTION ###########################
    function get_transaction($dist_id, $bulan, $tahun)
    {        
        $query = $this->db->query("SELECT 
            a.transaction_type,
            a.transaction_date,
            a.retailer_id,
            b.first_name,
            b.last_name
        FROM
            ipay_transactions a
                INNER JOIN
            ipay_retailer b ON a.retailer_id = b.retailer_id
        WHERE
            transaction_date_only BETWEEN '2017-".$bulan."-01' AND '2017-".$bulan."-31'
                AND a.cancelled_reference_id IS NULL
                AND a.payment_status = 'received'
                AND a.order_status = 'success'
                AND a.distributer_id = '".$dist_id."'
                AND transaction_type IN ('MR' , 'TO',
                'MT',
                'EP',
                'RP',
                'PP',
                'EB',
                'MF',
                'IP',
                'KP',
                'OP',
                'DT',
                'DC',
                'GV')
                "
        );
        $q_result= $query->result_array();
        $jumlah_KCP= count($q_result);
        // $array_MR=[]; //isi pulsa
        // $array_TO=[]; //Top up operator
        // $array_MT=[]; //money trf
        // $array_EP=[]; //e-commerce
        // $array_RP=[]; //referral program or product
        // $array_PP=[]; //pasca bayar
        // $array_EB=[]; //bayar tagihan
        // $array_MF=[]; //bayar pinjaman
        // $array_IP=[]; //premi asuransi
        // $array_KP=[]; //kioson pay
        // $array_OP=[]; //olx payment
        // $array_DT=[]; //voucher tv berbayar
        // $array_DC=[]; //voucher internet
        // $array_GV=[]; //voucher games
        
        $array_pulsa=[];
        $array_ppob=[];
        $array_moneyTansfer=[];
        $array_digitalProduct=[];
        $array_eCommerce=[];
        $array_referralProduct=[];

        
        
        for ($i=0; $i < $jumlah_KCP ; $i++) { 
            switch ($q_result[$i]['transaction_type']) {
                case 'MR':
                    $array_pulsa[]=$q_result[$i];
                    break;
                case 'TO':
                    $array_pulsa[]=$q_result[$i];
                    break;
                case 'MT':
                    $array_moneyTansfer[]=$q_result[$i];
                    break;
                case 'EP':
                    $array_eCommerce[]=$q_result[$i];
                    break;
                case 'RP':
                    $array_referralProduct[]=$q_result[$i];
                    break;
                case 'PP':
                    $array_ppob[]=$q_result[$i];
                    break;
                case 'EB':
                    $array_ppob[]=$q_result[$i];
                    break;
                case 'MF':
                    $array_ppob[]=$q_result[$i];
                    break;
                case 'IP':
                    $array_ppob[]=$q_result[$i];
                    break;
                case 'KP':
                    $array_ppob[]=$q_result[$i];
                    break;
                case 'OP':
                    $array_ppob[]=$q_result[$i];
                    break;
                case 'DT':
                    $array_digitalProduct[]=$q_result[$i];
                    break;
                case 'DC':
                    $array_digitalProduct[]=$q_result[$i];
                    break;  
                default:
                    # GV
                    $array_digitalProduct[]=$q_result[$i];
                    break;
            }
        }
        $result=[];
        array_push($result, 
            $array_pulsa, 
            $array_ppob, 
            $array_moneyTansfer, 
            $array_digitalProduct, 
            $array_eCommerce, 
            $array_referralProduct
        );
        
        return $result;
    }
// ########################### TOP UP ###########################
    function get_topup($dist_id, $bulan, $tahun)
    {
        // !!!!!! JANGAN LUPA GANTI TAHUN KE 2018 NANTI !!!!!!!!
        $query = $this->db->query("SELECT 
            p.retailerid,
            p.amount,
            c.first_name,
            c.last_name,
            p.dateofpayment
        FROM
            ipay_retailer_daily_payments p
                INNER JOIN
            ipay_retailer c ON p.retailerid = c.retailer_id
        WHERE
            p.dateofpayment BETWEEN '2017-".$bulan."-01 00:00:00' AND '2017-".$bulan."-31 23:59:59'
                AND c.distributer_id = '".$dist_id."'
        HAVING amount >= 200000"
        );
        $q_result= $query->result_array();    
        $jumlah_KCP= count($q_result);  
        
        //looping untuk variable generator
        for($i=1; $i <= 31; $i++) {
            // menampung seluruh data
            ${'array_'.$i} = [];

            // hanya menampung ID KCP
            // untuk cari unique top up dan freq top up tiap kcp
            ${'kcp_id_'.$i} = [];
        }

        // untuk buang H:i:s
        // dan untuk sortir berdasar tanggal
        for ($i=0; $i < $jumlah_KCP ; $i++) { 
            $q_replica= $q_result;
            $date = $q_result[$i]['dateofpayment'];
            $date = strtotime($date);
            $date = date('d', $date);
            $q_replica[$i]['dateofpayment'] = $date;
            
            switch ($q_replica[$i]['dateofpayment']) {
                case '01':
                    $array_1[]=$q_replica[$i];
                    $kcp_id_1[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '02':
                    $array_2[]=$q_replica[$i];
                    $kcp_id_2[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '03':
                    $array_3[]=$q_replica[$i];
                    $kcp_id_3[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '04':
                    $array_4[]=$q_replica[$i];
                    $kcp_id_4[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '05':
                    $array_5[]=$q_replica[$i];
                    $kcp_id_5[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '06':
                    $array_6[]=$q_replica[$i];
                    $kcp_id_6[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '07':
                    $array_7[]=$q_replica[$i];
                    $kcp_id_7[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '08':
                    $array_8[]=$q_replica[$i];
                    $kcp_id_8[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '09':
                    $array_9[]=$q_replica[$i];
                    $kcp_id_9[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '10':
                    $array_10[]=$q_replica[$i];
                    $kcp_id_10[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '11':
                    $array_11[]=$q_replica[$i];
                    $kcp_id_11[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '12':
                    $array_12[]=$q_replica[$i];
                    $kcp_id_12[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '13':
                    $array_13[]=$q_replica[$i];
                    $kcp_id_13[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '14':
                    $array_14[]=$q_replica[$i];
                    $kcp_id_14[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '15':
                    $array_15[]=$q_replica[$i];
                    $kcp_id_15[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '16':
                    $array_16[]=$q_replica[$i];
                    $kcp_id_16[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '17':
                    $array_17[]=$q_replica[$i];
                    $kcp_id_17[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '18':
                    $array_18[]=$q_replica[$i];
                    $kcp_id_18[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '19':
                    $array_19[]=$q_replica[$i];
                    $kcp_id_19[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '20':
                    $array_20[]=$q_replica[$i];
                    $kcp_id_20[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '21':
                    $array_21[]=$q_replica[$i];
                    $kcp_id_21[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '22':
                    $array_22[]=$q_replica[$i];
                    $kcp_id_22[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '23':
                    $array_23[]=$q_replica[$i];
                    $kcp_id_23[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '24':
                    $array_24[]=$q_replica[$i];
                    $kcp_id_24[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '25':
                    $array_25[]=$q_replica[$i];
                    $kcp_id_25[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '26':
                    $array_26[]=$q_replica[$i];
                    $kcp_id_26[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '27':
                    $array_27[]=$q_replica[$i];
                    $kcp_id_27[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '28':
                    $array_28[]=$q_replica[$i];
                    $kcp_id_28[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '29':
                    $array_29[]=$q_replica[$i];
                    $kcp_id_29[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                case '30':
                    $array_30[]=$q_replica[$i];
                    $kcp_id_30[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
                default:
                    # 31
                    $array_31[]=$q_replica[$i];
                    $kcp_id_31[]=$q_replica[$i]['retailerid']." - ".$q_replica[$i]['first_name']." ".$q_replica[$i]['last_name'];
                    break;
            }

        }
        // untuk hitung jumlah untuk tiap2 nama yang muncul
        // $b=array_count_values($a);
        for($i=1; $i <= 31; $i++) {
            ${'kcp_id_'.$i} = array_count_values(${'kcp_id_'.$i});
        }
        
        // push data kcp ke array -$result1-
        $result1=[];
        array_push($result1, 
        $array_1 ,
        $array_2 ,
        $array_3 ,
        $array_4 ,
        $array_5 ,
        $array_6 ,
        $array_7 ,
        $array_8 ,
        $array_9 ,
        $array_10 ,
        $array_11 ,
        $array_12 ,
        $array_13 ,
        $array_14 ,
        $array_15 ,
        $array_16 ,
        $array_17 ,
        $array_18 ,
        $array_19 ,
        $array_20 ,
        $array_21 ,
        $array_22 ,
        $array_23 ,
        $array_24 ,
        $array_25 ,
        $array_26 ,
        $array_27 ,
        $array_28 ,
        $array_29 ,
        $array_30 ,
        $array_31
        );

        // push ID kcp ke array -$result1-
        $result2=[];
        array_push($result2, 
        $kcp_id_1 ,
        $kcp_id_2 ,
        $kcp_id_3 ,
        $kcp_id_4 ,
        $kcp_id_5 ,
        $kcp_id_6 ,
        $kcp_id_7 ,
        $kcp_id_8 ,
        $kcp_id_9 ,
        $kcp_id_10 ,
        $kcp_id_11 ,
        $kcp_id_12 ,
        $kcp_id_13 ,
        $kcp_id_14 ,
        $kcp_id_15 ,
        $kcp_id_16 ,
        $kcp_id_17 ,
        $kcp_id_18 ,
        $kcp_id_19 ,
        $kcp_id_20 ,
        $kcp_id_21 ,
        $kcp_id_22 ,
        $kcp_id_23 ,
        $kcp_id_24 ,
        $kcp_id_25 ,
        $kcp_id_26 ,
        $kcp_id_27 ,
        $kcp_id_28 ,
        $kcp_id_29 ,
        $kcp_id_30 ,
        $kcp_id_31
        );

        // push array data & ID ke array result untuk di return
        $result=[];
        array_push($result, 
        $result1,
        $result2,
        $q_result);
        return $result;

    }
}

