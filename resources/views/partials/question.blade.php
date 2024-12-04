<div class ="question" data-id={{$questions[$numQuestion]->id}}>
    <div class="content">
        <h2><a href="{{url('question/'. $questions[$numQuestion]->id. '/' . $question_titles[$numQuestion])}}">{{$questions[$numQuestion]->title}}</a></h2>
        <p>{{$questions[$numQuestion]->text}}</p>
        <div class="tags">
            @include('partials.tags', ['tags_string' => $questions[$numQuestion]->tags, 'close' => false])
        </div>
    </div>
    <div class="thread">
        <a href="{{url('question/' . $questions[$numQuestion]->id . '/' . $question_titles[$numQuestion])}}">View question </a>
        <i class='fas fa-arrow-right' style='font-size:16px'></i>
    </div>
</div>