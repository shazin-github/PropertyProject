<?php
   var_dump($data['userInfo']);
?>
<style>
   .col-md-3, h5{ font-weight: bold;} h5{color: #D00; text-align: center}
</style>

<div class="row">
   <div class="col-md-8 col-md-offset-2">
      <div class="box box-solid">
         <div class="box-header with-border"><h3 class="box-title">User Info</h3></div>
         <div class="box-body">
            <div class="row">
               <div class="col-md-3">User ID</div>
               <div class="col-md-9">'+data.user_id+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Seller ID</div>
               <div class="col-md-4">
                  <input type="text" value="'+data.seller_id+'" id="user_seller_id" class="form-control"/>
               </div>
               <div class="col-md-2">
                  <input type="button" onclick="Users.changeSellerId('+data.user_id+')" value="Save" class="btn btn-xs btn-danger" />
               </div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Active Listings</div>
               <div class="col-md-9">'+active_listings+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Listing req. Push</div>
               <div class="col-md-9">pending</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">User Name</div>
               <div class="col-md-9">'+data.user_name+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">User Email</div>
               <div class="col-md-9">'+data.user_email+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Password</div>
               <div class="col-md-4">
                  <input type="text" value="'+data.user_pass+'" id="user_password" class="form-control" />
               </div>
               <div class="col-md-2">
                  <input type="button" onclick="Users.changePassword('+data.user_id+')" value="Save" class="btn btn-xs btn-danger" />
               </div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Phone #</div>
               <div class="col-md-9">'+data.phone_num+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Broker Key</div>
               <div class="col-md-9">'+data.mongo[0].api_key+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">V2 Internal Link</div>
               <div class="col-md-9">'+data.internal_link+'</div>
            </div>

            <div class="row">
               <div class="col-md-3">V3 Internal Link</div>
               <div class="col-md-9">'+data.v3_internal_link+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">External Link</div>
               <div class="col-md-9">'+data.external_link+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Download Date</div>
               <div class="col-md-9">'+data.download_date+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Product Name</div>
               <div class="col-md-9">'+data.mongo[0].product_name+'</div>
            </div>

            <div class="row">
               <div class="col-md-3">Plan Type</div>
               <div class="col-md-4">'+options+'</div>
               <div class="col-md-2">
                  <input type="button" onclick="Users.changePlan('+data.user_id+')" value="Save" class="btn btn-xs btn-danger" />
               </div>
            </div>
            
            <div class="row">
               <div class="col-md-12"><h5>StubHub Info</h5></div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Stubhub Email</div>
               <div class="col-md-9">'+data.mongo[0].stubhub_details.email+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Stubhub Password</div>
               <div class="col-md-9">'+data.mongo[0].stubhub_details.password+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Consumer Key</div>
               <div class="col-md-9">'+data.mongo[0].stubhub_details["consumer-key"]+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Consumer Secrete</div>
               <div class="col-md-9">'+data.mongo[0].stubhub_details["consumer-secret"]+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-12"><h5>SQL Details</h5></div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Server Name</div>
               <div class="col-md-9">'+data.mongo[0].sql_db_details.server_name+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Database Name</div>
               <div class="col-md-9">'+data.mongo[0].sql_db_details.database_name+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Database User</div>
               <div class="col-md-9">'+data.mongo[0].sql_db_details.database_user+'</div>
            </div>
            
            <div class="row">
               <div class="col-md-3">Database Password</div>
               <div class="col-md-9">'+data.mongo[0].sql_db_details.database_password+'</div>
            </div>
         </div> <!-- box-body -->
      </div> <!-- box -->
   </div> <!-- col-md-8 -->
</div> <!-- row -->