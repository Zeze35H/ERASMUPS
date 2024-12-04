<div class="modal fade imagePopUpWindow" id="popupimage" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            @php
                $images = explode(" ", $question->question_path)
            @endphp
            @foreach($images as $image)
                @php
                    $type = explode('/', $image)[0];
                @endphp
                @if ($type === 'images')
                    <img src="{{asset($image)}}" alt="question_image">
                @else
                    <img src="{{$image}}" alt="question_image">
                @endif
            @endforeach
        </div>
    </div>
</div>