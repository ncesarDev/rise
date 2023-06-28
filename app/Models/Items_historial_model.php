<?php
namespace App\Models;

class Items_historial_model extends Crud_model {
    protected $table = null;
    function __construct() {
        $this->table = 'invoice_items';
        parent::__construct($this->table);
    }

    function get_details($options = array()) {
        $items = $this->db->prefixTable('invoice_items');
        $invoices = $this->db->prefixTable('invoices');
        $clients = $this->db->prefixTable('clients');

        $where = "";
        // mod nicedev90, esta info viene de Items::lista_data()
        $invoice_id = $this->_get_clean_value($options, "invoice_id");
        if ($invoice_id) {
            $where .= " AND $items.invoice_id=$invoice_id";
        }

        // agregar un left join a la consulta para unir con la tabla item_estados
        // mod nicedev90 , agregado LEFT JOIN $item_estados_table
        $sql = "SELECT $items.*, 
        $invoices.id as id_invoice_tabla,
        $invoices.due_date as invoice_due_date,
        $clients.company_name as company
        FROM $items
        LEFT JOIN $invoices ON $items.invoice_id = $invoices.id
        LEFT JOIN $clients ON $invoices.client_id = $clients.id
        WHERE $items.deleted=0 $where
        ORDER BY $invoices.id ASC";

        return $this->db->query($sql);

    }
}
