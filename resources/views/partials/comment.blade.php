<div class="comment_block"  id="comment_{{ $comment->id }}" data-id={{ $comment->id }}>
    <div class="row messages">
    </div>
    <div id="content_{{$comment->id}}" class="comment row"  data-id={{$comment->id}} data-type="comment">
        <div class="col-md-4 comment_opt">
            @php
                $type = explode('/', $comment->user_path)[0];
                $userStatus;
                if ($comment->deleted) $userStatus = 'deleteduser';
                else $userStatus = 'notdeleteduser';
            @endphp
            @if ($userStatus === 'deleteduser')
                <div class="user">
                    @if ($type === 'images')
                        <img class="avatar" src={{asset($comment->user_path)}} alt="user profile picture" width="50" height="50"><br>
                    @else
                        <img class="avatar" src={{$comment->user_path}} alt="user profile picture" width="50" height="50"><br>
                    @endif
                    <span class="{{$userStatus}}" style="font-style: italic;"><small>Deleted User</small></span>
                </div>
            @else
                <div class="user">
                    @if($question->user_id === 1)
                        @if ($type === 'images')
                            <img class="avatar" src={{asset($comment->user_path)}} alt="user profile picture" width="50" height="50"><br>
                        @else
                            <img class="avatar" src={{$comment->user_path}} alt="user profile picture" width="50" height="50"><br>
                        @endif
                        <span class="deleteduser"><small>{{$comment->username}}</small></span>
                    @else
                        <a href="{{url('user/'.$comment->user_id)}}" style="text-decoration: none;">
                            @if ($type === 'images')
                                <img class="avatar" src={{asset($comment->user_path)}} alt="user profile picture" width="50" height="50"><br>
                            @else
                                <img class="avatar" src={{$comment->user_path}} alt="user profile picture" width="50" height="50"><br>
                            @endif
                            <span class="{{$userStatus}}"><small>{{$comment->username}}</small></span>
                        </a>
                    @endif     
                </div>
            @endif
            <div class="score">
                @if ($comment->votes === true)
                    @if ($userLoggedIn !== $comment->username && $userLoggedIn != null) 
                        <i class="fas fa-chevron-up canvote upcomment votedUp"></i>
                    @else
                        <i class="fas fa-chevron-up cannotvote"></i>
                    @endif
                @elseif ($comment->votes === false || $comment->votes === null)
                    @if ($userLoggedIn !== $comment->username && $userLoggedIn != null) 
                        <i class="fas fa-chevron-up canvote upcomment"></i>
                    @else
                        <i class="fas fa-chevron-up cannotvote"></i>
                    @endif   
                @endif  
                <span>{{$comment->score}}</span>
                @if ($comment->votes === false)
                    @if ($userLoggedIn !== $comment->username && $userLoggedIn != null) 
                        <i class="fas fa-chevron-down canvote downcomment votedDown"></i>
                    @else
                        <i class="fas fa-chevron-down cannotvote"></i>
                    @endif
                @elseif ($comment->votes === true || $comment->votes === null)
                    @if ($userLoggedIn !== $comment->username && $userLoggedIn != null) 
                        <i class="fas fa-chevron-down canvote downcomment"></i>
                    @else
                        <i class="fas fa-chevron-down cannotvote"></i>
                    @endif   
                @endif
            </div>
            <div class="signs" data-id="{{$comment->id}}">
                <div class="edit">
                    @if ($userLoggedIn === $comment->username)
                        <i class="fas fa-pencil-alt canedit"></i>
                    @endif
                </div>
                <div class="comment_reports">
                    @if($userLoggedIn != null)
                        @if ($userLoggedIn !== $comment->username &&  array_search($comment->id, $hasReportedList) === false)
                            <i  data-toggle="modal" data-target="#popupcomment{{$comment->id}}" class="far fa-flag canreport"></i>
                            @include('partials.report_popup', ['type' => "comment", 'id' => $comment->id])
                        @elseif($userLoggedIn !== $comment->username && $userStatus !== 'deleteduser')
                            <i class="far fa-flag cannotreport" style="display:inline-block;color:red"></i>
                        @endif
                    @endif
                </div>
                <div class="remove">
                    @if ($userLoggedIn === $comment->username)
                        <i class="far fa-trash-alt canremove"></i>
                    @else
                        <i class="far fa-trash-alt cannotremove"></i>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 card comment_body">
            <div class="card-body notedit" contenteditable='false'>
                <p class="card-text" style = "white-space: pre-wrap">{{$comment->text}}</p>
                <div class="date" contenteditable='false'>
                    <p style="margin-bottom: 0"><small style="color: grey"> Created at: {{$comment->created_at}}</small></p>
                    @if ($comment->created_at !== $comment->edited_at)    
                        <p style="margin-bottom: 0"><small style="color: grey">Edited at: {{$comment->edited_at}}</small></p>
                    @endif
                </div>
            </div>
            <div class="card-body edit" hidden>
                <form>
                    {{ csrf_field() }}
                    <div><label>Body: </label><textarea style="margin-top: 0.7em" cols="100" name="text" class="form-control" rows="5">{{$comment->text}}</textarea></div>
                    <div style="margin-top: 1em"><button class="btn btn-green" type="submit">Done</button><button class="btn btn-red" type="button">Cancel</button></div>
                </form>
            </div>
        </div>
    </div>
</div>