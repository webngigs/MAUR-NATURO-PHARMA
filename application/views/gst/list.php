<style type="text/css">
    .prints{ background-color:#31B404; color:#fff; }
    .action{ color:#fff; }
    .dropdown-menu>li>a{ color:#fff; }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon"><i class="pe-7s-note2"></i></div>
        <div class="header-title">
            <h1><?php echo 'GST Report'; ?></h1>
            <small><?php echo 'Download GST Report' ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo 'GST Report'; ?></a></li>
            </ol>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo 'Search GST Report Data'; ?> </h4>
                        </div>
                    </div>
                    <div class="panel-body text-center"><?php 
                    echo form_open('Cgst/downloadgst', array('class' => 'form-inline', 'method' => 'post'))
                        ?><div class="form-group">
                            <label class="" for="from_date"><?php echo display('start_date') ?></label>
                            <input type="text" name="from_date" class="form-control datepicker" readonly id="from_date" value="<?php echo date('Y-m-d'); ?>" placeholder="<?php echo display('start_date') ?>" >
                        </div>
                        <div class="form-group">
                            <label class="" for="to_date"><?php echo display('end_date') ?></label>
                            <input type="text" name="to_date" class="form-control datepicker" readonly id="to_date" placeholder="<?php echo display('end_date') ?>" value="<?php echo date('Y-m-d'); ?>">
                        </div> 
                        <button type="submit" id="DownloadGSTRIIBtn" class="btn btn-success"> Download GSTRII </button><?php 
                    echo form_close() 
                    ?></div>
                </div>
            </div>
        </div>
    </section>
</div>