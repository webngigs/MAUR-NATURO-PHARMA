<!-- gift details Start -->
<div class="content-wrapper">
	<section class="content-header">
	    <div class="header-icon">
	        <i class="pe-7s-note2"></i>
	    </div>
	    <div class="header-title">
	        <h1><?php echo display('gift_details') ?></h1>
	        <small><?php echo display('manage_gift_details') ?></small>
	        <ol class="breadcrumb">
	            <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
	            <li><a href="#"><?php echo display('gift') ?></a></li>
	            <li class="active"><?php echo display('gift_details') ?></li>
	        </ol>
	    </div>
	</section>
	<!-- gift information -->
	<section class="content"><?php
		$message = $this->session->userdata('message');
		if(isset($message)) {
			?><div class="alert alert-info alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $message ?>
			</div><?php
	        $this->session->unset_userdata('message');
	    }
		$error_message = $this->session->userdata('error_message');
		if(isset($error_message)) {
	    	?><div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<?php echo $error_message ?>
			</div><?php
	        $this->session->unset_userdata('error_message');
	    }	    
		?><div class="row">
            <div class="col-sm-12">
                <div class="column">
                  <a href="<?php echo base_url('Cgift')?>" class="btn btn-success m-b-5 m-r-2"><i class="ti-plus"> </i> <?php echo display('add_gift')?> </a>
                  <a href="<?php echo base_url('Cgift/manage_gift')?>" class="btn btn-info m-b-5 m-r-2"><i class="ti-align-justify"> </i> <?php echo display('manage_gift')?> </a>
                </div>
            </div>
        </div>
		<div class="row">
		    <div class="col-sm-12">
		        <div class="panel panel-bd lobidrag">
		            <div class="panel-heading">
		                <div class="panel-title">
		                    <h4><?php echo display('gift_information') ?></h4>
		                </div>
		            </div>
		            <div class="panel-body">
	  					<div style="float:left">
							<h4>{gift_name}</h4>
							
						</div>
		            </div>
		        </div>
		    </div>
		</div>
	</section>
</div>
<!--gift details End  -->