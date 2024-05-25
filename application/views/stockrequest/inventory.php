<style type="text/css">
    .prints {
        background-color: #31B404;
        color: #fff;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-note2"></i></div>
        <div class="header-title">
            <h1>
                <?php echo display('stockinhand') ?>
            </h1>
            <small><?php echo display('stockinhand') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>
                        <?php echo display('home') ?>
                    </a></li>
                <li class="active"><?php echo display('stockinhand') ?></li>
            </ol>
        </div>
    </section>

    <section class="content">
        <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
            ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>
            </div><?php
            $this->session->unset_userdata('message');
        }
        $error_message = $this->session->userdata('error_message');
        if (isset($error_message)) {
            ?><div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>
            </div><?php
            $this->session->unset_userdata('error_message');
        }
        ?><div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>
                                <?php echo display('stockinhand') ?>
                            </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" cellspacing="0" width="100%" id="InvList">
                                <thead>
                                    <tr>
                                        <th>
                                            <?php echo display('sl') ?>
                                        </th>
                                        <th><?php echo display('product_name') ?></th>
                                        <th>
                                            <?php echo display('product_model') ?>
                                        </th>
                                        <th><?php echo display('batch') ?></th>
                                        <th>
                                            <?php echo display('quantity') ?>
                                        </th>
                                        <th><?php echo display('price') ?></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var mydatatable = $('#InvList').DataTable({
            responsive: true,
            "aaSorting": [[1, "desc"]],
            "columnDefs": [{ "bSortable": false, "aTargets": [0] }],
            'processing': true,
            'serverSide': true,
            'lengthMenu': [[10, 25, 50, 100, 250, 500, "<?php echo $total_invoice; ?>"], [10, 25, 50, 100, 250, 500, "All"]],
            dom: "'<'col-sm-4'l><'col-sm-4 text-center'><'col-sm-4'>Bfrtip",
            buttons: [
                {
                    extend: "copy", exportOptions: { columns: [0, 1, 2, 3, 4, 5] }, className: "btn-sm prints"
                },
                {
                    extend: "csv", title: "Inventory List", exportOptions: { columns: [0, 1, 2, 3, 4, 5] }, className: "btn-sm prints"
                },
                {
                    extend: "excel", exportOptions: { columns: [0, 1, 2, 3, 4, 5] }, title: "Inventory List", className: "btn-sm prints"
                },
                {
                    extend: "pdf", exportOptions: { columns: [0, 1, 2, 3, 4, 5] }, title: "Inventory List", className: "btn-sm prints"
                },
                {
                    extend: "print", exportOptions: { columns: [0, 1, 2, 3, 4, 5] }, title: "Inventory List", className: "btn-sm prints"
                }
            ],
            'serverMethod': 'post',
            'ajax': {
                'url': '<?= base_url() ?>Cinventory/CheckInventoryList',
                "data": function (data) {

                }
            },
            'columns': [
                { data: 'sl' },
                { data: 'product_name' },
                { data: 'product_model' },
                { data: 'batch_id' },
                { data: 'quantity' },
                { data: 'price' }
            ],
            "footerCallback": function (row, data, start, end, display) {

            }
        });
    });
</script>