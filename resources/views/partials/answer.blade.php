<div class="answer_block" id="answer_{{ $answer->id }}" data-id={{ $answer->id }}>
    <div class="row messages">
    </div>
    <div id="content_{{ $answer->id }}" class="answer row" data-id={{ $answer->id }} data-type="answer">
        <div class="col-md-3 answer_opt">
            @php
                $type = explode('/', $answer->user_path)[0];
                $userStatus;
                if ($answer->deleted) {
                    $userStatus = 'deleteduser';
                } else {
                    $userStatus = 'notdeleteduser';
                }
            @endphp
            @if ($userStatus === 'deleteduser')
                <div class="user">
                    @if ($type === 'images')
                        <img class="avatar" src={{ asset($answer->user_path) }} alt="user profile picture" width="50"
                            height="50"><br>
                    @else
                        <img class="avatar" src={{ $answer->user_path }} alt="user profile picture" width="50"
                            height="50"><br>
                    @endif
                    <span class="{{ $userStatus }}" style="font-style: italic;"><small>Deleted User</small></span>
                </div>
            @else
                <div class="user">
                    @if ($question->user_id === 1)
                        @if ($type === 'images')
                            <img class="avatar" src={{ asset($answer->user_path) }} alt="user profile picture"
                                width="50" height="50"><br>
                        @else
                            <img class="avatar" src={{ $answer->user_path }} alt="user profile picture" width="50"
                                height="50"><br>
                        @endif
                        <span class="deleteduser"><small>{{ $answer->username }}</small></span>
                    @else
                        <a href="{{ url('user/' . $answer->user_id) }}" style="text-decoration: none;">
                            @if ($type === 'images')
                                <img class="avatar" src={{ asset($answer->user_path) }} alt="user profile picture"
                                    width="50" height="50"><br>
                            @else
                                <img class="avatar" src={{ $answer->user_path }} alt="user profile picture" width="50"
                                    height="50"><br>
                            @endif
                            <span class="{{ $userStatus }}"><small>{{ $answer->username }}</small></span>
                        </a>
                    @endif
                </div>
            @endif
            <div class="score">
                @if ($answer->votes === true)
                    @if ($userLoggedIn !== $answer->username && $userLoggedIn != null)
                        <i class="fas fa-chevron-up canvote upanswer votedUp"></i>
                    @else
                        <i class="fas fa-chevron-up cannotvote"></i>
                    @endif
                @elseif ($answer->votes === false || $answer->votes === null)
                    @if ($userLoggedIn !== $answer->username && $userLoggedIn != null)
                        <i class="fas fa-chevron-up canvote upanswer"></i>
                    @else
                        <i class="fas fa-chevron-up cannotvote"></i>
                    @endif
                @endif
                <span>{{ $answer->score }}</span>
                @if ($answer->votes === false)
                    @if ($userLoggedIn !== $answer->username && $userLoggedIn != null)
                        <i class="fas fa-chevron-down canvote downanswer votedDown"></i>
                    @else
                        <i class="fas fa-chevron-down cannotvote"></i>
                    @endif
                @elseif ($answer->votes === true || $answer->votes === null)
                    @if ($userLoggedIn !== $answer->username && $userLoggedIn != null)
                        <i class="fas fa-chevron-down canvote downanswer"></i>
                    @else
                        <i class="fas fa-chevron-down cannotvote"></i>
                    @endif
                @endif
            </div>
            <div class="signs" data-id="{{ $answer->id }}">
                <div class="edit">
                    @if ($userLoggedIn === $answer->username)
                        <i class="fas fa-pencil-alt canedit"></i>
                    @endif
                </div>
                <div class="star">
                    @if ($answer->selected)
                        @if ($userLoggedIn === $question->username)
                            <i class="fas fa-star canelect elected"></i>
                        @else
                            <i class="fas fa-star cannotelect elected"></i>
                        @endif
                    @else
                        @if ($userLoggedIn === $question->username)
                            <i class="fas fa-star canelect"></i>
                        @else
                            <i class="fas fa-star cannotelect"></i>
                        @endif
                    @endif
                </div>
                <div class="answer_reports">
                    @if ($userLoggedIn != null)
                        @if ($userLoggedIn !== $answer->username && array_search($answer->id, $hasReportedList) === false)
                            <i data-toggle="modal" data-target="#popupanswer{{ $answer->id }}"
                                class="far fa-flag canreport"></i>
                            @include('partials.report_popup', ['type' => "answer", 'id' => $answer->id])
                        @elseif($userLoggedIn !== $answer->username && $userStatus !== 'deleteduser')
                            <i class="far fa-flag cannotreport" style="display:inline-block;color:red"></i>
                        @endif
                    @endif
                </div>
                <div class="remove">
                    @if ($userLoggedIn === $answer->username)
                        <i class="far fa-trash-alt canremove"></i>
                    @else
                        <i class="far fa-trash-alt cannotremove"></i>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-7 card answer_body">
            <div class="card-body notedit" contenteditable='false'>
                <p class="card-text" style="white-space: pre-wrap">{{ $answer->text }}</p>
                <div class="date" contenteditable='false'>
                    <p style="margin-bottom: 0"><small style="color: grey"> Created at: {{ $answer->created_at }}</small></p>
                    @if ($answer->created_at !== $answer->edited_at)
                        <p style="margin-bottom: 0"><small style="color: grey">Edited at: {{ $answer->edited_at }}</small></p>
                    @endif
                </div>
            </div>
            <div class="card-body edit" hidden>
                <form>
                    {{ csrf_field() }}
                    <div><label>Body: </label><textarea style="margin-top: 0.7em" cols="100" name="text"
                            class="form-control" rows="5">{{ $answer->text }}</textarea></div>
                    <div style="margin-top: 1em"><button class="btn btn-green" type="submit">Done</button><button
                            type="button" class="btn btn-red">Cancel</button></div>
                </form>
            </div>
        </div>
    </div>
    <section class="comments">
        @foreach ($comments as $comment)
            @if ($comment->answer_id === $answer->id)
                @include('partials.comment')
            @endif
        @endforeach
    </section>
    @if ($userLoggedIn != null && $question->closed == false)
        <div class="row input_row add_comment_form">
            <div class="post_comment col-md-6 offset-md-4">
                <form class="post_comment" method="POST"
                    action="{{ route('addComment', [$answer->id]) }}">
                    {{ csrf_field() }}
                    <input hidden type="text" name="id_question" value="{{$answer->question_id}}">
                    <textarea name="text_comment{{ $answer->id }}" class="form-control"
                        id="exampleFormControlTextarea1" rows="2" cols="70"
                        placeholder="Comment this answer"></textarea>
                    @if ($errors->has('text_comment' . $answer->id))
                        <span class="error">
                            A comment can not be empty!
                        </span>
                    @endif
                    <button class="btn btn-default button_small">Post Comment</button>
                </form>
            </div>
        </div>
    @endif
</div>
