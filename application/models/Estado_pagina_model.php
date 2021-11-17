<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Estado_pagina_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get estado_pagina by estadopag_id
     */
    function get_estado_pagina($estadopag_id)
    {
        $estado_pagina = $this->db->query("
            SELECT
                *

            FROM
                `estado_pagina`

            WHERE
                `estadopag_id` = ?
        ",array($estadopag_id))->row_array();

        return $estado_pagina;
    }
    
    /*
     * Get all estado_pagina count
     */
    function get_all_estado_pagina_count()
    {
        $estado_pagina = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `estado_pagina`
        ")->row_array();

        return $estado_pagina['count'];
    }
        
    /*
     * Get all estado_pagina
     */
    function get_all_estado_pagina($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $estado_pagina = $this->db->query("
            SELECT
                *

            FROM
                `estado_pagina`

            WHERE
                1 = 1

            ORDER BY `estadopag_id` DESC

            " . $limit_condition . "
        ")->result_array();

        return $estado_pagina;
    }
        
    /*
     * function to add new estado_pagina
     */
    function add_estado_pagina($params)
    {
        $this->db->insert('estado_pagina',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update estado_pagina
     */
    function update_estado_pagina($estadopag_id,$params)
    {
        $this->db->where('estadopag_id',$estadopag_id);
        return $this->db->update('estado_pagina',$params);
    }
    
    /*
     * function to delete estado_pagina
     */
    function delete_estado_pagina($estadopag_id)
    {
        return $this->db->delete('estado_pagina',array('estadopag_id'=>$estadopag_id));
    }
}
