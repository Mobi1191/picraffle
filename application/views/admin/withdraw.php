<div class="content-wrapper">
	<section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> WithDraw
      </h1>
    </section>
	<section class="content">
		<?php var_dump($withdraws);?>

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
	                       	<a class="btn btn-info">Pay Out</a>
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