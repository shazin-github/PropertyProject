<div class="row">
      <div class="col-md-12">
         <div class="box box-solid">
            <div class="box-header with-border">
               <div class="row">
                  <div class="col-md-2"><h3 class="box-title">User Details</h3></div>
                  <div class="col-md-2 col-md-offset-8">
                     <input type="button" value="Refresh" class="btn btn-default pull-right" onclick="Users.getUsers(true)" />
                  </div>
               </div>
            </div><!-- /.box-header -->

            <div class="box-body">
               <table id="users" class="table table-bordered  table-responsive table-condensed dataTable">
                  <thead>
                  <tr>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Password</th>
                     <th>Product Name</th>
                     <th>Plan Type</th>
                     <th>T. Listings</th>
                     <th>Active Listings</th>
                     <th>Daily Added</th>
                     <th>Status</th>
                     <th>Experience</th>
                     <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody id="user_detail"></tbody>
               </table>
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