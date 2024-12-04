<?php
   function getEditProfile() { ?>
<main id="edit_profile">
   <div id="edit_profile_auxdiv">
      <div id="edit_profile_info">
         <h2>Edit My Profile</h2>
         <br>
         <p class="subtitle">Change your personal information</p>
      </div>
   </div>
   <div class="container light-style flex-grow-1 container-p-y">
      <div class="card overflow-hidden">
         <div class="row no-gutters row-bordered row-border-light">
            <div class="col-md-3 pt-0">
               <div class="list-group list-group-flush account-settings-links">
                  <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Info</a>
                  <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-connections">Manage Account</a>
               </div>
            </div>
            <div class="col-md-9">
               <div class="tab-content">
                  <div class="tab-pane fade active show" id="account-general">
                     <div class="card-body media align-items-center">
                        <img src="../images/user.png" alt="" class="d-block ui-w-80">
                        <div class="media-body ml-4">
                           <label class="btn btn-outline-primary">
                           Upload new photo
                           <input type="file" class="account-settings-fileinput">
                           </label> &nbsp;
                           <button type="button" class="btn btn-outline-primary">Reset</button>
                           <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                     </div>
                     <hr class="border-light m-0">
                     <div class="card-body">
                        <div class="form-group">
                           <label class="form-label">Username</label>
                           <input type="text" class="form-control mb-1" value="pedrinho123">
                        </div>
                        <div class="form-group">
                           <label class="form-label">Name</label>
                           <input type="text" class="form-control" value="Pedro Pedrito">
                        </div>
                        <div class="form-group">
                           <label class="form-label">E-mail</label>
                           <input type="text" class="form-control mb-1" value="pedrito@mail.com">
                           <div class="alert alert-warning mt-3">
                              Your email is not confirmed. Please check your inbox.<br>
                              <a href="javascript:void(0)">Resend confirmation</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="account-change-password">
                     <div class="card-body pb-2">
                        <div class="form-group">
                           <label class="form-label">Current password</label>
                           <input type="password" class="form-control">
                        </div>
                        <div class="form-group">
                           <label class="form-label">New password</label>
                           <input type="password" class="form-control">
                        </div>
                        <div class="form-group">
                           <label class="form-label">Repeat new password</label>
                           <input type="password" class="form-control">
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="account-info">
                     <div class="card-body pb-2">
                        <div class="form-group">
                           <label class="form-label">Bio</label>
                           <textarea class="form-control" rows="5">20 years old and living in Porto. Studying at FEUP</textarea>
                        </div>
                        <div class="form-group">
                           <label class="form-label">Birthday</label>
                           <input type="text" class="form-control" value="May 3, 1995">
                        </div>
                        <div class="form-group">
                           <label class="form-label">Country</label>
                           <select class="custom-select">
                              <option>Spain</option>
                              <option selected="">Portugal</option>
                              <option>UK</option>
                              <option>Germany</option>
                              <option>France</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="account-connections">
                     <div class="card-body">
                        <h5 class="mb-2">
                           <i class="ion ion-logo-google text-google"></i>
                           Your current trust level is 500
                        </h5>
                        <button type="button" class="btn btn-green">Apply to Mod</strong></button>
                     </div>
                     <hr class="border-light m-0">

                     <div class="card-body">
                        <button type="button" class="btn btn-red">Delete Account</strong></button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <div class="text-right mt-3">
      <button type="button" class="btn btn-blue button_small">Save changes</button>&nbsp;
      <button type="button" class="btn btn-default button_small">Cancel</button>
   </div>
   </div>
</main>
<?php }
   ?>