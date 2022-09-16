@extends('layout')
@section('title')
    All Albums
@endsection
@section('content')
<div class="text-center" >
    <h1>All Albums</h1>
    <a type="button" class="btn btn-dark show-popup">Add Album</a>
</div>

{{-- @if (!$albums->All())
    <h3 class="text-center mt-5" >Empty album</h3>
@endif --}}
<div class="mt-5 d-flex flex-wrap gap-5" >
    @foreach ($albums as $album)
    <div class="card mb-3" style="width: 20rem; width: 20rem;
    background-color: transparent;
    border: none;">
        <img src="{{asset("uploads/albums/$album->cover")}}" class="card-img-top" alt="..." style="
        height: 300px;
        width: 250px;">
        <div class="card-body">
          <h5 class="card-title">{{$album->name}}</h5>
          <a href="{{ route('album.show',$album->id) }}" class="btn btn-primary">Show</a>
        </div>
    </div>
    @endforeach
</div>
{{-- Start popup --}}
<div class="popup">
    <form method="POST" action="{{ route('album.store') }}" enctype="multipart/form-data" >
        @csrf
        <button type="button" class="btn-close close" aria-label="Close"></button>
        <div class="mb-3">
            <label for="album" class="form-label">Album name</label>
            <input required autocomplete="none" type="text" name="name" class="form-control" id="album" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Album Cover</label>
            <input required  class="form-control" name="cover" type="file" id="formFile">
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
{{-- END   popup --}}
@endsection