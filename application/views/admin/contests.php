<div class="content-wrapper">
	<section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Contests
        <a href="<?=base_url('admin/todaycontest')?>" class="btn btn-success">Today's Contest</a>
      </h1>
    </section>
    
	<section class="content">
		<?php 
			if(count($all_contests) == 0)
			{
				echo "<h1>There is no any contests</h1>";
			}
			else{
		?>

		<div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                    <h3 class="box-title">All Contests</h3>
                    <div class="box-tools">
                        <form action="<?php echo base_url() ?>" method="POST" id="searchcontest">
                            <div class="input-group">
                              <!-- <input type="date" name="searchText" value="" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/> -->
                              <input type="text" name="input" placeholder="YYYY-MM-DD" required 
pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))" 
title="Enter a date in this format YYYY-MM-DD" class="form-control input-sm pull-right" style="width: 150px;"/>
                              <div class="input-group-btn">
                                <button class="btn btn-sm btn-default searchList"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Date</th>
                      <th>Prize</th>
                      <th>Owner</th>
                      <th>Own Picture</th>
                      <th class="text-center">View</th>
                    </tr>
                   	<?php
                   		foreach($all_contests as $contest)
                        {
                    ?>
                    		<tr>
                    			<td><?=$contest->contest_date?></td>
                    			<td><?=$contest->prize?></td>
                    			<td><?=$contest->owner?></td>
                    			<td><?=$contest->owner_ticket?></td>
                    			<td><a class="btn btn-sm btn-info" href="<?php echo base_url().'admin/viewcontest'.$contest->id; ?>"><i class="fa fa-pencil"></i></a></td>
                    		</tr>
                    <?php
                        }
                   	?>
                  </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    
                </div>
              </div><!-- /.box -->
            </div>
        </div>

        <?php 
        	}
        ?>
	</section>
</div>
