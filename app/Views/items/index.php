<div id="page-content" class="page-wrapper clearfix">

<div class="dashboards-row clearfix row"><div class="widget-container col-md-3"><div id="js-clock-in-out" class="card dashboard-icon-widget clock-in-out-card">
    
    <div class="card-body">
            <div class="widget-icon bg-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list icon"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
            </div>
            <div class="widget-details">
                 <!-- mod nicedev90 -->
                <h1> <?php echo isset($totalEquipos) ? count($totalEquipos)  : 0 ; ?> </h1>
                <span class="bg-transparent-white"><strong>Equipos Disponibles</strong></span>
            </div>
    </div>
    
</div></div><div class="widget-container col-md-3"><a href="https://serlisa.com.pe/sistema/index.php/projects/all_tasks" class="white-link">
    <div class="card dashboard-icon-widget">
        <div class="card-body">
            <div class="widget-icon bg-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list icon"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
            </div>
            <div class="widget-details">
                 <!-- mod nicedev90 -->
                <h1><?php echo isset($totalMant) ? count($totalMant) : 0 ; ?></h1>
                <span class="bg-transparent-white"><strong>Equipos No Disponibles</strong></span>
            </div>
        </div>
    </div>
</a></div><div class="widget-container col-md-3"><a href="https://serlisa.com.pe/sistema/index.php/events" class="white-link">
    <div class="card dashboard-icon-widget">
        <div class="card-body">
            <div class="widget-icon bg-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar icon"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
            </div>
            <div class="widget-details">
                <h1>50</h1>
                <span class="bg-transparent-white"><strong>Equipos en Campo</strong></span>
            </div>
        </div>
    </div>
</a></div><div class="widget-container col-md-3">
<a href="https://serlisa.com.pe/sistema/index.php/invoices/index" class="white-link">
    <div class="card  dashboard-icon-widget">
        <div class="card-body ">
            <div class="widget-icon bg-coral">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-compass icon"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
            </div>
            <div class="widget-details">
                 <!-- mod nicedev90 -->
                <h1><?php echo isset($totalMant) ? count($totalMant) : 0 ; ?> </h1>
                <span class="bg-transparent-white"><strong>Equipos en Mantenimiento</strong></span>
            </div>
        </div>
    </div>
</a></div></div>



    <div class="card">
        <div class="page-title clearfix">
            <h1> <?php echo app_lang('items'); ?></h1>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("items/import_items_modal_form"), "<i data-feather='upload' class='icon-16'></i> " . app_lang('import_items'), array("class" => "btn btn-default", "title" => app_lang('import_items'))); ?>
                <?php echo modal_anchor(get_uri("items/modal_form"), "<i data-feather='plus-circle' class='icon-16'></i> " . app_lang('add_item'), array("class" => "btn btn-default", "title" => app_lang('add_item'))); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="item-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>





<script type="text/javascript">
    $(document).ready(function () {
        $("#item-table").appTable({
            source: '<?php echo_uri("items/list_data") ?>',
            order: [[0, 'desc']],
            filterDropdown: [
                {name: "category_id", class: "w200", options: <?php echo $categories_dropdown; ?>}
            ],
            columns: [
                {title: "<?php echo 'Código' ?> ", "class": "w8p all"},
                {title: "<?php echo app_lang('title') ?> ", "class": "w20p all"},
                {title: "<?php echo app_lang('description') ?> ", "class": "w20p all"},
                {title: "<?php echo app_lang('category') ?>"},
                {title: "<?php echo app_lang('unit_type') ?>", "class": "w100"},
                {title: "<?php echo app_lang('rate') ?>", "class": "text-right w100"},
                {title: "<?php echo app_lang('status') ?>", order_by: "status"},
                {title: "<i data-feather='menu' class='icon-16'></i>", "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 3, 4, 5, 6 ],
            xlsColumns: [0, 1, 2, 3, 4, 5, 6]
        });
    });
</script>



