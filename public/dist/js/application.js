var Util = [], Events = [], Users = [], doc = $(document), win = $(win), body = $("body");

Util.StartWait = function() {
   $("#overlay").show();
}

Util.StopWait = function() {
   $("#overlay").hide();
}

Util.successMsg = function(msg){
   $.notify({
     type: "success",
     message: msg
   });
};

Util.errorMsg = function(msg){
   $.notify({
     type: "error",
     message: msg
   });
};
Util.Post = 
   function(url, input, success, error){
      Util.StartWait();
      $.ajax({ 
         type: 'post',
         headers: {'Broker-key': 'd63c6883bf3fc97a8da96384a514dac0' },
         url: url,
         dataType: 'json',
         data: input,
         success: function(data){
            Util.StopWait();
            if(typeof success === "undefined"){
               $.notify({
                 type: "success",
                 message: "Action performed Successfully!"
               });
            } else{
               success(data);
            }
         },
         error: function(data){
            Util.StopWait();
            if(typeof error === "undefined"){
               $.notify({
                 type: "error",
                 message: "Some Error has occured!"
               });
            } else{
               error(data);
            }
         }
      });
      return false;
   }

Util.Get = 
   function(url, input, success, error){
      Util.StartWait();
      $.ajax({ 
         type: 'get',
         url: url,
         headers: {'Broker-key': 'd63c6883bf3fc97a8da96384a514dac0' },
         dataType: 'json',
         data: input,
         success: function(data){
            Util.StopWait();
            if(typeof success === "undefined"){
               $.notify({
                 type: "success",
                 message: "Action performed Successfully!"
               });
            } else{
               success(data);
            }
         },
         error: function(data){
            Util.StopWait();
            if(typeof error === "undefined"){
               $.notify({
                 type: "error",
                 message: "Some Error has occured!"
               });
            } else{
               error(data);
            }
         }
      });
      return false;
   };

Util.syncGet = 
   function(url, input, success, error){
      Util.StartWait();
      $.ajax({ 
         type: 'get',
         url: url,
         async: false,
         headers: {'Broker-key': 'd63c6883bf3fc97a8da96384a514dac0' },
         dataType: 'json',
         data: input,
         success: function(data){
            Util.StopWait();
            if(typeof success === "undefined"){
               $.notify({
                 type: "success",
                 message: "Action performed Successfully!"
               });
            } else{
               success(data);
            }
         },
         error: function(data){
            Util.StopWait();
            if(typeof error === "undefined"){
               $.notify({
                 type: "error",
                 message: "Some Error has occured!"
               });
            } else{
               error(data);
            }
         }
      });
      return false;
   };

Util.Put = 
   function(url, input, success, error){
      Util.StartWait();
      $.ajax({ 
         type: 'put',
         url: url,
         headers: {'Broker-key': 'd63c6883bf3fc97a8da96384a514dac0' },
         dataType: 'json',
         data: input,
         success: function(data){
            Util.StopWait();
            if(typeof success === "undefined"){
               $.notify({
                 type: "success",
                 message: "Action performed Successfully!"
               });
            } else{
               success(data);
            }
         },
         error: function(data){
            Util.StopWait();
            if(typeof error === "undefined"){
               $.notify({
                 type: "error",
                 message: "Some Error has occured!"
               });
            } else{
               error(data);
            }
         }
      });
      return false;
   }   

   Events.getExchangeEvents = function() {
      url = 'v1/exchange/1/not_mapped?approve_status=' + 0;
      content = "";
      Util.Get(
         url, null,
         function(data){
            if(data.success) {
               Events.Data = data.success
               for(i in Events.Data) {
                  content += "<tr>";
                  content += "<td id='event_exchange"+i+"'><label data-toggle='tooltip' title='Double click to Edit' ondblclick='Events.inlineExchangeEventID("+i+")'>"+Events.Data[i].exchange_event_id+"</label></td>";
                  content += "<td>"+Events.Data[i].event_name+"</td>";
                  content += "<td>"+Events.Data[i].event_date+"</td>";
                  content += "<td>"+Events.Data[i].event_time+"</td>";
                  content += "<td>"+Events.Data[i].event_timestamp+"</td>";
                  content += "<td>"+Events.Data[i].venue_name+"</td>";
                  content += "<td>"+Events.Data[i].local_event_id+"</td>";
                  content += "<td>"+Events.Data[i].source+"</td>";
                  content += "<td>"+Events.Data[i].exchange_id+"</td>";
                  content += "<td>"+Events.Data[i].user+"</td>";
                  content += "<td><input type='button' class='btn btn-sm btn-danger' value='Approve' onclick='Events.confirmApproveEvent("+i+")'</td>";
                  content += "</tr>";
               }
               $("#events").html(content);
               $(".dataTable").DataTable();
            }//if
         }
      );
   };

   Events.confirmApproveEvent = function(id){
      str = '<button type="button" onclick="Events.approveEvent('+id+')"class="btn btn-danger" data-dismiss="modal">Yes</button>';
      str += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
      $("#confirmEventMapping .modal-footer").html(str);
      $("#confirmEventMapping").modal('show');
   }

   Events.inlineExchangeEventID = function (id) {
      content = '<input type="text" value="'+Events.Data[id].exchange_event_id+'" id="eventID" /><input type="button" class="btn btn-xs btn-danger" onclick="Events.updateExchangeEventID('+id+')" value="ok" />&nbsp;<input type="button" class="btn btn-xs btn-warning" onclick="Events.cancelExchangeEventID('+id+')" value="cancel" />';
      $("#event_exchange"+id).html(content);
   };

   Events.updateExchangeEventID = function (id) {
      var new_event_id = $("#eventID").val();
      var mongo_id = Events.Data[id]._id.$id;
      var url = 'v1/exchange/1/event/update_id?_id=' + mongo_id +'&exchange_event_id=' + new_event_id;
      Util.Get(url, null,
         function(data) {
            if(data.success) {
               Events.Data[id].exchange_event_id = new_event_id;
               var label = "<label data-toggle='tooltip' title='Double click to Edit' onclick='Events.inlineExchangeEventID("+id+")'>"+new_event_id+"</label>";
               $("#event_exchange"+id).html(label);
            }
         }, function(){}
      );
   };

   Events.cancelExchangeEventID = function(id){
      label = "<label data-toggle='tooltip' title='Double click to Edit' onclick='Events.inlineExchangeEventID("+id+")'>"+Events.Data[id].exchange_event_id+"</label>";
      $("#event_exchange"+id).html(label);
   };

   Events.approveEvent = function(id){
      mongo_id = Events.Data[id]._id.$id;
      url = 'v1/exchange/1/event/update_status?_id=' + mongo_id +'&approve_status=1';
      Util.Get(url, null,
         function (data) {
            if(data.success) 
               Events.getExchangeEvents();
         }, function(){}

      );
   };

   /*---------------------------------------------------------------------------------------------
    * U S E R S
    *---------------------------------------------------------------------------------------------*/
    Users.PrepareDataTable = function(){
      Users.StatsDT =
      $('#UsersStatsTable').DataTable( {
         "processing": true,
         "serverSide": true,
         "ajax": "adminpanel/stats",
         "searching": false,
         dom: "frtiS",
         scrollY: 200,
         deferRender: true,
         scroller: {
            loadingIndicator: true
         }
      });
   }

Users.getUsers = function(refresh_cache) {
   data = null;
   if(refresh_cache == true){
      data = {refresh_cache : true};
   }
   url = 'v1/users';
   content = "";
   Util.Get(
       url, data,
       function(data){
          if(data.success) {
             Users.Data = data.success
             for(i in Users.Data) {
                if(Users.Data[i].user_status == 0){
                  user_status = "Inactive";
                  btn = "<input type='button' class='btn btn-xs btn-success' onclick='Users.activate("+Users.Data[i].user_id+")' value='Activate'>"; 
                  content += "<tr user_id='"+Users.Data[i].user_id+"' style='background-color: #D00; color: #FFF'>";
                }
                else{
                  user_status = "Active";
                  btn = "<input type='button' class='btn btn-xs btn-danger' onclick='Users.deactivate("+Users.Data[i].user_id+")' value='Deactivate'>"; 
                  content += "<tr user_id='"+Users.Data[i].user_id+"'>";
                }
                
                content += "<td>"+Users.Data[i].user_name+"</td>";
                content += "<td>"+Users.Data[i].user_email+"</td>";
                content += "<td>"+Users.Data[i].user_pass+"</td>";
                content += "<td>"+Users.Data[i].user_product+"</td>";
                content += "<td>"+Users.Data[i].plan_limit+"</td>";
                content += "<td>"+Users.Data[i].total_listings+"</td>";
                content += "<td>"+Users.Data[i].active_listings+"</td>";
                content += "<td>"+Users.Data[i].daily_listings+"</td>";
                content += "<td>"+user_status+"</td>";
                content += "<td>"+Users.Data[i].experience+"</td>";
                content += "<td><input type='button' class='btn btn-xs btn-primary' onclick='Users.getUserInfo("+Users.Data[i].user_id+", $(this))'value='Info'>&nbsp;"
                +btn+"</td>";
                // content += "<td>"+Users.Data[i].phone_num+"</td>";
                // content += "<td>"+Users.Data[i].customer_id+"</td>";
                // content += "<td>"+Users.Data[i].sale_force_link+"</td>";
                // content += "<td>"+Users.Data[i].download_date+"</td>";
                // content += "<td>"+Users.Data[i].app_update_date+"</td>";
                // content += "<td>"+Users.Data[i].internal_link+"</td>";
                // content += "<td>"+Users.Data[i].v3_internal_link+"</td>";
                // content += "<td>"+Users.Data[i].external_link+"</td>";
                content += "</tr>";
             }
             $("#user_detail").html(content);
             $(".dataTable").DataTable();
             $("body").addClass("sidebar-collapse");
          }//if
       }
   );
};
  
  Users.getUserInfo2 = function(id, button){
    win = window.open("adminpanel", "_blank");
    if(win){
      win.focus();
    } else {
      $.notify({
      type: "warning",
      message: "Please allow popups for this site"
      });
    }
    Util.StartWait();
    $(win).load(function() {
      $(win.document).find("#dashboard_content").load('adminpanel/user-info?user_id='+id, function(){
        Util.StopWait();
      });
    });
  };

  Users.getUserInfo = function(id, button){
    active_listings = button.parents("tr").children().eq(6).text();
    url = 'v1/user/info';
    Util.Get(url, 
      {user_id: id}, 
      function(data){
        if(data.success){
          options = '';
          Util.syncGet('v1/plans', {},
            function(plan_data){
              if(plan_data.success){
                $.each(plan_data.success, function(i, val){
                  if(data.success[0].plan_id == val.id){
                    options += '<option value="'+val.id+'" selected>'+val.name+'</option>';
                  } else{
                    options += '<option value="'+val.id+'">'+val.name+'</option>';
                  }
                });
                options = '<select class="form-control" id="user_plan_id">'+options+'</select>';
              }//if
            }, function(){}
          );//v1/plans
          
          ver_select = '<select id="version" class="form-control">'; 
          Util.syncGet('v1/versions', {},
            function(ver_data){
              if(ver_data.success){
                $.each(ver_data.success, function(i, val){
                  if(data.success[0].version == val){
                    ver_select += '<option value="'+val+'" selected>Version '+val+'</option>';
                  } else{
                    ver_select += '<option value="'+val+'">Version '+val+'</option>';
                  }
                });
                ver_select += '</select>';
              }//if
            }, function(){}
          );//v1/versions
          

          data = data.success[0];
          str = '<style>.col-md-3, h5{ font-weight: bold;} h5{color: #D00; text-align: center} .info-box{min-height: 100px;} .info-box-icon{height: 100px;}</style>\
          <div class="row">\
            <div class="col-md-3">\
            <div class="small-box bg-aqua">\
            <div class="inner" id="total_listings"><img src="dist/img/loader.svg" width="47px" height="47px"/><p>Total Listings</p></div>\
            <!-- <div class="icon"><i class="fa fa-shopping-cart"></i></div> -->\
            </div>\
            </div>\
            <div class="col-md-3">\
              <div class="info-box bg-red">\
                <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>\
                <div class="info-box-content">\
                  <span class="info-box-text">Active Listings</span>\
                  <span class="info-box-number" id="active_listings">41,410</span>\
                  <div class="progress"><div class="progress-bar" style="width: 70%"></div></div>\
                  <span class="progress-description"></span>\
                </div><!-- /.info-box-content -->\
              </div><!-- active listings box -->\
            </div><!-- col -->\
            <div class="col-md-3">\
            <div class="small-box bg-yellow">\
            <div class="inner" id="onfloor_listings"><img src="dist/img/loader.svg" width="47px" height="47px"/><p>On Floor Listings</p></div>\
            <!-- <div class="icon"><i class="fa fa-shopping-cart"></i></div> -->\
            </div>\
            </div>\
            <div class="col-md-3">\
            <div class="small-box bg-green">\
            <div class="inner" id="sold_listings"><img src="dist/img/loader.svg" width="47px" height="47px"/><p>Sold Listings</p></div>\
            <!-- <div class="icon"><i class="fa fa-shopping-cart"></i></div> -->\
            </div>\
            </div>\
          </div>\
          <div class="row">\
            <div class="col-md-6">\
              <div class="box box-primary">\
                <div class="box-header with-border"><h3 class="box-title">User Info</h3></div>\
                <div class="box-body">\
                  <div class="row"><div class="col-md-3">User ID</div><div class="col-md-9">'+data.user_id+'</div></div>\
                  <div class="row"><div class="col-md-3">Seller ID</div><div class="col-md-4"><input type="text" value="'+data.seller_id+'" id="user_seller_id" class="form-control"/></div>\
                  <div class="col-md-2"><input type="button" onclick="Users.changeSellerId('+data.user_id+')" value="Save" class="btn btn-danger" /></div></div>\
                  <div class="row"><div class="col-md-3">Active Listings</div><div class="col-md-9">'+active_listings+'</div></div>\
                  <div class="row"><div class="col-md-3">Listing req. Push</div><div class="col-md-9">pending</div></div>\
                  <div class="row"><div class="col-md-3">User Name</div><div class="col-md-9">'+data.user_name+'</div></div>\
                  <div class="row"><div class="col-md-3">User Email</div><div class="col-md-9">'+data.user_email+'</div></div>\
                  <div class="row"><div class="col-md-3">Password</div><div class="col-md-4"><input type="text" value="'+data.user_pass+'" id="user_password" class="form-control" /></div>\
                  <div class="col-md-2"><input type="button" onclick="Users.changePassword('+data.user_id+')" value="Save" class="btn btn-danger" /></div></div>\
                  <div class="row"><div class="col-md-3">Phone #</div><div class="col-md-9">'+data.phone_num+'</div></div>\
                  <div class="row"><div class="col-md-3">Broker Key</div><div class="col-md-9">'+data.mongo[0].api_key+'</div></div>\
                  <div class="row"><div class="col-md-3">V2 Internal Link</div><div class="col-md-9">'+data.internal_link+'</div></div>\
                  <div class="row"><div class="col-md-3">V3 Internal Link</div><div class="col-md-9">'+data.v3_internal_link+'</div></div>\
                  <div class="row"><div class="col-md-3">External Link</div><div class="col-md-9">'+data.external_link+'</div></div>\
                  <div class="row"><div class="col-md-3">Download Date</div><div class="col-md-9">'+data.download_date+'</div></div>\
                  <div class="row"><div class="col-md-3">Product Name</div><div class="col-md-9">'+data.mongo[0].product_name+'</div></div>\
                  <div class="row"><div class="col-md-3">Plan Type</div><div class="col-md-4">'+options+'</div>\
                  <div class="col-md-2"><input type="button" onclick="Users.changePlan('+data.user_id+')" value="Save" class="btn btn-danger" /></div></div>\
                </div> <!-- box-body -->\
              </div><!-- box -->\
            </div><!-- col user-info -->\
            <div class="col-md-6">\
              <div class="box box-warning">\
                <div class="box-header with-border"><h3 class="box-title">StubHub Info</h3></div>\
                <div class="box-body">\
                  <div class="row"><div class="col-md-3">Stubhub Email</div><div class="col-md-9">'+data.mongo[0].stubhub_details.email+'</div></div>\
                  <div class="row"><div class="col-md-3">Stubhub Password</div><div class="col-md-9">'+data.mongo[0].stubhub_details.password+'</div></div>\
                  <div class="row"><div class="col-md-3">Consumer Key</div><div class="col-md-9">'+data.mongo[0].stubhub_details["consumer-key"]+'</div></div>\
                  <div class="row"><div class="col-md-3">Consumer Secrete</div><div class="col-md-9">'+data.mongo[0].stubhub_details["consumer-secret"]+'</div></div>\
                </div> <!-- box-body -->\
              </div><!-- box SH-->\
              <div class="box box-warning">\
                <div class="box-header with-border"><h3 class="box-title">SQL Details</h3></div>\
                <div class="box-body">\
                  <div class="row"><div class="col-md-3">Server Name</div><div class="col-md-9">'+data.mongo[0].sql_db_details.server_name+'</div></div>\
                  <div class="row"><div class="col-md-3">Database Name</div><div class="col-md-9">'+data.mongo[0].sql_db_details.database_name+'</div></div>\
                  <div class="row"><div class="col-md-3">Database User</div><div class="col-md-9">'+data.mongo[0].sql_db_details.database_user+'</div></div>\
                  <div class="row"><div class="col-md-3">Database Password</div><div class="col-md-9">'+data.mongo[0].sql_db_details.database_password+'</div></div>\
                </div> <!-- box-body -->\
              </div><!-- box SQL-->\
              <div class="box box-warning">\
                <div class="box-header with-border"><h3 class="box-title">Version Details</h3></div>\
                <div class="box-body">\
                  <div class="row form-group"><div class="col-md-3">Version</div><div class="col-md-4">'+ver_select+'</div>\
                  <div class="col-md-2"><input type="button" onclick="Users.updateVersion('+data.user_id+')" value="Update" class="btn btn-danger" /></div></div>\
                </div> <!-- box-body -->\
              </div><!-- version SQL-->\
            </div><!-- col -->\
          </div> <!-- row -->';
          // $("#UserInfo .modal-body").html(str);
          // str = '<button class="btn btn-danger" data-dismiss="modal">OK</button>';
          // $("#UserInfo .modal-footer").html(str);
          // $("#UserInfo").modal('show');
          win = window.open("adminpanel", "_blank");
          if(win){
            win.focus();
          }else{
            $.notify({
               type: "warning",
               message: "Please allow popups for this site"
             });
          }
          $(win).load(function() {
            $(win.document).find("#dashboard_content").html(str);

            Util.Get('v1/stat/floor',
              {user_id : data.user_id},
              function(onfloor_list){
                  if(onfloor_list.success)
                     $(win.document).find("#onfloor_listings").html("<h3>"+onfloor_list.success.count+"</h3><p>Listings on floor</p>");
                  else
                     $(win.document).find("#onfloor_listings").html("<h3>0</h3><p>Listings on floor</p>");   
              }, function(error){
                  $(win.document).find("#onfloor_listings").html("<h3>0</h3><p>Listings on floor</p>");
              }
            );

            Util.Get('v1/stat/sold',
              {user_id : data.user_id},
              function(sold_list){
                  if(sold_list.success)
                     $(win.document).find("#sold_listings").html("<h3>"+sold_list.success.count+"</h3><p>Sold Listings</p>");
                  else
                     $(win.document).find("#sold_listings").html("<h3>0</h3><p>Sold Listings</p>");
              }, function(error){
                  $(win.document).find("#sold_listings").html("<h3>0</h3><p>Sold Listings</p>");
              }
            );
            
            Util.Get('v1/stat/user',
               {user_id : data.user_id},
               function(total_list){
                  if(total_list.success){
                     t_lists = total_list.success.save_listing.count;
                     a_lists = total_list.success.active_listing.count;
                     
                     $(win.document).find("#total_listings").html("<h3>"+t_lists+"</h3><p>Total Listings</p>");
                     percentage = (Number(a_lists)/Number(t_lists) )* 100;
                     $(win.document).find("#active_listings").html(a_lists);
                     $(win.document).find(".progress-description").html(percentage+"%");
                     $(win.document).find(".progress-bar").css('width', percentage+'%');
                  } else{
                     $(win.document).find("#active_listings").html("0");
                  }
               }, function(error){
                  $(win.document).find("#total_listings").html("<h3>0</h3><p>Total Listings</p>");
                  $(win.document).find("#active_listings").html("0");
              }
            );
          });
        }//if data.success
      }, function(){}
    );//get v1/user/info
  };

  Users.changePassword = function(user_id){
    password = $("#user_password").val();
    Util.Put('v1/user/update/password', 
        {
          user_id : user_id,
          password : password
        },
        function(data){
          if(data.success){
            $.notify({
               type: "success",
               message: "Password changed successfully!"
           });  
          }
        }
      );
    };

  Users.changePlan = function(user_id){
    plan_id = $("#user_plan_id").val();
    Util.Put('v1/user/update/plan', 
      {
        user_id : user_id,
        plan_id : plan_id
      },
      function(data){
        if(data.success){
          $.notify({
             type: "success",
             message: "Plan changed successfully!"
          });    
        }
      }
    );
  };

  Users.changeSellerId = function(user_id){
    seller_id = $("#user_seller_id").val();
    Util.Put('v1/user/update/seller_id', 
      {
        user_id : user_id,
        seller_id: seller_id
      },
      function(data){
        if(data.success){
          $.notify({
             type: "success",
             message: "Seller ID changed successfully!"
         });
        }
      }
    );
  };

  Users.changeProductName = function(user_id){
    product_name = $("#user_product_name").val();
    Util.Put('v1/user/update/productname', 
      {
        user_id : user_id,
        product_name : product_name
      },
      function(data){
        if(data.success){
          $.notify({
             type: "success",
             message: "Product changed successfully!"
         });    
        }
      }
    );
  };

  Users.changeVersion = function(user_id){
    user_product_version = $("#user_product_version").val();
    Util.Put('v1/user/update/version', 
      {
        user_id : user_id,
        version : user_product_version
      },
      function(data){
        if(data.success){
          $.notify({
             type: "success",
             message: "Version updated successfully!"
         });    
        }
      }
    );
  };

Users.prepareAddPosUser = function(){
   url = 'v1/users';
   Util.Get(
      url, null,
      function(data){
         if(data.success) {
            $.each(data.success, function (i, u) {
               $('#user_email').append($('<option>', { 
                  value: u.user_id,
                  text : u.user_email
               }));
            });//each
         }//if

         url = 'v1/products';
         Util.Get(
            url, null,
            function(data){
               if(data.success) {
                  $.each(data.success, function (i, product_name) {
                     $('#product_name').append($('<option>', { 
                        value: product_name,
                        text : product_name
                     }));
                  });//each
               }
            }
         );//get products
      }
   );//get users
};

Users.prepareAddUserSellerId = function(){
   url = 'v1/users';
   Util.Get(
      url, null,
      function(data){
         if(data.success) {
            $.each(data.success, function (i, u) {
               $('#user_email').append($('<option>', { 
                  value: u.user_id,
                  text : u.user_email
               }));
            });//each
         }//if
      }
   );//get users
};
Users.showPosDetails = function(){
   product_name = $("#product_name").val();
   switch(product_name.split("-")[1]){
      case "tu": {
         label_api_key = 'TU API Key';
         label_secret = 'TU API Secret'

         $("#label_pos_api_key").html(label_api_key);
         $("#label_secret").html(label_secret);
         $("#pos_details").show();
      } break;

      case "vs": {
         label_api_key = 'VS API Key';
         label_secret = 'VS Account ID'

         $("#label_pos_api_key").html(label_api_key);
         $("#label_secret").html(label_secret);
         $("#pos_details").show();
      } break;
      
      default: {
         $("#pos_details").hide();
      }
   }
};

Users.populatePosUser = function(){
   user_id = $("#user_email").val();
   url = 'v1/user/info';
   Util.Get(url, 
      {user_id: user_id}, 
      function(data){
         if(data.success){
            data = data.success[0];
            $("#broker_key").val(data.mongo[0].api_key);
            $("#listing_capacity").val(data.mongo[0].listing_capacity);
            $("#product_name").val(data.mongo[0].product_name);
            $("#stubhub_email").val(data.mongo[0].stubhub_details["email"]);
            $("#stubhub_password").val(data.mongo[0].stubhub_details["password"]);
            $("#sh_consumer_key").val(data.mongo[0].stubhub_details["consumer-key"]);
            $("#sh_consumer_secret").val(data.mongo[0].stubhub_details["consumer-key"]);
            $("#sql_server_name").val(data.mongo[0].sql_db_details.server_name);
            $("#sql_database_name").val(data.mongo[0].sql_db_details.database_name);
            $("#sql_db_user").val(data.mongo[0].sql_db_details.database_user);
            $("#sql_db_password").val(data.mongo[0].sql_db_details.database_password);
            if(data.mongo[0].product_name.split('-')[1] == 'tu'){
               label_api_key = 'TU API Key';
               label_secret = 'TU API Secret'
               $("#label_pos_api_key").html(label_api_key);
               $("#label_secret").html(label_secret);
               $("#pos_details").show();
               $("#pos_api_key").val(data.mongo[0].tu_api_token);
               $("#pos_secret").val(data.mongo[0].tu_sec);
            } else if(data.mongo[0].product_name.split('-')[1] == 'vs'){
               label_api_key = 'VS API Key';
               label_secret = 'VS Account ID'
               $("#label_pos_api_key").html(label_api_key);
               $("#label_secret").html(label_secret);
               $("#pos_api_key").val(data.mongo[0].vivid_api);
               $("#pos_secret").val('pending');
               $("#pos_details").show();
            } else{
               $("#pos_details").hide();
            }
         }//if
      }//success 
   );//get user/info
};

Users.activate = function(id){
   Util.Put('v1/user/activate',
      {user_id: id},
      function(data){
         if(data.success){
            $('tr[user_id='+id+']').css('background-color', '#FFF');
            $('tr[user_id='+id+']').css('color', '#000');
            $('table#users tr[user_id='+id+'] td input[type="button"][value="Activate"]').attr('class', 'btn btn-xs btn-danger');
            $('table#users tr[user_id='+id+'] td input[type="button"][value="Activate"]').attr('value', 'Deactivate');
            Util.successMsg("User Activated Successfully");
         }
      }
   );
};

Users.deactivate = function(id){
   Util.Put('v1/user/deactivate',
      {user_id: id},
      function(data){
         if(data.success){
            $('tr[user_id='+id+']').css('background-color', '#D00');
            $('tr[user_id='+id+']').css('color', '#FFF');
            $('table#users tr[user_id='+id+'] td input[type="button"][value="Deactivate"]').attr('class', 'btn btn-xs btn-success');
            $('table#users tr[user_id='+id+'] td input[type="button"][value="Deactivate"]').attr('value', 'Activate');
            Util.successMsg("User deactivated Successfully");
         }
      }
   );
};

Users.savePosUser = function(){
   sh_details = {};
   sh_details["email"] = $("#stubhub_email").val();
   sh_details["password"] = $("#stubhub_password").val();
   sh_details["consumer-key"] = $("#sh_consumer_key").val();
   sh_details["consumer-secret"] = $("#sh_consumer_secret").val();
   data = {
      _id: $("#user_email").val(),
      api_key: $("#broker_key").val(),
      stubhub_details: sh_details,
      sql_db_details: {
         server_name: $("#sql_server_name").val(),
         database_user: $("#sql_database_name").val(),
         database_password: $("#sql_db_password").val(),
         database_name: $("#sql_database_name").val()
      },
      listing_capacity: $("#listing_capacity").val(),
      product_name: $("#product_name").val(),
   };

   if($("#product_name").val().split('-')[1] == 'tu'){
      data.tu_api_token = $("#pos_api_key").val();
      data.tu_sec = $("#pos_secret").val();
   } else if($("#product_name").val().split('-')[1] == 'vs'){
      data.vivid_api = $("#pos_api_key").val();
      data.vivid_account_id = $("#pos_secret").val();
   }

   Util.Post('v1/user/add', data,
      function(resp){
         if(resp.success){
            Util.successMsg('User details updated successfully')
         } else{
            Util.errorMsg(resp.error);
         }
      }, function(resp){
         error = '';
         resp = JSON.parse(resp.responseText);
         $.each(resp.error, function(i, val){
            error += val+'<br>';
         });
         Util.errorMsg(error);
      }
   );//post form
};

Users.populateUserSellerId = function() {
   user_id = $("#user_email").val();
   url = 'v1/user/info';
   Util.Get(url, 
      {user_id: user_id}, 
      function(data){
         if(data.success){
            $("#seller_id").val(data.success[0].seller_id);
         }
      }
   );
};

Users.saveUserSellerId = function(){
   Util.Post('v1/user/add/seller_id', 
      {
         user_id : $("#user_email").val(),
         seller_id : $("#seller_id").val()
      },
      function(resp){
         if(resp.success){
            Util.successMsg('User Seller ID successfully')
         }
      }, function(resp){
         error = '';
         resp = JSON.parse(resp.responseText);
         $.each(resp.error, function(i, val){
            error += val+'<br>';
         });
         Util.errorMsg(error);
      }
   );//post form
};

Users.updateVersion = function(user_id){
   Util.Put('v1/user/update/version', 
      {
         user_id : user_id,
         version : $("#version").val()
      },
      function(resp){
         if(resp.success){
            Util.successMsg('User Seller ID successfully')
         }
      }, function(resp){
         error = '';
         resp = JSON.parse(resp.responseText);
         $.each(resp.error, function(i, val){
            error += val+'<br>';
         });
         Util.errorMsg(error);
      }
   );//post form
};
	doc.on("submit", "form[data-action]", function(event) {
		form = $(this);
		url = form.attr('data-action');
		Util.Post(url, 
			form.serialize(), 
			function(data){
        if(data.success == true){
            $("#left_nav").show();
            $("body").removeClass("layout-top-nav");
            $("#dashboard_content").html("<p>Welcome "+data.email+"</p>");
        }
			}, 
			function(){}
		);
		return false;
	});

   /*NAVIGATION***********************************/
   $(".nav").on("click", function(event){
      link = $(this).attr("data-link");
      Util.StartWait();
      $("#dashboard_content").load(link, function(){
         Util.StopWait();
         switch(link.split("/")[1]){
            case "not-mapped-events": Events.getExchangeEvents(); break;
            case "users-stats" :  Users.PrepareDataTable(); break;
            case "users-details" :  Users.getUsers(false); break;
            case "add-pos-user" :  Users.prepareAddPosUser(); break;
            case "add-user-seller-id" :  Users.prepareAddUserSellerId(); break;
         }
      });
   });