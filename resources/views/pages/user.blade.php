@php
$pageName = 'Profile';
@endphp

@extends('layouts.app')

@section('content')
    <main id="user_profile">
        @if (session()->has('success'))
            <div class="row">
                <div class="offset-md-2 col-md-8 success">{{ session()->get('success') }}</div>
            </div>
        @endif
        <script src="https://kit.fontawesome.com/bbe86cf3eb.js" crossorigin="anonymous"></script>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css"
            integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg=="
            crossorigin="anonymous" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js"
            integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg=="
            crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js"
            integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg=="
            crossorigin="anonymous"></script>

        <div id="user_profile_info">
            @if ($idAuthUser !== $user->id)
                <h2>{{ $user->username }}'s Profile</h2>
            @else <h2>My Profile</h2>
            @endif
            <br>
            <p class="trust_level">Trust Level: {{ $user->trust_level }}
            <p><br><br>
        </div>
        <div class="container">
            <div class="main-body">

                <div class="row gutters-sm">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    @php
                                        $type = explode('/', $user->path)[0];
                                    @endphp
                                    @if ($type === 'images')
                                        <img src={{ asset($user->path) }} alt="user profile picture"
                                            class="rounded-circle" width="150">
                                    @else
                                        <img src={{ $user->path }} alt="user profile picture" class="rounded-circle"
                                            width="150">
                                    @endif
                                    <div class="mt-3">
                                        <h4>{{ $user->username }}</h4>
                                        <p class="text-muted font-size-sm">{{ $user->country }}</p>
                                        @if ($user->erasmus_in_out == 'true')
                                            <p class="text-muted font-size-sm">ERASMUS in</p>
                                        @else
                                            <p class="text-muted font-size-sm">ERASMUS out</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Bio</h6>
                                    @if ($user->bio === null && $idAuthUser !== $user->id)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-secondary">{{ $user->username }} has no bio yet!</small>
                                </li>
                            @elseif ($user->bio === null && $idAuthUser === $user->id)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-secondary"><a href="{{ url('/user' . $user->id . '/edit') }}">Edit
                                            your
                                            profile</a> to create a biography</small>

                                </li>
                            @else
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">{{ $user->bio }}</span>
                                </li>
                                @endif
                                </li>
                            </ul>
                        </div>
                        @if ($idAuthUser !== $user->id)
                            <div class="card mt-3">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">Badges</h6>
                                        @if ($user->badges === '')
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <small class="text-secondary">{{ $user->username }} has no badges yet!</small>
                                    </li>
                        @endif
                        @if ($user->num_votes >= '10' && $user->num_votes < '30')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Voting Newbie</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                                </div>
                            </li>
                        @elseif ($user->num_votes >= '30' && $user->num_votes < '100' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Voting Junior</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                                </div>
                                </li>
                            @elseif ($user->num_votes >= '100' && $user->num_votes < '200' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Voting Expert</span>
                                    <div class="certificate" style="height: 25px">
                                        <i class="fas fa-certificate" style="color: #fde64b"></i>
                                    </div>
                                    </li>
                                @elseif ($user->num_votes >= '200' && $user->num_votes < '500' ) <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="text-secondary">Voting Master</span>
                                        <div class="certificate" style="height: 25px">
                                            <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                                        </div>
                                        </li>
                                    @elseif ($user->num_votes == '500')
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <span class="text-secondary">Voting Grandmaster</span>
                                            <div class="certificate" style="height: 25px">
                                                <i class="fas fa-certificate" style="color: #2aa493"></i>
                                            </div>
                                        </li>
                        @endif

                        @if ($user->num_answers >= '10' && $user->num_answers < '30')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Answering Newbie</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                                </div>
                            </li>
                        @elseif ($user->num_answers >= '30' && $user->num_answers < '50' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Answering Junior</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                                </div>
                                </li>
                            @elseif ($user->num_answers >= '50' && $user->num_answers < '100' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Answering Expert</span>
                                    <div class="certificate" style="height: 25px">
                                        <i class="fas fa-certificate" style="color: #fde64b"></i>
                                    </div>
                                    </li>
                                @elseif ($user->num_answers >= '100' && $user->num_answers < '200' ) <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="text-secondary">Answering Master</span>
                                        <div class="certificate" style="height: 25px">
                                            <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                                        </div>
                                        </li>
                                    @elseif ($user->num_answers == '200')
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <span class="text-secondary">Answering Grandmaster</span>
                                            <div class="certificate" style="height: 25px">
                                                <i class="fas fa-certificate" style="color: #2aa493"></i>
                                            </div>
                                        </li>
                        @endif

                        @if ($user->num_questions >= '2' && $user->num_questions < '10')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Questioning Newbie</span>

                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                                </div>
                            </li>
                        @elseif ($user->num_questions >= '10' && $user->num_questions < '20' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Questioning Junior</span>

                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                                </div>
                                </li>
                            @elseif ($user->num_questions >= '20' && $user->num_questions < '50' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Questioning Expert</span>
                                    <div class="certificate" style="height: 25px">
                                        <i class="fas fa-certificate" style="color: #fde64b"></i>
                                    </div>
                                    </li>
                                @elseif ($user->num_questions >= '50' && $user->num_questions < '100' ) <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="text-secondary">Questioning Master</span>
                                        <div class="certificate" style="height: 25px">
                                            <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                                        </div>
                                        </li>
                                    @elseif ($user->num_questions == '100')
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <span class="text-secondary">Questioning Grandmaster</span>
                                            <div class="certificate" style="height: 25px">
                                                <i class="fas fa-certificate" style="color: #2aa493"></i>
                                            </div>
                                        </li>
                        @endif

                        @if ($user->num_comments >= '20' && $user->num_comments < '50')
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Commenting Newbie</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                                </div>
                            </li>
                        @elseif ($user->num_comments >= '50' && $user->num_comments < '70' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Commenting Junior</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                                </div>
                                </li>
                            @elseif ($user->num_comments >= '70' && $user->num_comments < '100' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Commenting Expert</span>
                                    <div class="certificate" style="height: 25px">
                                        <i class="fas fa-certificate" style="color: #fde64b"></i>
                                    </div>
                                    </li>
                                @elseif ($user->num_comments >= '100' && $user->num_comments < '200' ) <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="text-secondary">Commenting Master</span>
                                        <div class="certificate" style="height: 25px">
                                            <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                                        </div>
                                        </li>
                                    @elseif ($user->num_comments == '200')
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <span class="text-secondary">Commenting Grandmaster</span>
                                            <div class="certificate" style="height: 25px">
                                                <i class="fas fa-certificate" style="color: #2aa493"></i>
                                            </div>
                                        </li>
                        @endif
                        </li>
                        </ul>

                    </div>
                    @endif
                    @if ($idAuthUser === $user->id)
                        <div class="card mt-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Statistics</h6>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Number of Votes: {{ $user->num_votes }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Number of Answers: {{ $user->num_answers }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Number of Questions:
                                        {{ $user->num_questions }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Number of Favorite Answers:
                                        {{ $user->num_fav_answers }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Number of Comments: {{ $user->num_comments }}</span>
                                </li>
                            </ul>
                        </div>
                    @endif
                    <div class="card mt-3">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Followed tags</h6>
                                &nbsp;

                                <div id="followedtags" data-id="{{ $user->id }}">
                                    @include('partials.tags', ['tags_string' => $user->tags, 'close' => $idAuthUser ===
                                    $user->id])
                                </div>
                            </li>

                            <!-- It's not his profile -->
                            @if ($idAuthUser === $user->id)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <h6 class="mb-0">Follow new tags</h6>
                                    &nbsp;
                                    <span class="text-secondary">Separate each tag by a space.</span>

                                    <form class="followtags" data-id="{{ $user->id }}">
                                        <input style="margin-top: 0.7em" name="tags" type="text" class="form-control"
                                            placeholder="Insert tags" value='{{ old('tags') }}'>
                                        <button id="submit" style="margin-top: 0.7em" class="btn btn-default button_small"
                                            type="submit" name="submit_tags">Follow</button>

                                        &nbsp;
                                    </form>
                                </li>
                            @endif

                        </ul>
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
                                    {{ $user->name }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->email }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Country</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->country }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Birthday</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $user->birthday }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">ERASMUS</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    @if ($user->erasmus_in_out === 'true')
                                        ERASMUS in
                                    @else
                                        ERASMUS out
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                    @if ($idAuthUser === $user->id)
                        <div class="row gutters-sm">
                            <div class="col-sm-6 mb-3">
                                <div class="card h-100">
                                    <ul class="list-group list-group-flush">

                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0">Badges in progress</h6>
                                            @if ($user->num_votes < '10')
                                        <li
                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <small class="text-secondary">Voting Newbie</small>
                                        </li>
                                        @if ($user->num_votes == '0')
                                            <div class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 0%"
                                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_votes < '2' ) <div class="progress mb-3"
                                                style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 1%"
                                                    aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @elseif ($user->num_votes >= '2' && $user->num_votes < '5' ) <div class="progress mb-3"
                                    style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @elseif ($user->num_votes == '5')
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @elseif ($user->num_votes >= '6' && $user->num_votes < '10' ) <div class="progress mb-3"
                                style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @endif

                @elseif ($user->num_votes >= '10' && $user->num_votes < '30' ) <li
                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                        <small class="text-secondary">Voting Junior</small>
                        </li>
                        @if ($user->num_votes < '15')
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @elseif ($user->num_votes >= '15' && $user->num_votes < '20' ) <div class="progress mb-3"
                                style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            @elseif ($user->num_votes >= '20' && $user->num_votes < '25' ) <div class="progress mb-3"
                    style="height: 5px">
                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                        aria-valuemax="100"></div>
            </div>
        @elseif ($user->num_votes >= '25' && $user->num_votes < '30' ) <div class="progress mb-3" style="height: 5px">
                <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                    aria-valuemax="100"></div>
        </div>
        @endif

    @elseif ($user->num_votes >= '30' && $user->num_votes < '100' ) <li
            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-secondary">Voting Expert</small>
            </li>

            @if ($user->num_votes < '45')
                <div class="progress mb-3" style="height: 5px">
                    <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
            @elseif ($user->num_votes >= '45' && $user->num_votes < '65' ) <div class="progress mb-3"
                    style="height: 5px">
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                        aria-valuemax="100"></div>
                    </div>
                @elseif ($user->num_votes >= '65' && $user->num_votes < '85' ) <div class="progress mb-3"
                        style="height: 5px">
                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        </div>
                    @elseif ($user->num_votes >= '85' && $user->num_votes < '100' ) <div class="progress mb-3"
                            style="height: 5px">
                            <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
            @endif


        @elseif ($user->num_votes > '100' && $user->num_votes <= '200' ) <li
                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                <small class="text-secondary">Voting Master</small>
                </li>

                @if ($user->num_votes < '125')
                    <div class="progress mb-3" style="height: 5px">
                        <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1" aria-valuemin="0"
                            aria-valuemax="100"></div>
                    </div>
                @elseif ($user->num_votes >= '125' && $user->num_votes < '150' ) <div class="progress mb-3"
                        style="height: 5px">
                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0"
                            aria-valuemax="100"></div>
                        </div>
                    @elseif ($user->num_votes >= '150' && $user->num_votes < '175' ) <div class="progress mb-3"
                            style="height: 5px">
                            <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @elseif ($user->num_votes >= '175' && $user->num_votes < '200' ) <div class="progress mb-3"
                                style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                @endif


            @elseif ($user->num_votes <= '500' ) <li
                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <small class="text-secondary">Voting Grandmaster</small>
                    </li>

                    @if ($user->num_votes < '275')
                        <div class="progress mb-3" style="height: 5px">
                            <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @elseif ($user->num_votes >= '275' && $user->num_votes < '350' ) <div class="progress mb-3"
                            style="height: 5px">
                            <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @elseif ($user->num_votes >= '350' && $user->num_votes < '425' ) <div class="progress mb-3"
                                style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @elseif ($user->num_votes >= '425' && $user->num_votes <= '500' ) <div class="progress mb-3"
                                    style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                    @endif
                    @endif

                    @if ($user->num_answers < '10')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <small class="text-secondary">Answering Newbie</small>
                        </li>
                        @if ($user->num_answers == '0')
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @elseif ($user->num_answers < '2' ) <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @elseif ($user->num_answers >= '2' && $user->num_answers < '5' ) <div class="progress mb-3"
                                    style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @elseif ($user->num_answers >= '5' && $user->num_answers < '7' ) <div
                                        class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_answers >= '7' && $user->num_answers < '10' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 75%"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                        @endif

                    @elseif ($user->num_answers >= '10' && $user->num_answers < '30' ) <li
                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <small class="text-secondary">Answering Junior</small>
                            </li>
                            @if ($user->num_answers < '15')
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @elseif ($user->num_answers >= '15' && $user->num_answers < '20' ) <div
                                    class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @elseif ($user->num_answers >= '20' && $user->num_answers < '25' ) <div
                                        class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_answers >= '25' && $user->num_answers < '30' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 75%"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            @endif

                        @elseif ($user->num_answers >= '30' && $user->num_answers < '50' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <small class="text-secondary">Answering Expert</small>
                                </li>
                                @if ($user->num_answers < '35')
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @elseif ($user->num_answers >= '35' && $user->num_answers < '40' ) <div
                                        class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_answers >= '40' && $user->num_answers < '45' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_answers >= '45' && $user->num_answers < '50' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 75%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                @endif

                            @elseif ($user->num_answers >= '50' && $user->num_answers < '100' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-secondary">Answering Master</small>
                                    </li>
                                    @if ($user->num_answers < '65')
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_answers >= '65' && $user->num_answers < '75' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_answers >= '75' && $user->num_answers < '85' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            @elseif ($user->num_answers >= '85' && $user->num_answers < '100' ) <div
                                                    class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar" role="progressbar" style="width: 75%"
                                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                    @endif

                                @elseif ($user->num_answers >= '100' && $user->num_answers <= '200' ) <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <small class="text-secondary">Answering Grandmaster</small>
                                        </li>
                                        @if ($user->num_answers < '125')
                                            <div class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 1%"
                                                    aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_answers >= '125' && $user->num_answers < '150' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 25%"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            @elseif ($user->num_answers >= '150' && $user->num_answers < '175' ) <div
                                                    class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                @elseif ($user->num_answers >= '175' && $user->num_answers <= '200' )
                                                        <div class="progress mb-3" style="height: 5px">
                                                        <div class="progress-bar" role="progressbar" style="width: 75%"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                        @endif

                    @endif

                    @if ($user->num_questions < '2')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <small class="text-secondary">Questioning Newbie</small>
                        </li>
                        @if ($user->num_questions == '0')
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="1"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        @elseif ($user->num_questions == '1')
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>

                        @endif


                    @elseif ($user->num_questions >= '2' && $user->num_questions < '10' ) <li
                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <small class="text-secondary">Questioning Junior</small>
                            </li>
                            @if ($user->num_questions < '4')
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @elseif ($user->num_questions >= '4' && $user->num_questions < '6' ) <div
                                    class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @elseif ($user->num_questions >= '6' && $user->num_questions < '8' ) <div
                                        class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_questions >= '8' && $user->num_questions < '10' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 75%"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            @endif

                        @elseif ($user->num_questions >= '10' && $user->num_questions < '20' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <small class="text-secondary">Questioning Expert</small>
                                </li>
                                @if ($user->num_questions < '12')
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @elseif ($user->num_questions >= '12' && $user->num_questions < '15' ) <div
                                        class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_questions >= '15' && $user->num_questions < '17' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_questions >= '17' && $user->num_questions < '20' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 75%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                @endif

                            @elseif ($user->num_questions >= '20' && $user->num_questions < '50' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-secondary">Questioning Master</small>
                                    </li>
                                    @if ($user->num_questions < '27')
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_questions >= '27' && $user->num_questions < '35' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_questions >= '35' && $user->num_questions < '42' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            @elseif ($user->num_questions >= '42' && $user->num_questions < '50' ) <div
                                                    class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar" role="progressbar" style="width: 75%"
                                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                    @endif

                                @elseif ($user->num_questions >= '50' && $user->num_questions
                                    <= '100' ) <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <small class="text-secondary">Questioning Grandmaster</small>
                                        </li>
                                        @if ($user->num_questions < '65')
                                            <div class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 1%"
                                                    aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_questions >= '65' && $user->num_questions < '75' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 25%"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            @elseif ($user->num_questions >= '75' && $user->num_questions < '85' ) <div
                                                    class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                @elseif ($user->num_questions >= '85' && $user->num_questions <= '100' )
                                                        <div class="progress mb-3" style="height: 5px">
                                                        <div class="progress-bar" role="progressbar" style="width: 75%"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                        @endif
                    @endif

                    @if ($user->num_comments < '20')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <small class="text-secondary">Commenting Newbie</small>
                        </li>
                        @if ($user->num_comments == '0')
                            <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        @elseif ($user->num_comments < '5' ) <div class="progress mb-3" style="height: 5px">
                                <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @elseif ($user->num_comments >= '5' && $user->num_comments < '10' ) <div
                                    class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @elseif ($user->num_comments >= '10' && $user->num_comments < '15' ) <div
                                        class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_comments >= '15' && $user->num_comments < '20' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 75%"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                        @endif
                    @elseif ($user->num_comments >= '20' && $user->num_comments < '50' ) <li
                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <small class="text-secondary">Commenting Junior</small>
                            </li>
                            @if ($user->num_comments < '27')
                                <div class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            @elseif ($user->num_comments >= '27' && $user->num_comments < '35' ) <div
                                    class="progress mb-3" style="height: 5px">
                                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @elseif ($user->num_comments >= '35' && $user->num_comments < '42' ) <div
                                        class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_comments >= '42' && $user->num_comments < '50' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 75%"
                                                aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            @endif
                        @elseif ($user->num_comments >= '50' && $user->num_comments < '70' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <small class="text-secondary">Commenting Expert</small>
                                </li>
                                @if ($user->num_comments < '55')
                                    <div class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                @elseif ($user->num_comments >= '55' && $user->num_comments < '60' ) <div
                                        class="progress mb-3" style="height: 5px">
                                        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_comments >= '60' && $user->num_comments < '65' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_comments >= '65' && $user->num_comments < '70' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 75%"
                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                @endif
                            @elseif ($user->num_comments >= '70' && $user->num_comments < '100' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <small class="text-secondary">Commenting Master</small>
                                    </li>
                                    @if ($user->num_comments < '77')
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="1"
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    @elseif ($user->num_comments >= '77' && $user->num_comments < '85' ) <div
                                            class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar" role="progressbar" style="width: 25%"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_comments >= '85' && $user->num_comments < '92' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 50%"
                                                    aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            @elseif ($user->num_comments >= '92' && $user->num_comments < '100' ) <div
                                                    class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar" role="progressbar" style="width: 75%"
                                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                    @endif
                                @elseif ($user->num_comments >= '100' && $user->num_comments
                                    < '200' ) <li
                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <small class="text-secondary">Commenting Grandmaster</small>
                                        </li>
                                        @if ($user->num_comments < '125')
                                            <div class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 1%"
                                                    aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        @elseif ($user->num_comments >= '125' && $user->num_comments < '150' ) <div
                                                class="progress mb-3" style="height: 5px">
                                                <div class="progress-bar" role="progressbar" style="width: 25%"
                                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            @elseif ($user->num_comments >= '150' && $user->num_comments < '175' ) <div
                                                    class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%"
                                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                @elseif ($user->num_comments >= '175' && $user->num_comments <= '200' )
                                                        <div class="progress mb-3" style="height: 5px">
                                                        <div class="progress-bar" role="progressbar" style="width: 75%"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                        @endif
                    @endif
                    </li>
                    </ul>
                    </div>
                    </div>
                    @endif

                    @if ($idAuthUser === $user->id)
                        <div class="col-sm-6 mb-3">
                            <div class="card mt-0 h-100">
                                <ul class="list-group list-group-flush">

                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <h6 class="mb-0">Earned Badges</h6>

                                        @if ($user->badges === '')
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <small class="text-secondary">You have no badges yet!</small>
                                    </li>
                    @endif
                    @if ($user->num_votes >= '10' && $user->num_votes < '30')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="text-secondary">Voting Newbie</span>
                            <div class="certificate" style="height: 25px">
                                <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                            </div>
                        </li>
                    @elseif ($user->num_votes >= '30' && $user->num_votes < '100' ) <li
                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="text-secondary">Voting Junior</span>
                            <div class="certificate" style="height: 25px">
                                <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                            </div>
                            </li>
                        @elseif ($user->num_votes >= '100' && $user->num_votes < '200' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Voting Expert</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #fde64b"></i>
                                </div>
                                </li>
                            @elseif ($user->num_votes >= '200' && $user->num_votes < '500' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Voting Master</span>
                                    <div class="certificate" style="height: 25px">
                                        <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                                    </div>
                                    </li>
                                @elseif ($user->num_votes == '500')
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="text-secondary">Voting Grandmaster</span>
                                        <div class="certificate" style="height: 25px">
                                            <i class="fas fa-certificate" style="color: #2aa493"></i>
                                        </div>
                                    </li>
                    @endif

                    @if ($user->num_answers >= '10' && $user->num_answers < '30')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="text-secondary">Answering Newbie</span>
                            <div class="certificate" style="height: 25px">
                                <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                            </div>
                        </li>
                    @elseif ($user->num_answers >= '30' && $user->num_answers < '50' ) <li
                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="text-secondary">Answering Junior</span>
                            <div class="certificate" style="height: 25px">
                                <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                            </div>
                            </li>
                        @elseif ($user->num_answers >= '50' && $user->num_answers < '100' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Answering Expert</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #fde64b"></i>
                                </div>
                                </li>
                            @elseif ($user->num_answers >= '100' && $user->num_answers < '200' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Answering Master</span>
                                    <div class="certificate" style="height: 25px">
                                        <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                                    </div>
                                    </li>
                                @elseif ($user->num_answers == '200')
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="text-secondary">Answering Grandmaster</span>
                                        <div class="certificate" style="height: 25px">
                                            <i class="fas fa-certificate" style="color: #2aa493"></i>
                                        </div>
                                    </li>
                    @endif

                    @if ($user->num_questions >= '2' && $user->num_questions < '10')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="text-secondary">Questioning Newbie</span>

                            <div class="certificate" style="height: 25px">
                                <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                            </div>
                        </li>
                    @elseif ($user->num_questions >= '10' && $user->num_questions < '20' ) <li
                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="text-secondary">Questioning Junior</span>

                            <div class="certificate" style="height: 25px">
                                <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                            </div>
                            </li>
                        @elseif ($user->num_questions >= '20' && $user->num_questions < '50' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Questioning Expert</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #fde64b"></i>
                                </div>
                                </li>
                            @elseif ($user->num_questions >= '50' && $user->num_questions < '100' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Questioning Master</span>
                                    <div class="certificate" style="height: 25px">
                                        <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                                    </div>
                                    </li>
                                @elseif ($user->num_questions == '100')
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="text-secondary">Questioning Grandmaster</span>
                                        <div class="certificate" style="height: 25px">
                                            <i class="fas fa-certificate" style="color: #2aa493"></i>
                                        </div>
                                    </li>
                    @endif

                    @if ($user->num_comments >= '20' && $user->num_comments < '50')
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="text-secondary">Commenting Newbie</span>
                            <div class="certificate" style="height: 25px">
                                <i class="fas fa-certificate" style="color: #e4f6f8"></i>
                            </div>
                        </li>
                    @elseif ($user->num_comments >= '50' && $user->num_comments < '70' ) <li
                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <span class="text-secondary">Commenting Junior</span>
                            <div class="certificate" style="height: 25px">
                                <i class="fas fa-certificate" style="color: #ffc0cb"></i>
                            </div>
                            </li>
                        @elseif ($user->num_comments >= '70' && $user->num_comments < '100' ) <li
                                class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <span class="text-secondary">Commenting Expert</span>
                                <div class="certificate" style="height: 25px">
                                    <i class="fas fa-certificate" style="color: #fde64b"></i>
                                </div>
                                </li>
                            @elseif ($user->num_comments >= '100' && $user->num_comments < '200' ) <li
                                    class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    <span class="text-secondary">Commenting Master</span>
                                    <div class="certificate" style="height: 25px">
                                        <i class="fas fa-certificate" style="color: #ff9d5c"></i>
                                    </div>
                                    </li>
                                @elseif ($user->num_comments == '200')
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <span class="text-secondary">Commenting Grandmaster</span>
                                        <div class="certificate" style="height: 25px">
                                            <i class="fas fa-certificate" style="color: #2aa493"></i>
                                        </div>
                                    </li>
                    @endif
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
                    </li>
                    </ul>
                    </div>
                    </div>
                    @endif
                    @if ($idAuthUser === $user->id)
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="row">
                                    <div class="card-body">
                                        <h6 class="mb-9">My Questions </h6>
                                        &nbsp;

                                        @for ($numQuestion = 0; $numQuestion < count($userquestions); $numQuestion++)
                                            <div class="card mb-2">
                                                <div class="row">
                                                    <div class="col-sm-16">
                                                        <div class="card-body">

                                                            @if ($user->questions == '')
                                                                You haven't
                                                                done
                                                                any questions yet!
                                                            @else
                                                                <div class="content">
                                                                    <a
                                                                        href="{{ url('question/' . $userquestions[$numQuestion]->id . '/' . $question_titles[$numQuestion]) }}">
                                                                        <h2>{{ $userquestions[$numQuestion]->title }}
                                                                        </h2>
                                                                    </a>
                                                                    <p>{{ $userquestions[$numQuestion]->text }}</p>
                                                                    <div class="tags">
                                                                        @include('partials.tags', ['tags_string' =>
                                                                        $userquestions[$numQuestion]->tags])
                                                                    </div>
                                                                </div>
                                                                &nbsp;

                                                                <div class="thread">
                                                                    <a
                                                                        href="{{ url('question/' . $userquestions[$numQuestion]->id . '/' . $question_titles[$numQuestion]) }}">View
                                                                        question
                                                                    </a>
                                                                    <i class='fas fa-arrow-right'
                                                                        style='font-size:16px'></i>
                                                                </div>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    @else
                        <div class="row gutters-sm">
                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="row">
                                        <div class="card-body">
                                            <h6 class="mb-9">Questions made by {{ $user->username }}</h6>
                                            &nbsp;

                                            @for ($numQuestion = 0; $numQuestion < count($userquestions); $numQuestion++)
                                                <div class="card mb-3">
                                                    <div class="row">
                                                        <div class="card-body">
                                                            @if ($user->questions == '')
                                                                {{ $user->username }} hasn't any questions yet!
                                                            @else
                                                                <div class="content">
                                                                    <a
                                                                        href="{{ url('question/' . $userquestions[$numQuestion]->id . '/' . $question_titles[$numQuestion]) }}">
                                                                        <h2>{{ $userquestions[$numQuestion]->title }}
                                                                        </h2>
                                                                    </a>
                                                                    <p>{{ $userquestions[$numQuestion]->text }}</p>
                                                                    <div class="tags">
                                                                        @include('partials.tags', ['tags_string' =>
                                                                        $userquestions[$numQuestion]->tags])
                                                                    </div>
                                                                </div>
                                                                &nbsp;

                                                                <div class="thread">
                                                                    <a
                                                                        href="{{ url('question/' . $userquestions[$numQuestion]->id . '/' . $question_titles[$numQuestion]) }}">View
                                                                        question
                                                                    </a>
                                                                    <i class='fas fa-arrow-right'
                                                                        style='font-size:16px'></i>
                                                                </div>

                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endif

                    </div>
                    </div>


                    </div>

                    </div>


    </main>
@endsection
