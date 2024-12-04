<?php
   function getReportsPage() { ?>
<main id="reports">
   <div id="head">
      <h2>Reports</h2>
      <br>
      <div id="description">
         <p>Review user reports and decide how they should be handled</p>
      </div>
   </div>
   <div id="body">
    
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
   <div class="container mt-5">
      <div class="row">
         <div class="col-lg-12">
            <div class="main-box clearfix">
               <div class="table-responsive">
                  <table class="table user-list">
                     <thead>
                        <tr>
                           <th><span>User</span></th>
                           <th class="text-center"><span>Date</span></th>
                           <th class="text-center"><span>Status</span></th>
                           <th class="text-center"><span>Reported Content</span></th>
                           <th class="text-center"><span>Reason</span></th>
                           <th class="text-center"><span>Action</span></th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td>
                              <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                              <a href="#" class="user-link">Souto</a>
                              <span class="user-subhead">Trust Level: 500</span>
                           </td>
                           <td class="text-center">
                              2013/08/08
                           </td>
                           <td class="text-center">
                              <span class="label label-default">Pending</span>
                           </td>
                           <td class="text-center">
                              <a href="#">content</a>
                           </td>
                           <td class="text-center">
                           <span class="label label-default">Disrespectful</span>
                           </td>
                           <td class="text-center">
                              <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Author">
                                 <i class="fas fa-user-times"></i>    
                              </button>
                              <button type="button" class="btn danger trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Content">
                                 <i class="fas fa-trash-alt"></i>
                              </button>
                              <button type="button" class="btn danger ignore" data-bs-toggle="tooltip" data-bs-placement="top" title="Ignore Report">
                                 <i class="fas fa-times-circle"></i>
                              </button>
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                              <a href="#" class="user-link">Pedrinho</a>
                              <span class="user-subhead">Trust Level: 500</span>
                           </td>
                           <td class="text-center">
                              2013/08/12
                           </td>
                           <td class="text-center">
                              <span class="label label-success">Pending</span>
                           </td>
                           <td class="text-center">
                              <a href="#">content</a>
                           </td>
                           <td class="text-center">
                           <span class="label label-default">Not Valuable</span>
                           </td>
                           <td class="text-center">
                              <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Author">
                                 <i class="fas fa-user-times"></i>    
                              </button>
                              <button type="button" class="btn danger trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Content">
                                 <i class="fas fa-trash-alt"></i>
                              </button>
                              <button type="button" class="btn danger ignore" data-bs-toggle="tooltip" data-bs-placement="top" title="Ignore Report">
                                 <i class="fas fa-times-circle"></i>
                              </button>
                           </td>
                        </tr>
                        <tr>
                           <td>
                              <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                              <a href="#" class="user-link">Ryan Gossling</a>
                              <span class="user-subhead">Trust Level: 500</span>
                           </td>
                           <td class="text-center">
                              2013/03/03
                           </td>
                           <td class="text-center">
                              <span class="label label-danger">Pending</span>
                           </td>
                           <td class="text-center">
                              <a href="#">content</a>
                           </td>
                           <td class="text-center">
                           <span class="label label-default">Other Reason</span>
                           </td>
                           <td class="text-center">
                              <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Author">
                                 <i class="fas fa-user-times"></i>    
                              </button>
                              <button type="button" class="btn danger trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Content">
                                 <i class="fas fa-trash-alt"></i>
                              </button>
                              <button type="button" class="btn danger ignore" data-bs-toggle="tooltip" data-bs-placement="top" title="Ignore Report">
                                 <i class="fas fa-times-circle"></i>
                              </button>
                           </td>
                        </tr>
                        <tr>
                           <td >
                              <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                              <a href="#" class="user-link">Emma Watson</a>
                              <span class="user-subhead">Trust Level: 500</span>
                           </td>
                           <td class="text-center">
                              2004/01/24
                           </td>
                           <td class="text-center">
                              <span class="label label-warning">Pending</span>
                           </td>
                           <td class="text-center">
                              <a href="#">content</a>
                           </td>
                           <td class="text-center">
                           <span class="label label-default">Disrespectful</span>
                           </td>
                           <td class="text-center">
                              <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Author">
                                 <i class="fas fa-user-times"></i>    
                              </button>
                              <button type="button" class="btn danger trash" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Content">
                                 <i class="fas fa-trash-alt"></i>
                              </button>
                              <button type="button" class="btn danger ignore" data-bs-toggle="tooltip" data-bs-placement="top" title="Ignore Report">
                                 <i class="fas fa-times-circle"></i>
                              </button>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
</main>
<?php }
   ?>