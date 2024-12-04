<?php
    function getModAppeals() { ?>
        <main id="mod_appeals">
            <div id="head">
                <h2>Mod Appeals</h2><br>
                <div id="description">
                    <p>Check the appeals and analyze the user and their overall activity before accepting their appeal.</p>
                </div>
            </div>
            <form>
                <div class="mx-auto" style="width: 300px;">
                    <form class="form-inline my-2 my-lg-0">
                        <input  class="form-control mr-sm-2" type="search" placeholder="Username" aria-label="Search">
                        <button class="btn btn-outline-success my-2" type="submit">Search</button>
                    </form>
                </div>
            </form>
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
                                    <th class="text-center"><span>Trust Level</span></th>
                                    <th class="text-center"><span>Country</span></th>
                                    <th class="text-center"><span>Action</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td class="user_avatar">
                                        <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                                        <a href="#" class="user-link">Souto</a>
                                    </td>
                                    <td class="text-center trust_level">
                                        200
                                    </td>
                                    <td class="text-center country">
                                        <span class="label label-default">Turkey</span>
                                    </td>
                                    <td class="text-center action">
                                        <button type="button" class="btn sucess accept" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept">
                                            <i class="fas fa-check-circle"></i>    
                                        </button>
                                        <button type="button" class="btn danger refuse" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td class="user_avatar">
                                        <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                                        <a href="#" class="user-link">Grandão</a>
                                    </td>
                                    <td class="text-center trust_level">
                                        500
                                    </td>
                                    <td class="text-center country">
                                        <span class="label label-default">Sapin</span>
                                    </td>
                                    <td class="text-center action">
                                        <button type="button" class="btn sucess accept" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept">
                                            <i class="fas fa-check-circle"></i>    
                                        </button>
                                        <button type="button" class="btn danger refuse" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td class="user_avatar">
                                        <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                                        <a href="#" class="user-link">Ricardo</a>
                                    </td>
                                    <td class="text-center trust_level">
                                        400
                                    </td>
                                    <td class="text-center country">
                                        <span class="label label-default">Portugal</span>
                                    </td>
                                    <td class="text-center action">
                                        <button type="button" class="btn sucess accept" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept">
                                            <i class="fas fa-check-circle"></i>    
                                        </button>
                                        <button type="button" class="btn danger refuse" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td class="user_avatar">
                                        <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                                        <a href="#" class="user-link">Pedrinho</a>
                                    </td>
                                    <td class="text-center trust_level">
                                        200
                                    </td>
                                    <td class="text-center country">
                                        <span class="label label-default">Russia</span>
                                    </td>
                                    <td class="text-center action">
                                        <button type="button" class="btn sucess accept" data-bs-toggle="tooltip" data-bs-placement="top" title="Accept">
                                            <i class="fas fa-check-circle"></i>    
                                        </button>
                                        <button type="button" class="btn danger refuse" data-bs-toggle="tooltip" data-bs-placement="top" title="Reject">
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