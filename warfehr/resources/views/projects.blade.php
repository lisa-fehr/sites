@extends('layouts.app')
@section('title', 'Warfehr - Projects')
@section('header', 'Projects')
@section('content')
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
