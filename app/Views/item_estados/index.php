

<div id="page-content" class="page-wrapper clearfix">
	<div class="clearfix ">
	  <div class="card">

  	  <div class="page-title clearfix">
        <h1> <?php echo 'Estados'; ?></h1>
        <div class="title-button-group">

          <?php echo modal_anchor(get_uri("item_estados/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . "Agregar Estado.", array("class" => "btn btn-default", "title" => "agregar estado")); ?>
        </div>
      </div>

	    <div class="table-responsive">
	      <table id="item-table22" class="display" cellspacing="0" width="100%"></table>
	    </div>

		</div>

	</div>
</div>


<script type="text/javascript">
  $(document).ready(function () {
    $("#item-table22").appTable({
      source: '<?php echo_uri("item_estados/list_data") ?>',
      columns: [
        {title: "<?php echo app_lang('status') ?> "},
        {title: "<i data-feather='menu' class='icon-16'></i>", "class": "text-center option w100"}
      ]
    });
  });
</script>