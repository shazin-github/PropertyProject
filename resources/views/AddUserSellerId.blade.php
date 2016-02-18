<div class="row">
   <div class="col-md-4 col-md-offset-4">
      <div class="box box-solid">
         <div class="box-header with-border">
            <h3 class="box-title">Add Seller ID</h3>
         </div><!-- /.box-header -->

         <div class="box-body">
            <div class="row">
               <div class="col-lg-12">
                  <div class="form-group">
                     <label for="user_email">Select User</label>
                     <select class="form-control" id="user_email" name="user_email" onchange="Users.populateUserSellerId()">
                        <option value="">Select User</option>
                     </select>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-lg-12">
                  <div class="form-group">
                  <label for="seller_id">Seller ID</label>
                  <input type="text" class="form-control" id="seller_id" name="seller_id">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-lg-12 pull-right">
                  <div class="form-group">
                     <input type="button" value="Save" class="btn btn-danger" onclick="Users.saveUserSellerId()" />
                  </div>
               </div>
            </div>

         </div><!-- /.box-body -->
      </div><!-- /.box -->
   </div>
</div>

<div id="UserInfo" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header" style="padding: 10px;">
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            <h4 class="modal-title">User Info</h4>
         </div>
         <div class="modal-body">
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>