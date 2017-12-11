<div class="content-wrapper">
	<section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> WithDraw
      </h1>
    </section>
	<section class="content">
		
			<?php
	            $this->load->helper('form');
	            $error = $this->session->flashdata('error');
	            if($error)
	            {
	        ?>
	        <div class="alert alert-danger alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <?php echo $this->session->flashdata('error'); ?>                    
	        </div>
	        <?php } ?>
	        <?php  
	            $success = $this->session->flashdata('success');
	            if($success)
	            {
	        ?>
	        <div class="alert alert-success alert-dismissable">
	            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
	            <?php echo $this->session->flashdata('success'); ?>
	        </div>
	        <?php } ?>


		<div class="row">
	      <div class="col-xs-12">
	        <div class="box">
	          <div class="box-body table-responsive no-padding">
	              <table class="table table-hover">
	                <tr>
	                  <th>User Name</th>
	                  <th>Paypal Email</th>
	                  <th>Amount</th>
	                  <th>Actions</th>
	                </tr>

	                <?php
	                
	                  foreach($withdraws as $withdraw)
	                    {
	                ?>
	                    <tr>
	                      <td><?=$withdraw['name']?></td>
	                      <td><?=$withdraw['withdraw_email']?></td>
	                      <td>$<?=$withdraw['withdraw_amount']?></td>
	                      <td>
	                       	<a class="btn btn-info" href="/admin/payout/<?=$withdraw['withdraw_id']?>">Pay Out</a>
	                      </td>
	                      
	                    </tr>
	                <?php
	                    }
	                ?>
	              </table>
	                  
	          </div><!-- /.box-body -->
	        </div>
	      </div>
	    </div>

	</section>
</div>