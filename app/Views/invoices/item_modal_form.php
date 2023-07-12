<?php error_reporting(0); ?>

<?php echo form_open(get_uri("invoices/save_item"), array("id" => "invoice-item-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <input type="hidden" id="item_id" name="item_id" value="" />
        <input type="hidden" name="invoice_id" value="<?php echo $invoice_id; ?>" />
        <input type="hidden" name="add_new_item_to_library" value="" id="add_new_item_to_library" />


        <!-- mod nicedev90, mostrar dropdown categorias de equipos -->
            <div class="form-group">
                <div class="row">
                    <label for="item_categories" class=" col-md-3"><?php echo app_lang('category'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        echo form_dropdown("item_categories", $categories_dropdown, 'valor_defecto', "class='w-100 bg-light p-2 rounded border-0 text-secondary validate-hidden' id='item_categories' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                        ?>
                    </div>
                </div>
            </div>

        <!-- mod nicedev90, mostrar dropdown de equipos -->
            <div class="form-group">
                <div class="row">
                    <label for="invoice_item_title" class=" col-md-3"><?php echo app_lang('item'); ?></label>
                    <div class=" col-md-9">
                        <?php
                        //echo form_dropdown("invoice_item_title", $items_dropdown, $model_info->title, "class='select2 validate-hidden' id='ca_id' data-rule-required='true', data-msg-required='" . app_lang('field_required') . "'");
                        ?>
                        <select name="invoice_item_title" id="invoice_item_title" class="w-100 bg-light p-2 rounded border-0 text-secondary validate-hidden">
                            <option value="">Seleccionar Equipo  </option>
                        </select>
                    </div>
                </div>
            </div>

        <div class="form-group">
            <div class="row">
                <label for="invoice_item_quantity" class=" col-md-3"><?php echo app_lang('quantity'); ?></label>
                <div class="col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "invoice_item_quantity",
                        "name" => "invoice_item_quantity",
                        "value" => $model_info->quantity ? to_decimal_format($model_info->quantity) : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('quantity'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>

        
        <div class="form-group">
            <div class="row">
                <label for="invoice_item_description" class="col-md-3"><?php echo app_lang('description'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_textarea(array(
                        "id" => "invoice_item_description",
                        "name" => "invoice_item_description",
                        "value" => $model_info->description ? $model_info->description : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('description')
                    ));
                    ?>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="row">
                <label for="invoice_unit_type" class="col-md-3"><?php echo app_lang('unit_type'); ?></label>
                <div class="col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "invoice_unit_type",
                        "name" => "invoice_unit_type",
                        "value" => $model_info->unit_type,
                        "class" => "form-control",
                        "placeholder" => app_lang('unit_type') . ' (Ex: hours, pc, etc.)'
                    ));
                    ?>
                </div>


            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <label for="invoice_item_rate" class=" col-md-3"><?php echo app_lang('rate'); ?></label>
                <div class="col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "invoice_item_rate",
                        "name" => "invoice_item_rate",
                        "value" => $model_info->rate ? to_decimal_format($model_info->rate) : "",
                        "class" => "form-control",
                        "placeholder" => app_lang('rate'),
                        "data-rule-required" => true,
                        "data-msg-required" => app_lang("field_required"),
                    ));
                    ?>
                </div>
            </div>
        </div>


    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><span data-feather="x" class="icon-16"></span> <?php echo app_lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span data-feather="check-circle" class="icon-16"></span> <?php echo app_lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#invoice-item-form").appForm({
            onSuccess: function (result) {
                $("#invoice-item-table").appTable({newData: result.data, dataId: result.id});
                $("#invoice-total-section").html(result.invoice_total_view);
                if (typeof updateInvoiceStatusBar == 'function') {
                    updateInvoiceStatusBar(result.invoice_id);
                }
            }
        });

        //show item suggestion dropdown when adding new item
        // var isUpdate = "<?php echo $model_info->id; ?>";
        // if (!isUpdate) {
        //     applySelect2OnItemTitle();
        // }

        // //re-initialize item suggestion dropdown on request
        // $("#invoice_item_title_dropdwon_icon").click(function () {
        //     applySelect2OnItemTitle();
        // })

// var jsdom = require('jsdom');
// $ = require('jquery')(new jsdom.JSDOM().window);




    });






    // mod nicedev90
    $("#item_categories").change(function (e) {
        // console.log(e.target.value)
        let valor = e.currentTarget.value
        console.log(valor)
        // let valor = $("#item_categories").val(); //reset the flag to add new item in library
        // console.log(valor)

        $.ajax({
            url: "<?php echo get_uri("invoices/get_items_by_category"); ?>",
            data: {category_id: valor}, // category_id se envia con $_POST
            cache: false,
            type: 'POST',
            dataType: "json",
            success: function (response) {
                $("#invoice_item_title").empty().append(`<option value="">Seleccionar Equipo  </option>`)

                console.log(response.item_info)
                //auto fill the description, unit type and rate fields.
                // if response (object) exists && response.success = true
                if (response && response.success) {
                    // $.each(response.item_info, function (item) {
                    //     // let option = `<option value=""> ${item.title} - Disponibles:  ${item.disponible}</option>`
                    //      $("#invoice_item_title").append(option)
                    // })
                    
                    response.item_info.forEach( item => {
                        let option = `<option value="${item.codigo}"> ${item.title} -  Disponibles:  ${item.disponible}</option>`
                        $("#invoice_item_title").append(option)
                    }) 

                    // console.log($("#invoice_item_title").val())

                    

                    // $("#item_id").val(response.item_info.id);
                    // $("#invoice_item_title").val(response.item_info.title);
                    
                    // $("#invoice_item_description").val(response.item_info.disponible);

                    // $("#invoice_unit_type").val(response.item_info.unit_type);

                    // $("#invoice_item_rate").val(response.item_info.rate);
                }else {
                        let option = `<option value=""> No hay Equipos  Disponibles </option>`
                        $("#invoice_item_title").append(option) 
                    }

            }
        });    
    })


//     const invoiceTitle = document.querySelector('#invoice_item_title')
//     invoiceTitle.addEventListener('change', e => {


//               // const ress = fetch(myurl, {
//               //                   method: "POST", // *GET, POST, PUT, DELETE, etc.
//               //                   mode: "cors", // no-cors, *cors, same-origin
//               //                   cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
//               //                   credentials: "same-origin", // include, *same-origin, omit
//               //                   headers: {
//               //                     "Content-Type": "application/json",
//               //                     // 'Content-Type': 'application/x-www-form-urlencoded',
//               //                   },
//               //                   redirect: "follow", // manual, *follow, error
//               //                   referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
//               //                   body: JSON.stringify(myitem), // body data type must match "Content-Type" header
//               //                 });
//                               // return response.json();


//         let myurl = '<?php echo get_uri("invoices/get_item_details_mod"); ?>'
//         console.log(myurl)
            
//         let myitem = { 
//             item_title: e.target.value
//         }
//         console.log(myitem)

//         let item = JSON.stringify(myitem)
//         var xhr = new XMLHttpRequest()
//         xhr.open('POST', myurl, true)
//         xhr.setRequestHeader('Content-type', 'application/json')
//         xhr.send(item)

//         xhr.onload = function (response) {
//             console.log(response)
//         }

// })

           
    

        $("#invoice_item_title").change(function (e) {
            
            let item_cod = e.currentTarget.value
            console.log(item_cod)

            $.ajax({
                // headers: { 'X-Requested-With': 'XMLHttpRequest' },
                url: "<?php echo get_uri("invoices/get_item_details_mod"); ?>",
                // data: JSON.stringify({item_title: item_cod }),
                data: {codigo: item_cod}, 
                cache: false,
                type: 'POST',
                dataType: "json",
                success: function (response) {
                    // $("#invoice_item_title").empty()

                    console.log(response.item_info)

                    if (response && response.success) {
                        
                        $("#invoice_item_description").val(response.item_info.description);

                        $("#invoice_unit_type").val(response.item_info.unit_type);

                        $("#invoice_item_rate").val(response.item_info.rate);
                    }
                },
                 error: (error) => {
                     console.log(JSON.stringify(error));
                }
            });    
        })





    // function applySelect2OnItemTitle() {
    //     $("#invoice_item_title").select2({
    //         showSearchBox: true,
    //         ajax: {
    //             url: "<?php echo get_uri("invoices/get_invoice_item_suggestion"); ?>",
    //             dataType: 'json',
    //             quietMillis: 250,
    //             data: function (term, page) {
    //                 return {
    //                     q: term // search term
    //                 };
    //             },
    //             results: function (data, page) {
    //                 return {results: data};
    //             }
    //         }
    //     }).change(function (e) {
    //         if (e.val === "+") {
    //             //show simple textbox to input the new item
    //             $("#invoice_item_title").select2("destroy").val("").focus();
    //             $("#add_new_item_to_library").val(1); //set the flag to add new item in library
    //         } else if (e.val) {
    //             //get existing item info
    //             $("#add_new_item_to_library").val(""); //reset the flag to add new item in library
    //             $.ajax({
    //                 url: "<?php echo get_uri("invoices/get_invoice_item_info_suggestion"); ?>",
    //                 data: {item_id: e.val}, // item_id se envia a la base
    //                 cache: false,
    //                 type: 'POST',
    //                 dataType: "json",
    //                 success: function (response) {

    //                     //auto fill the description, unit type and rate fields.
    //                     if (response && response.success) {
    //                         $("#item_id").val(response.item_info.id);
    //                         $("#invoice_item_title").val(response.item_info.title);
                            
    //                         $("#invoice_item_description").val(response.item_info.description);

    //                         $("#invoice_unit_type").val(response.item_info.unit_type);

    //                         $("#invoice_item_rate").val(response.item_info.rate);
    //                     }
    //                 }
    //             });
    //         }

    //     });
    // }




</script>