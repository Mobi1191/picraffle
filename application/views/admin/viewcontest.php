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
	               
	                	<input type="hidden" name="contest_id" value="<?=$contest->contest_id?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Contest Prize</label>
                                        <input type="number" class="form-control" id="prize" placeholder="Enter Prize" name="prize" value="<?=$contest->prize?>" maxlength="10" min="0" disabled>
                                        
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="fname">Price for One Ticket</label>
                                        <input type="number" class="form-control" id="price_for_one_ticket" placeholder="Enter Price One Ticket" name="price_one_ticket" value="<?=$contest->price_one_ticket?>" maxlength="10" min="0" disabled>
                                        
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

            <div class="col-md-4">
                
                <?php
                    if(count($owned_ticket)>0)
                    {
                ?>
                 <div style="margin: 20px; border: solid 2px #aaa;border-radius: 5px;padding: 10px;">
                    <img src="<?=base_url()?>assets/uploads/<?=$owned_ticket[0]->image_name?>" style="border-radius: 3px; width: 100%;">
                    <p style="text-align: center;margin-top: 10px;font-size: 20px;">Owner Name : <?=$owned_ticket[0]->name?></p>
                
                </div>
                <?php
                    }
                ?>
            </div>

        </div>

        <div class="row">
            <div class="row" style="margin: 20px; border:solid 2px #aaa;border-radius: 5px; ">
                <?php
                    if(count($all_tickets) == 0)
                    {
                        ?>
                            <h1>There is no any ticket.</h1>
                        <?php
                    }
                    else{
                        foreach ($all_tickets as $ticket) {
                            ?>
                                <div class="col-md-3">
                                    <div style="margin: 10px;padding: 10px; border: solid 1px #ccc; background: white;border-radius: 5px;">
                                        <img src="<?=base_url()?>assets/uploads/<?=$ticket->image_name?>" style="width: 100%; border-radius: 5px;">
                                        <div style="text-align: center; margin-top: 10px;">
                                            <p>Customer : <?=$ticket->name?></p>
                                            <a href="<?=base_url()?>assets/uploads/<?=$ticket->image_name?>" class="btn btn-primary">View</a>

                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                ?>
            </div>
    </section>
</div>