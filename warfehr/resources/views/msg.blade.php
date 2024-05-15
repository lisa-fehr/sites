@extends('layouts.app')
@section('title', 'Warfehr - Projects Generated images')
@section('header', 'Projects')
@section('content')
<p>
  Back to <a href="{{route('projects')}}">Projects</a>
</p>
  @foreach($images as $image)
    <strong>Author:</strong> {{$image->author}}<br>
    <strong>Date:</strong> {{$image->created_at}} UTC<br>
    <img src="{{asset('images/' . $image->image)}}" style="width:100%" alt="Generated image"><br>
    <strong>Content:</strong>
    <pre style="overflow: auto;">{{chunk_split($image->content, $image->columns, "\n")}}</pre>
    <hr>
  @endforeach
@endsection
