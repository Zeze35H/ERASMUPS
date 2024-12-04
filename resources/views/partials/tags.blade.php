@php
    $tags = explode(" ", $tags_string)
@endphp
@foreach($tags as $tag)
    @if($tag === "")
        @break
    @endif
    <button style="margin-top: 0.7em" type="button" class="btn btn-light btn-sm tag">
        <span>{{$tag}}</span>
    </button>
@endforeach