<?php 

error_reporting(0);
 ?>

<div id="page-content" class="page-wrapper clearfix">
	<div class="clearfix ">
	  <div class="card">

  	  <div class="page-title clearfix">
        <h1> <?php echo 'Historial de Equipos'; ?></h1>
      </div>

	    <div class="table-responsive">
	      <table id="item-table-historial" class="display" cellspacing="0" width="100%"></table>
	    </div>

		</div>

	</div>
</div>


<script type="text/javascript">
  $(document).ready(function () {
    $("#item-table-historial").appTable({
      source: '<?php echo_uri("items_historial/list_data") ?>',
      // filterDropdown: [
      //   {name: "category_id", class: "w200", options: <?php echo $categories_dropdown; ?>}
      // ],
      columns: [
        {title: "<?php echo 'ID' ?> "},
        {title: "<?php echo 'Nombre del Cliente' ?> "},
        {title: "<?php echo 'Nombre del equipo' ?> "},
        {title: "<?php echo 'Categoria' ?> "},
        {title: "<?php echo 'Costo' ?> "},
        {title: "<?php echo 'Fecha' ?> "},
        {title: "<?php echo 'Estado' ?> "},
        {title: "<i data-feather='menu' class='icon-16'></i>", "class": "text-center option w100"}
      ]
    });
  });
</script>