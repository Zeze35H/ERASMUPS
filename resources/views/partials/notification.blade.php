                <div class="card notification">
                    <div class="card-header">
                        {{$notification[1][0]}}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{$notification[0]->text}}</p>
                        @php
                        $time = substr($notification[0]->timestamp, 0, strpos($notification[0]->timestamp, '.'))
                        @endphp
                        <p class="card-text">{{$time}}</p>
                        @if($notification[1][0] !== "Mod" && $notification[1][0] !== "Report") 
                            @if($notification[1][0] === "Tag")
                            <a href="{{url($notification[1][1])}}" class="btn btn-outline-primary">See Question</a>
                            @elseif($notification[1][0] === "Favourite Answer" || $notification[1][0] === "Answer")
                            <a href="{{url($notification[1][1])}}" class="btn btn-outline-primary">See Answer</a>
                            @else
                            <a href="{{url($notification[1][1])}}" class="btn btn-outline-primary">See {{$notification[1][0]}}</a>
                            @endif
                        @endif
                    </div>
                </div>
      
