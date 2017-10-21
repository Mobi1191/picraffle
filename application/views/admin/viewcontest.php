<div class="content-wrapper">
	<section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Contest
        <small><?=$contest->contest_date?></small>
        <a href="<?=base_url('admin/todaycontest')?>" class="btn btn-success">Today's Contest</a>
        <a href="<?=base_url('admin/contests')?>" class="btn btn-success">All Contests</a>
      </h1>
    </section>

    <section class="content">
    	<div class="row">
        	<div class="col-md-8">
        		<div class="box box-primary">
	                <div class="box-header">
	                    <h3 class="box-title">Contest Details</h3>
	                </div><!-- /.box-header -->
	                <!-- form start -->
	               
	                	<input type="hidden" name="contest_id" value="<?=$contest->id?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Contest Prize</label>
                                        <input type="number" class="form-control" id="prize" placeholder="Enter Prize" name="prize" value="<?=$contest->prize?>" maxlength="10" min="0" disabled>
                                        
                                    </div>
                                    
                                </div>
                               
                            </div>
                            
                            <div class="row">
                            	<h2 style="padding-left: 15px;">Tickets Prices</h2>
                            	
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mobile">30 Tickets</label>
                                        <input type="number" class="form-control" id="30_tickets_price" placeholder="30 Tickets Price" name="30_tickets_price" value="<?=$contest->t30_tickets_price?>" maxlength="10" disabled>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mobile">70 Tickets</label>
                                        <input type="number" class="form-control" id="70_tickets_price" placeholder="70 Tickets Price" name="70_tickets_price" value="<?=$contest->t70_tickets_price?>" maxlength="10" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mobile">120 Tickets</label>
                                        <input type="number" class="form-control" id="120_tickets_price" placeholder="120 Tickets Price" name="120_tickets_price" value="<?=$contest->t120_tickets_price?>" maxlength="10" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mobile">200 Tickets</label>
                                        <input type="number" class="form-control" id="200_tickets_price" placeholder="250 Tickets Price" name="200_tickets_price" value="<?=$contest->t200_tickets_price?>" maxlength="10" disabled>
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.box-body -->
    
                        
                    </form>
	            </div>
        	</div>

        	

        </div>
    </section>
</div>