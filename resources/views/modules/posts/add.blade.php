@extends('includes.body')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Add Notification</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('backend/notification') }}" class="create-form form form-horizontal" method="POST">
                @csrf
                <div class="form-group form-row">
                    <div class="col-12 col-md-8">
                        <label for="FormControlStoryTitle">Story Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" id="FormControlStoryTitle" placeholder="Story Title">
                    </div>
                    <div class="col-12 col-md">
                        <label for="product_id" class="control-label">Product</label>
                        <select name="product" id="product_id" class="select2 form-control">
                            @foreach($product as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label for="FormControlStoryLink">Story Link</label>
                    <input type="text" name="link" class="form-control" value="{{ old('link') }}" id="FormControlStoryLink" placeholder="Story Link">
                </div>
                <div class="form-group">
                    <label for="FormControlStoryThumbnail">Story Thumbnail</label>
                    <input type="text" name="thumbnail" class="form-control" value="{{ old('thumbnail') }}" id="FormControlStoryThumbnail" placeholder="Story Thumbnail">
                </div>

                <div class="form-group">
                    <label for="FormControlStorySummary">Story Summary</label>
                    <textarea class="form-control editor" name="summary" id="FormControlStorySummary" >{{ old('summary') }}</textarea>
                </div>
                <div class="form-group form-row">
                    <button class="btn btn-dark ml-auto">
                        Post Notification
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('header')

@endsection
@section('footer')

@endsection
