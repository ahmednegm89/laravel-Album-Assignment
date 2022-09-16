@extends('layout')
@section('title')
    All Albums
@endsection
@section('content')
<div class="d">
    <a href="{{route('album.index')}}" type="button" class="btn btn-dark">Back to all albums</a>
</div>
<div class="text-center" >
    <h1> {{$album->name}} Album </h1>
    <img src="{{asset("uploads/albums/$album->cover")}}" class="card-img-top" alt="..." style="
    height: 90px;
    width: 90px;
    border-radius:50%;">
    <a type="button" class="btn btn-secondary show-edit-popup">Edit</a>
    @if (!$album->images->All())
    <a type="button" href="{{route('album.delete',$album->id)}}" class="btn btn-danger link-button show-delete-album-popup">Delete Album</a>
    @endif
    @if ($album->images->All())
    <a type="button" class="btn btn-danger link-button show-delete-album-popup">Delete Album</a>
    @endif
    <a type="button" class="btn btn-success  show-add-image-popup ">Add images</a>
</div>
{{-- album images --}}

@if (!$album->images->All())
<div id="Empty">
    <h3 class="text-center mt-5" >Empty album</h3>
</div>
@endif
<div class="mt-5 d-flex flex-wrap gap-5">
@foreach ($album->images->All() as $img)
    <div class="d-flex flex-column " >
        <img src="{{asset("uploads/imgs/$img->name")}}" class="card-img-top" alt="..." style="
        height: 350px;
        width: 240px;">
    <h4>{{ pathinfo($img->name,PATHINFO_FILENAME) }}</h4>
    <a href="{{ route('image.delete',$img->id) }}"  type="button" class="btn btn-danger mt-3">Delete Image</a>
    </div>
    @endforeach
</div>
{{-- End album images --}}
{{-- Start popup --}}
<div class="edit-popup">
    <form method="POST" action="{{ route('album.update',$album->id) }}" enctype="multipart/form-data" >
        @csrf
        <button type="button" class="btn-close edit-close" aria-label="Close"></button>
        <div class="mb-3">
            <label for="album" class="form-label">Update album name</label>
            <input required autocomplete="none" type="text" name="name" class="form-control" id="album" value="{{$album->name}}" >
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Update album cover (Don't if you won't change it)</label>
            <input class="form-control" name="cover" type="file" id="formFile">
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<div class="add-image-popup">
    <form method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data" >
        @csrf
        <button type="button" class="btn-close add-image-close" aria-label="Close"></button>
        <input type="hidden" name="album_id" value="{{$album->id}}">
        <div class="mb-3">
            <label for="image" class="form-label">image name</label>
            <input required autocomplete="none" type="text" name="name" class="form-control" id="image"" >
        </div>
        <div class="mb-3">
            <label for="formFile" class="form-label">Add images to album </label>
            <input required class="form-control" name="img" type="file" id="formFile">
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<div class="delete-album-popup">
    <form method="POST">
        @csrf
        <button type="button" class="btn-close delete-album-close" aria-label="Close"></button>
        <h4 style="font-weight: bold;color:red" >This album contains images !!</h4>
        <br>
        <a href="{{route('album.delete',$album->id)}}" type="submit" class="btn btn-danger">Delete any way (with images)</a>
        <h6 class="mt-3" >move images to another album then delete it </h6>
    </form>
    <form action="{{route('album.move')}}">
        @csrf
        <input type="hidden" name="from_album" value="{{$album->id}}">
        <select name="album_id" class="form-select" aria-label="Default select example">
            @if ($albums)
            @foreach ($albums as $album)
            <option value="{{$album->id}}">{{$album->name}}</option>
            @endforeach
            @endif
        </select>
        <button type="submit" class="btn btn-success mt-5">move</button>
    </form>
</div>
{{-- END   popup --}}
@endsection


@section('script')
    <script>
        const empty = document.getElementById('Empty');
        if (empty) {

        console.log('✅ Element is empty');
        } else {

            $(".show-delete-album-popup").click(function () {
                $(".delete-album-popup").fadeIn();
            });

            $(".delete-album-popup .delete-album-close").click(function () {
                $(".delete-album-popup").fadeOut();
            });


        console.log('⛔️ Element is NOT empty');
        }

    </script>
@endsection