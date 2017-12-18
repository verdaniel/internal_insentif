<?php
class Insentif_model_asm extends CI_Model{
    
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

    function get_cvs_tu($bulan){
        
    $query = $this->db->query("SELECT 
            beatguy_id, b.total_tu
        FROM
            ipay_beatguy a
                LEFT JOIN
            (SELECT 
                beatguyid, SUM(amount) AS total_tu
            FROM
                ipay_retailer_daily_payments
            WHERE
                dateofpayment BETWEEN '2017-".$bulan."-01 00:00:00' AND '2017-".$bulan."-31 23:59:59'
                    AND beatguyid LIKE 'B%'
                    AND distributorid IN ('D0J' , 'D0U', 'D1F', 'D1S', 'D1T', 'D0R', 'D0Y', 'D0D', 'D0G', 'D1X', 'D0C', 'D0E', 'D0N', 'D1R', 'D0T', 'D0I', 'D1G', 'D0F', 'D0H')
            GROUP BY beatguyid) b ON a.beatguy_id = b.beatguyid
        WHERE
            status = 1
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

    function get_cvs_tu_negative_balance($bulan){$query = $this->db->query("SELECT 
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