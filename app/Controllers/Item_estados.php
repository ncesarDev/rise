<?php

namespace App\Controllers;
//  todas las clases que van a necesitar un user login DEBEN extender Security_Controller
class Item_estados extends Security_Controller {

    function __construct() {
        parent::__construct();
        // access_only  verifica el perfil del usuario logueado
        $this->access_only_admin_or_settings_admin();        
    }

    //load item estados list view
    function index() {
        return $this->template->rander("item_estados/index");
    }


    //load item category add/edit modal form
    function modal_form() {
        $this->validate_submitted_data(array(
            "id" => "numeric"
        ));

        // model_info -> trae la informacion de la tabla, segun la PK (defaul id)
        // get_one() retorna un id o null
        $view_data['model_info'] = $this->Item_estados_model->get_one($this->request->getPost('id'));
        return $this->template->view('item_estados/modal_form', $view_data);
    }


    //save item category
    function save() {
        // validar los campos del formulario
        $this->validate_submitted_data(array(
            // se debe asignar los campos obligatorios del formulario
            // name (del elemento del form) => attribute
            "id" => "numeric",
            "item_estado" => "required"
        ));

        // $id se le asigna  id del post o  null(para crear nuevo registro)
        $id = $this->request->getPost('id');
        $data = array(
            //  columna en tabla => name del formulario
            "item_estado" => $this->request->getPost('item_estado')
        );

        // ci_save($data, $id)  retorna el numero Id del registro creado/actualizado, si es null dará error
        $save_id = $this->Item_estados_model->ci_save($data, $id);
        if ($save_id) {
            // se crea un row (formato json) para ser agregado  ala tabla luego del save()
            echo json_encode(array("success" => true, "data" => $this->_row_data($save_id), 'id' => $save_id, 'message' => app_lang('record_saved')));
        } else {
            echo json_encode(array("success" => false, 'message' => app_lang('error_occurred')));
        }
    }

    //delete/undo an item category
    function delete() {
        $this->validate_submitted_data(array(
            "id" => "required|numeric"
        ));

        $id = $this->request->getPost('id');
        if ($this->request->getPost('undo')) {
            if ($this->Item_estados_model->delete($id, true)) {
                echo json_encode(array("success" => true, "data" => $this->_row_data($id), "message" => app_lang('record_undone')));
            } else {
                echo json_encode(array("success" => false, app_lang('error_occurred')));
            }
        } else {
            if ($this->Item_estados_model->delete($id)) {
                echo json_encode(array("success" => true, 'message' => app_lang('record_deleted')));
            } else {
                echo json_encode(array("success" => false, 'message' => app_lang('record_cannot_be_deleted')));
            }
        }
    }



    //get data for items category list
    function list_data() {
        // $this->access_only_team_members();

        $list_data = $this->Item_estados_model->get_details()->getResult();
        $result = array();
        foreach ($list_data as $data) {
            $result[] = $this->_make_row($data);
        }
        echo json_encode(array("data" => $result));
    }

    //get an expnese category list row
    private function _row_data($id) {
        $options = array("id" => $id);
        $data = $this->Item_estados_model->get_details($options)->getRow();
        return $this->_make_row($data);
    }

    //prepare an item category list row
    private function _make_row($data) {
        return array($data->item_estado,
            modal_anchor(get_uri("item_estados/modal_form"), "<i data-feather='edit' class='icon-16'></i>", array("class" => "edit", "title" => "editar el estado", "data-post-id" => $data->id))
            . js_anchor("<i data-feather='x' class='icon-16'></i>", array('title' => app_lang('delete_items_category'), "class" => "delete", "data-id" => $data->id, "data-action-url" => get_uri("item_estados/delete"), "data-action" => "delete"))
        );
    }

}