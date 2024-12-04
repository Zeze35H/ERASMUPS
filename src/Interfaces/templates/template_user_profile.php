<?php
   function getUserProfile() { ?>
<main id="user_profile">
   <script src="https://kit.fontawesome.com/bbe86cf3eb.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js" integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg==" crossorigin="anonymous"></script>
   <div id="user_profile_info">
      <h2>Pedro123's Profile</h2>
      <br>                         
      <p class="trust_level">User Trust Level: xxx
      <p><br></br>
   </div>
   <div class="container">
   <div class="main-body">
      <div class="row gutters-sm">
         <div class="col-md-4 mb-3">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                     <img src="../images/user.png" alt="Admin" class="rounded-circle" width="150">
                     <div class="mt-3">
                        <h4>Pedro Pedrito</h4>
                        <p class="text-secondary mb-1">Full Stack Developer</p>
                        <p class="text-muted font-size-sm">Portugal</p>
                        <p class="text-muted font-size-sm">ERASMUS Out</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card mt-3">
               <div class="col-sm-3">
                  <h6 class="mb-0">Bio</h6>
               </div>
               <div class="col-sm-9 text-secondary">
                  20 years old and living in Porto. Studying at FEUP
                  ERASMUS Out Student at Finland
               </div>
   </div>
            <div class="card mt-3">
               <ul class="list-group list-group-flush">
               <div class="col-sm-6">
                  <h6 class="mb-0">Statistics</h6>
               </div>               &nbsp;
                  &nbsp;
                  <li class="list-group-item ">
                     <span class="text-secondary">Number of Votes: 23</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                     <span class="text-secondary">Number of Answers: 15</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                     <span class="text-secondary">Number of Questions: 2</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                     <span class="text-secondary">Number of Favorite Answers: 1</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                     <span class="text-secondary">Number of Comments: 20</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                     <span class="text-secondary">Number of Visits: 68</span>
                  </li>
               </ul>
            </div>
            <div class="card mt-3">
               <div class="col-sm-12">
                  <h6 class="mb-0">Followed tags</h6>
                  &nbsp;
                  <div id="followedtags">
                     <div class="bootstrap-tagsinput">  <span class="tag label btn btn-light btn-s">FEUP<span data-role="remove"></span></span> <span class="tag label btn btn-light btn-s label-info">MIEIC<span data-role="remove"></span></span> <span class="tag label btn btn-light btn-s label-info">UP<span data-role="remove"></span></span> <span class="tag label btn btn-light btn-s label-info">Engineering<span data-role="remove"></span></span> <span class="tag label btn btn-light btn-s label-info">ERASMUS<span data-role="remove"></span></span></div>
                  </div>
               </div>
               <div class="card-body">
                  <h6 class="mb-0">Search new tags</h6>
                  &nbsp;
                  <label>Insert tag and press enter to follow.</label>
                  <input type="text" data-role="tagsinput" name="tags" class="form-control">
               </div>
            </div>
         </div>
         <div class="col-md-8">
            <div class="card mb-3">
               <div class="card-body">
                  <div class="row">
                     <div class="col-sm-3">
                        <h6 class="mb-0">Name</h6>
                     </div>
                     <div class="col-sm-9 text-secondary">
                        Pedrito
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                     </div>
                     <div class="col-sm-9 text-secondary">
                        pedro@pedrito.com
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-sm-3">
                        <h6 class="mb-0">Country</h6>
                     </div>
                     <div class="col-sm-9 text-secondary">
                        Portugal
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-sm-3">
                        <h6 class="mb-0">Birthday</h6>
                     </div>
                     <div class="col-sm-9 text-secondary">
                        5 May 1995
                     </div>
                  </div>
                  <hr>
                  <div class="row">
                     <div class="col-sm-3">
                        <h6 class="mb-0">ERASMUS</h6>
                     </div>
                     <div class="col-sm-9 text-secondary">
                        Erasmus Out
                     </div>
                  </div>
               </div>
            </div>
            <div class="row gutters-sm">
               <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                     <div class="card-body">
                        <h6 class="d-flex align-items-center mb-3"><i class="material-icons mr-2">Badges</i>in progress</h6>
                        <small>Voting Expert</small>
                        <div class="progress mb-3" style="height: 5px">
                           <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small>Answering Newbie</small>
                        <div class="progress mb-3" style="height: 5px">
                           <div class="progress-bar" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small>Questioning Master</small>
                        <div class="progress mb-3" style="height: 5px">
                           <div class="progress-bar" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small>Commenting Grandmaster</small>
                        <div class="progress mb-3" style="height: 5px">
                           <div class="progress-bar" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small>Top Visitor</small>
                        <div class="progress mb-3" style="height: 5px">
                           <div class="progress-bar" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                     <div class="card-body">
                        <h6 class="d-flex align-items-center mb-3"><i class="material-icons mr-2">Badges</i>earned</h6>
                        <small>Voting Junior</small>
                        <div class="certificate" style="height: 25px">
                           <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                        </div>
                        <small>Questioning Expert</small>
                        <div class="certificate" style="height: 25px">
                           <i class="fas fa-certificate" style="color: #fde64b"></i>
                        </div>
                        <small>Commenting Master</small>
                        <div class="certificate" style="height: 25px">
                           <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                        </div>
                        <hr>
                        <small style="color: grey">Badges Level Coding</small>
                        <div class="certificate" style="height: 25px">
                           <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                           <small style="color: grey">Newbie</small>
                        </div>
                        <div class="certificate" style="height: 25px">
                           <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                           <small style="color: grey">Junior</small>
                        </div>
                        <div class="certificate" style="height: 25px">
                           <i class="fas fa-certificate" style="color: #fde64b"></i>
                           <small style="color: grey">Expert</small>
                        </div>
                        <div class="certificate" style="height: 25px">
                           <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                           <small style="color: grey">Master</small>
                        </div>
                        <div class="certificate" style="height: 25px">
                           <i class="fas fa-certificate" style="color: #2aa493"></i>
                           <small style="color: grey">Grandmaster</small>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="card mb-3">
                     <div class="card-body">
                        <div class="row">
                           <div class="col-sm-16">
                              <div class="card-body">
                                 <h6 class="mb-9">My Questions</h6>
                                 <div id="question1">
                                    <h2>University of Bucharest</h2>
                                    <p>Is there any engineering student who has been to Politehnica University of Bucharest? What did you thought about the city and the education system? Thank you!</p>
                                    <div id="tags1">
                                       <button type="button" class="btn btn-light btn-sm">Romania</button>
                                       <button type="button" class="btn btn-light btn-sm">Bucharest</button>
                                       <button type="button" class="btn btn-light btn-sm">ERASMUS</button>
                                       <button type="button" class="btn btn-light btn-sm">PUB</button>
                                    </div>
                                    <div class="thread" id="seeAll1">
                                       <a href="../pages/q_a_thread.php" style="color: #555;">View question </a>
                                       <i class='fas fa-arrow-right' style='font-size:16px'></i>
                                    </div>
                                 </div>
                                 &nbsp;
                                 <div id="question2">
                                    <h2>Question</h2>
                                    <p>Hi! I'll be a student at FEUP for the next semester and I was wondering if anyone can give me some information about accomodation? Is there a residence for Erasmus students?</p>
                                    <div id="tags2">
                                       <button type="button" class="btn btn-light btn-sm">Tag 1</button>
                                       <button type="button" class="btn btn-light btn-sm">Tag 2</button>
                                       <button type="button" class="btn btn-light btn-sm">Tag 3</button>
                                       <button type="button" class="btn btn-light btn-sm">Tag 4</button>
                                    </div>
                                    <div class="thread" id="seeAll2">
                                       <a href="../pages/q_a_thread.php" style="color: #555;">View question </a> 
                                       <i class='fas fa-arrow-right' style='font-size:16px'></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</main>
<?php }
   ?>