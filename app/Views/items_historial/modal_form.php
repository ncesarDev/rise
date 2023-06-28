<?php echo form_open(get_uri("item_estados/save"), array("id" => "estados-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <div class="container-fluid">
        <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
        <div class="form-group">
            <br />
            <div class="row">
                <label for="item_estado" class=" col-md-3"><?php echo app_lang('status'); ?></label>
                <div class=" col-md-9">
                    <?php
                    echo form_input(array(
                        "id" => "item_estado",
                        "name" => "item_estado",
                        "value" => $model_info->item_estado,
                        "class" => "form-control",
                        "placeholder" => 'Escribir el estado',
                        "autofocus" => true,
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
        $("#estados-form").appForm({
            onSuccess: function (result) {
                $("#item-table22").appTable({newData: result.data, dataId: result.id});
            }
        });
        setTimeout(function () {
            $("#item_estado").focus();
        }, 200);
    });
</script>