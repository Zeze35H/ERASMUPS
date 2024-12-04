<?php
    function getModsDashboard() { ?>
        <main id="mods_dashboard">
            <div id="head">
                <h2>Mods Dashboard</h2><br>
                <div id="description">
                    <p>Check the list of mods on the website and manage.</p>
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
                                    <th class="text-center"><span>Number of Interactions</span></th>
                                    <th class="text-center"><span>Action</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td>
                                        <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                                        <a href="#" class="user-link">Souto</a>
                                    </td>
                                    <td class="text-center">
                                        500
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-default">1234</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Mod">
                                            <i class="fas fa-user-times"></i>    
                                        </button>
                                        <button type="button" class="btn danger demote" data-bs-toggle="tooltip" data-bs-placement="top" title="Demote Mod">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                                        <a href="#" class="user-link">Pedrinho</a>
                                    </td>
                                    <td class="text-center">
                                        200
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-success">35</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Mod">
                                            <i class="fas fa-user-times"></i>    
                                        </button>
                                        <button type="button" class="btn danger demote" data-bs-toggle="tooltip" data-bs-placement="top" title="Demote Mod">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                                        <a href="#" class="user-link">Grandão</a>
                                    </td>
                                    <td class="text-center">
                                        200
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-danger">70</span>
                                    </td>
                                   
                                    <td class="text-center">
                                        <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Mod">
                                            <i class="fas fa-user-times"></i>    
                                        </button>
                                        <button type="button" class="btn danger demote" data-bs-toggle="tooltip" data-bs-placement="top" title="Demote Mod">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </td>
                                    </tr>
                                    <tr>
                                    <td>
                                        <img src="../images/user.png" alt="user profile picture" width="40" height="40">
                                        <a href="#" class="user-link">Grandão</a>
                                    </td>
                                    <td class="text-center">
                                        400
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-warning">0</span>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn danger ban" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Mod">
                                            <i class="fas fa-user-times"></i>    
                                        </button>
                                        <button type="button" class="btn danger demote" data-bs-toggle="tooltip" data-bs-placement="top" title="Demote Mod">
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