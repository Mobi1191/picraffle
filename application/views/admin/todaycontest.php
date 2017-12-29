<div class="content-wrapper">
	<section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i>Today's Contests
        <small><?=date('Y-m-d')?></small>
        <a href="<?=base_url('admin/contests')?>" class="btn btn-success">All Contests</a>
        <div id="countdown"></div>
      </h1>
    </section>
    
	<section class="content">
		<div class="row">
        	<div class="col-md-8">
        		<div class="box box-primary">
	                <div class="box-header">
	                    <h3 class="box-title">Enter Today's Details</h3>
	                </div><!-- /.box-header -->
	                <!-- form start -->
	                <form role="form" action="<?php echo base_url('admin/editcontest') ?>" method="post" id="editUser" role="form">
	                	<input type="hidden" name="contest_id" value="<?=$today_contest->contest_id?>">
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Contest Duration</label>
                                        <input type="text" name="duration" id="contest_duration" value="<?=$today_contest->duration?>">
                                       
                                        <h1>
                                            <?php
                                                $till_time =strtotime($today_contest->duration);
                                                $t_hours = date('H', $till_time);
                                                $t_mins = date('i', $till_time);
                                                $t_secs = date('s', $till_time);
                                                $t_seconds = $t_hours*3600+$t_mins*60+$t_secs;

                                                $c_hours = date('H');
                                                $c_mins = date('i');
                                                $c_secs = date('s');
                                                $c_seconds = $c_hours*3600+$c_mins*60+$c_secs;

                                                $gap_seconds = $t_seconds-$c_seconds;
                                            ?>
                                        </h1>
                                    </div>
                                    
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-12">                                
                                    <div class="form-group">
                                        <label for="fname">Today's Prize</label>
                                        <input type="number" class="form-control" id="prize" placeholder="Enter Prize" name="prize" value="<?=$today_contest->prize?>" maxlength="10" min="0">
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="row">
                            	<h2 style="padding-left: 15px;">Tickets Prices</h2>
                            	
                                <div class="col-md-3">                                
                                    <div class="form-group">
                                        <label for="fname">1 Ticket</label>
                                        <input type="number" class="form-control" id="price_for_one_ticket" placeholder="Enter Price One Ticket" name="price_one_ticket" value="<?=$today_contest->price_one_ticket?>" maxlength="10" min="0">
                                        
                                    </div>
                                    
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mobile">5 Tickets</label>
                                        <input type="number" class="form-control" id="30_tickets_price" placeholder="30 Tickets Price" name="30_tickets_price" value="<?=$today_contest->t30_tickets_price?>" maxlength="10">
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mobile">10 Tickets</label>
                                        <input type="number" class="form-control" id="70_tickets_price" placeholder="70 Tickets Price" name="70_tickets_price" value="<?=$today_contest->t70_tickets_price?>" maxlength="10">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mobile">20 Tickets</label>
                                        <input type="number" class="form-control" id="120_tickets_price" placeholder="120 Tickets Price" name="120_tickets_price" value="<?=$today_contest->t120_tickets_price?>" maxlength="10">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="mobile">50 Tickets</label>
                                        <input type="number" class="form-control" id="200_tickets_price" placeholder="250 Tickets Price" name="200_tickets_price" value="<?=$today_contest->t200_tickets_price?>" maxlength="10">
                                    </div>
                                </div>

                            </div>
                        </div><!-- /.box-body -->
    
                        <div class="box-footer">
                            <input type="submit" class="btn btn-primary" value="Submit" />
                            <input type="reset" class="btn btn-default" value="Reset" />
                        </div>
                    </form>

	            </div>
        	</div>

        	<div class="col-md-4">


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
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>

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
                    if(count($all_todays_tickets) == 0)
                    {
                        ?>
                            <h1>There is no yet today's tickets.</h1>
                        <?php
                    }
                    else{
                       
                        foreach ($all_todays_tickets as $ticket) {
                            ?>
                                <div class="col-md-3">
                                    <div style="margin: 10px;padding: 10px; border: solid 1px #ccc; background: white;border-radius: 5px;">
                                        <img src="<?=base_url()?>assets/uploads/<?=$ticket->image_name?>" style="width: 100%; border-radius: 5px;">
                                        <div style="text-align: center; margin-top: 10px;">
                                            <p>Customer : <?=$ticket->name?></p>
                                            <a href="<?=base_url()?>assets/uploads/<?=$ticket->image_name?>" class="btn btn-primary">View</a>
                                            <a  href="#" data-toggle="modal" data-target="#myModal" data-src="<?=base_url()?>admin/own/<?=$ticket->ticket_id?>/<?=$ticket->user_id?>/<?=$ticket->contest_id?>" class="btn btn-success pic_ticket">Own</a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
       <!--  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
<form method="post" action="" id="own-form">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Do you Want to pic this Image</h4>
      </div>
      <div class="modal-body">
        <p>If you so , Please Click Ok, else cancel.</p>
        <textarea class="form-control" name="notification"></textarea>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-danger" id="pic_ok_btn">Ok</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
</form>
  </div>
</div>
	</section>
</div>

<script type="text/javascript">
    
    $(".pic_ticket").click(function(){
        var src = $(this).data('src');
        //$("#pic_ok_btn").attr('href', src);
        $("#own-form").attr('action', src);
    });

    $("#contest_duration").timepicker({
        timeFormat: 'HH:mm:ss'
    });


    var clock = $('#countdown').FlipClock({
        clockFace: 'HourlyCounter',
        autoStart: false,
        callbacks: {
            stop: function() {
               
            }
        }
    });
                    
    clock.setTime(<?=$gap_seconds?>);
    clock.setCountdown(true);
    clock.start();
</script>
