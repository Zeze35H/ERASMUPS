<?php
   function getOtherProfile() { ?>
<main id="other_profile">
   <script src="https://kit.fontawesome.com/bbe86cf3eb.js" crossorigin="anonymous"></script>
   <div id="other_profile_info">
      <h2>User's Profile</h2>
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
                     </div>
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
                  <div class="col-md-12">
                     <div class="card mb-9">
                        <div class="row">
                           <div class="card-body">
                              <h6 class="mb-9">Questions made by user</h6>
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
                              </div>&nbsp;
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
</main>
<?php }
   ?>