<?php

namespace App\Models;

class Items_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'items';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $items_table = $this->db->prefixTable('items');
        $order_items_table = $this->db->prefixTable('order_items');
        $item_categories_table = $this->db->prefixTable('item_categories');
        // mod nicedev90
        $item_estados_table = $this->db->prefixTable('item_estados');

        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where .= " AND $items_table.id=$id";
        }

        $search = get_array_value($options, "search");
        if ($search) {
            $search = $this->db->escapeLikeString($search);
            $where .= " AND ($items_table.title LIKE '%$search%' ESCAPE '!' OR $items_table.description LIKE '%$search%' ESCAPE '!')";
        }

        $show_in_client_portal = $this->_get_clean_value($options, "show_in_client_portal");
        if ($show_in_client_portal) {
            $where .= " AND $items_table.show_in_client_portal=1";
        }

        // agregar condicion para item_estados -> siendo estado_id el campo en tabla items
        $category_id = $this->_get_clean_value($options, "category_id");
        if ($category_id) {
            $where .= " AND $items_table.category_id=$category_id";
        }

        // mod nicedev90, esta info viene de Items::lista_data()
        $estado_id = $this->_get_clean_value($options, "estado_id");
        if ($estado_id) {
            $where .= " AND $items_table.estado_id=$estado_id";
        }

        $extra_select = "";
        $login_user_id = $this->_get_clean_value($options, "login_user_id");
        if ($login_user_id) {
            $extra_select = ", (SELECT COUNT($order_items_table.id) FROM $order_items_table WHERE $order_items_table.deleted=0 AND $order_items_table.order_id=0 AND $order_items_table.created_by=$login_user_id AND $order_items_table.item_id=$items_table.id) AS added_to_cart";
        }

        $limit_query = "";
        $limit = $this->_get_clean_value($options, "limit");
        if ($limit) {
            $offset = $this->_get_clean_value($options, "offset");
            $limit_query = "LIMIT $offset, $limit";
        }

        // agregar un left join a la consulta para unir con la tabla item_estados
        // mod nicedev90 , agregado LEFT JOIN $item_estados_table
        $sql = "SELECT $items_table.*, $item_estados_table.item_estado as item_estado1, $item_estados_table.id as id_estado_tabla, $item_categories_table.title as category_title $extra_select
        FROM $items_table
        LEFT JOIN $item_categories_table ON $item_categories_table.id= $items_table.category_id
        LEFT JOIN $item_estados_table ON $item_estados_table.id= $items_table.estado_id
        WHERE $items_table.deleted=0 $where
        ORDER BY $items_table.title ASC
        $limit_query";
        return $this->db->query($sql);
    }


    function get_items_by_category($options = array()) {

        $items_table = $this->db->prefixTable('items');

        $where = "";

        $category_id = $this->_get_clean_value($options, "category_id");
        if ($category_id) {
            $where .= " AND $items_table.category_id=$category_id";
        }

        // mod nicedev90 
        $sql = "SELECT COUNT(DISTINCT $items_table.id) AS disponible, $items_table.title, $items_table.codigo 
        FROM $items_table
        WHERE $items_table.deleted=0 $where
        AND $items_table.estado_id=1
        GROUP BY $items_table.title ASC
        ";


        return $this->db->query($sql)->getResult();
        
    }


    function get_item_details_model($options = array()) {

        $items_table = $this->db->prefixTable('items');

        $where = "";

        $codigo = $this->_get_clean_value($options, "codigo");
        if ($codigo) {
            $where .= " AND $items_table.codigo=$codigo";
        }

        // mod nicedev90 
        $sql = "SELECT $items_table.description, $items_table.unit_type, $items_table.rate
        FROM $items_table
        WHERE $items_table.deleted=0 $where
        
        ";
        // $sql = "SELECT *  FROM $items_table";

        return $this->db->query($sql)->getResult();        
    }


}
