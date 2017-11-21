<div class="content-wrapper">
	<section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Notifications
        <a href="#" " class="btn btn-success" data-toggle="modal" data-target="#myModal">New Notification</a>
      </h1>
    </section>
    
	<section class="content">
		<div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>Date</th>
                      <th>Content</th>
                      <th>Type</th>
                      <th>Actions</th>
                    </tr>

                    <?php
                    
                      foreach($notifications as $notification)
                        {
                    ?>
                        <tr>
                          <td><?=$notification['noti_date']?></td>
                          <td class="noti_content_<?=$notification['noti_id']?>"><?=$notification['noti_content']?></td>
                          <td><?=$notification['noti_type']?></td>
                          <td>
                            <button <?php if($notification['noti_type'] != "other"){echo "disabled";}?> data-noti-id="<?=$notification['noti_id']?>" class="edit_noti_btn btn-success" data-toggle="modal" data-target="#editModal">Edit</button>
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


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?=base_url()?>admin/send_notification" method="post">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Notification</h4>
        </div>
        <div class="modal-body">
           <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" id="comment" required="" name="noti_content"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" >Send</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="<?=base_url()?>admin/edit_notification" method="post">
        <input type="hidden" name="noti_id" id="noti_id_hidden">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Notification</h4>
        </div>
        <div class="modal-body">
           <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" id="edit_noti_txt" required="" name="noti_content"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" >Send</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>

<script type="text/javascript">
  $(".edit_noti_btn").click(function(){
    var noti_id = $(this).data('noti-id');
    var noti_content = $(".noti_content_"+noti_id).html();
    $("#edit_noti_txt").val(noti_content);
    $("#noti_id_hidden").val(noti_id);
  });
</script>