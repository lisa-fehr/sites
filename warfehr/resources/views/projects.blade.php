@extends('layouts.app')
@section('title', 'Warfehr - Projects')
@section('header', 'Projects')
@section('content')

<p>
  <i class="fa fa-exclamation-triangle"></i>Twitter/X removed free api access. <a href="{{route('msg')}}">Go here to see current images</a
</p>
<p>
  <a href="https://twitter.com/warfehr/status/886775729052160000">Video demo</a> - created picture shows up on oled screen
</p>
<p>
  <a href="https://github.com/lisa-fehr/onion-microcontroller">Node script for Onion Omega2 Plus</a> - 
  shows the last image on my oled screen
</p>
<p>
  <a href="https://github.com/lisa-fehr/sites/tree/master/warfehr/packages/warfehr/omega_oled_msg">
    Laravel Package for this project
  </a>
</p>
{!!Form::warfehr_oled_form()!!}
@endsection
