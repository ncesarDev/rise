<?php

namespace App\Models;

class Item_estados_model extends Crud_model {

    protected $table = null;

    function __construct() {
        $this->table = 'item_estados';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $item_estados_table = $this->db->prefixTable('item_estados');
        $where = "";
        $id = $this->_get_clean_value($options, "id");
        if ($id) {
            $where = " AND $item_estados_table.id=$id";
        }

        $sql = "SELECT $item_estados_table.*
        FROM $item_estados_table
        WHERE $item_estados_table.deleted=0 $where";
        return $this->db->query($sql);
    }

}
