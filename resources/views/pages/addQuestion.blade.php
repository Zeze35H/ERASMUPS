@php
    $pageName = "Ask a Question";
@endphp

@extends('layouts.app')

<main id="ask_question">
    <div class="col-md-12">
        <h2>Ask a Question</h2><br>
        <div id="description">
            <p>Don't forget to include all the information someone would need to answer your question!</p>
        </div>
        <form method="POST" acttion="{{ route('addQuestion') }}" enctype="multipart/form-data">            
            {{ csrf_field() }}

            <div>
                <label>Title *</label>
                <input name="title" type="text" class="form-control" placeholder="Title of your question" required value='{{old('title')}}'>
                @if ($errors->has('title'))
                    <span class="error">
                        {{ $errors->first('title') }}
                    </span>
                @endif  
            </div>
            <div>
                <label>Body *</label>
                <textarea name="text" required class="form-control" rows="5" placeholder="Insert your question here">{{old('text')}}</textarea>
                @if ($errors->has('text'))
                    <span class="error">
                        {{ $errors->first('text') }}
                    </span>
                @endif  
            </div>
            <div>
                <label>Media Attachment(s)</label>
                <div class="col-md-4">
                    <input name="image[]" type="file" class="file" multiple data-show-upload="true" data-show-caption="true"> 
                </div>
                @if ($errors->has('image.*'))
                    <span class="error">
                        You can only insert images(jpg, jpeg and png) with at most 5048KB
                    </span>
                @endif
            </div>
            <div>
                <label>Tags</label><br>
                <small style="color: grey; font-style:italic">* Using the right tags makes it easier for other to find and answer your question.</small><br>
                <small style="color: grey; font-style:italic">* Tags are separated by space, which means that words separated by space are diferent tags.</small><br>
                <small style="color: grey; font-style:italic;">* Your question can be related with a maximum of 10 tags.</small>
                <input style="margin-top: 0.7em" name="tags" type="text" class="form-control" placeholder="Insert up to 10 tags" value='{{old('tags')}}'>
                @if ($errors->has('numTags'))
                    <span class="error">
                        You can only insert a maximum of 10 tags
                    </span>
                @endif  
                @if ($errors->has('tagsArray.*'))
                    <span class="error">
                        A tag can only have a maximum of 25 letters and all must be different
                    </span>
                @endif  
            </div>
            <div id="buttons">
                <button id="submit" class="btn btn-default button_small" type="submit" name="submit_question">Submit question</button>
                <a id="cancel" class="btn btn-default button_small_red" type="button" name="cancel" href={{url('questions')}}>Cancel</a>
            </div>
        </form>
    </div>
</main>
