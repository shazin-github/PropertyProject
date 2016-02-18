<div class="row">
   <div class="col-md-6 col-md-offset-3">
      <div class="box box-solid">
         <div class="box-header with-border">
            <h3 class="box-title">Add POS User</h3>
         </div><!-- /.box-header -->

         <div class="box-body">
            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="user_email">Select User</label>
                     <select class="form-control" id="user_email" name="user_email" onchange="Users.populatePosUser()">
                        <option value="">Select User</option>
                     </select>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                  <label for="broker_key">Broker key</label>
                  <input type="text" class="form-control" id="broker_key" name="broker_key" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                  </div>
               </div>
               
               <div class="col-lg-6">
                  <div class="form-group">
                  <label for="listing_capacity">Listing Capacity</label>
                  <input type="text" class="form-control" id="listing_capacity" name="listing_capacity" placeholder="10000">
                  </div>
               </div>
            </div>
            
            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="product_name">Product Name</label>
                     <select class="form-control" id="product_name" name="product_name" onchange="Users.showPosDetails()">
                        <option value="">Select Product</option>
                     </select>
                  </div>
               </div>
            </div>
            
            <!-- stubhub_details -->
            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="stubhub_email">Stubhub Email</label>
                     <input type="email" class="form-control" id="stubhub_email" name="stubhub_email" placeholder="nicky@ticketnetwork.com">
                  </div>
               </div>
            
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="stubhub_password">Stubhub Password</label>
                     <input type="text" class="form-control" id="stubhub_password" name="stubhub_password" placeholder="•••••••••••••••">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="sh_consumer_key">Consumer Key</label>
                     <input type="text" class="form-control" id="sh_consumer_key" name="sh_consumer_key" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxx">
                  </div>
               </div>

               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="sh_consumer_secret">Consumer Secret</label>
                     <input type="text" class="form-control" id="sh_consumer_secret" name="sh_consumer_secret" placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                  </div>
               </div>
            </div>
            
            <!-- SQL details -->
            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="sql_server_name">SQL Server Name</label>
                     <input type="text" class="form-control" id="sql_server_name" name="sql_server_name" placeholder="SAT-SQL.ABCD.internal">
                  </div>
               </div>

               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="sql_database_name">Database name</label>
                     <input type="text" class="form-control" id="sql_database_name" name="sql_database_name" placeholder="mydbname">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="sql_db_user">Database User</label>
                     <input type="text" class="form-control" id="sql_db_user" name="sql_db_user" placeholder="root">
                  </div>
               </div>
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="sql_db_password">Databse Password</label>
                     <input type="text" class="form-control" id="sql_db_password" name="sql_db_password" placeholder="•••••••••••••••">
                  </div>
               </div>
            </div>
            
            <!--TU Detail-->
            <div class="row" id="pos_details" style="display: none">
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="pos_api_key" id="label_pos_api_key"></label>
                     <input type="text" class="form-control" id="pos_api_key" name="pos_api_key" placeholder="xxxxxxxxxxxxxxxxxxx">
                  </div>
               </div>
               
               <div class="col-lg-6">
                  <div class="form-group">
                     <label for="pos_secret" id="label_secret"></label>
                     <input type="text" class="form-control" id="pos_secret" name="pos_secret" placeholder="xxxxxxxxxxxxxxxxxxx">
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-lg-12 pull-right">
                  <div class="form-group">
                     <input type="button" value="Save" class="btn btn-danger" onclick="Users.savePosUser()" />
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