<div class="row" style="margin-top: 50px">
   <div class="col-md-4 col-md-offset-4">
      <div class="box box-solid">
         <div class="box-header with-border">
            <h3 class="box-title">Signin</h3>
         </div>
         <form data-action="adminpanel" method="post">
         
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="box-body">
               <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter email">
               </div>
               
               <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
               </div>
            </div><!-- /.box-body -->

            <div class="box-footer">
               <button type="submit" class="btn btn-danger">Signin</button>
            </div>
         </form>
      </div><!-- /.box -->
   </div>
</div>