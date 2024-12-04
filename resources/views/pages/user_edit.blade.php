@php
    $pageName = "Edit My Profile";
@endphp

@extends('layouts.app')

<main id="edit_profile">
   <div id="edit_profile_auxdiv">
      <div id="edit_profile_info">
         <h2>Edit My Profile</h2>
         <br>
         <p class="subtitle">Change your personal information</p>
      </div>
   </div>
   <div class="row messages">
        @if(session()->has('success'))
            <div class="offset-md-2 col-md-8 success">
                <div class="close_button"><i class="fas fa-times"></i></div>
                <p class="text_message"> {{session()->get('success')}} </p>
            </div>
        @endif
        @if (session()->has('failure'))
            <div class="offset-md-2 col-md-8 failure">
               <div class="close_button"><i class="fas fa-times"></i></div>
               <p class="text_message"> {{session()->get('failure')}} </p>
            </div>
         @endif
    </div>
   <form method="POST" acttion="{{ route('editMyProfileInfo', $id) }}" enctype="multipart/form-data">
      {{ csrf_field() }}
      
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
                           @php
                              $type = explode('/', $user->user_path)[0];
                           @endphp
                           @if ($type === 'images')
                                 <img src={{asset($user->user_path)}} alt="user profile picture" class="d-block ui-w-80">
                           @else
                                 <img src={{$user->user_path}} alt="user profile picture" class="d-block ui-w-80">
                           @endif
                           <div class="media-body ml-4">
                              <label class="btn btn-outline-primary">
                              Upload new photo
                              <input name="user_path" value={{$user->user_path}} type="file" class="account-settings-fileinput" onchange="selectImage(event)">
                              </label> &nbsp;
                              <button type="button" class="btn btn-outline-primary" data-id="{{$id}}">Reset</button>
                              <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                           </div>
                        </div>
                        <hr class="border-light m-0">
                        <div class="card-body">
                           <div class="form-group">
                              <label class="form-label">Username</label>
                              <input name="username" type="text" class="form-control mb-1" value={{$user->username}}>
                           </div>
                           <div class="form-group">
                              <label class="form-label">Name</label>
                              <input name="name" type="text" class="form-control" value={{$user->name}}>
                           </div>
                           <div class="form-group">
                              <label class="form-label">E-mail</label>
                              <input name="email" type="email" class="form-control mb-1" value={{$user->email}}>
                              <!-- <div class="alert alert-warning mt-3">
                                 Your email is not confirmed. Please check your inbox.<br>
                                 <a href="javascript:void(0)">Resend confirmation</a>
                              </div> -->
                           </div>
                        </div>
                        <div class="text-right mt-3">
                           <button type="submit" class="btn btn-blue button_small">Save changes</button>&nbsp;
                           <button type="button" class="btn btn-default button_small">Cancel</button>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="account-change-password">
                        <div class="card-body pb-2">
                           <div class="form-group">
                              <label class="form-label">Current password</label>
                              <input name="current_password" type="password" class="form-control">
                           </div>
                           <div class="form-group">
                              <label class="form-label">New password</label>
                              <input name="new_password" type="password" class="form-control">
                           </div>
                           <div class="form-group">
                              <label class="form-label">Repeat new password</label>
                              <input name="confirm_password" type="password" class="form-control">
                           </div>
                        </div>
                        <div class="text-right mt-3">
                           <button type="submit" class="btn btn-blue button_small">Save changes</button>&nbsp;
                           <button type="button" class="btn btn-default button_small">Cancel</button>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="account-info">
                        <div class="card-body pb-2">
                           <div class="form-group">
                              <label class="form-label">Bio</label>
                              <textarea name="bio" class="form-control" rows="5">{{$user->bio}}</textarea>
                           </div>
                           <div class="form-group">
                              <label class="form-label">Birthday</label>
                              <input name="birthday" type="text" class="form-control" value={{$user->birthday}}>
                           </div>
                           <div class="form-group">
                              <label class="form-label">Country</label>
                              <select name="country" class="custom-select">
                                 <option selected="">{{$user->country}}</option>
                                 <option>Spain</option>
                                 <option>UK</option>
                                 <option>Germany</option>
                                 <option>France</option>
                              </select>
                           </div>
                        </div>
                        <div class="text-right mt-3">
                           <button type="submit" class="btn btn-blue button_small">Save changes</button>&nbsp;
                           <button type="button" class="btn btn-default button_small">Cancel</button>
                        </div>
                     </div>
                  </form>
                  <div class="tab-pane fade" id="account-connections" style="margin:auto;">
                     
                     <div class="card-body">
                        <h5 class="mb-2">
                           Your current trust level is {{$user->trust_level}}
                        </h5>
                        @if(!$mod)
                        <form method="POST" action="{{route('applyForMod', $id)}}">
                           {{ csrf_field() }} 
                           @method('POST')
                           
                           <button type="submit" class="btn btn-green" >Apply to Mod</strong></button>
                        </form>
                        @endif
                     </div>
                     <hr class="border-light m-0">
                    

                     <div class="card-body">
                        <form method="POST" action="{{route('deleteMyAccount', $id)}}">
                           {{ csrf_field() }} 
                           @method('DELETE')
                           
                           <button type="submit" class="btn btn-red">Delete Account</strong></button>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div> 
</main>