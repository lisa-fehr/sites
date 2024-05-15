@extends('layouts.app')
@section('title', 'Warfehr - Web Developer: Lisa Fehr')
@section('content')

<div class="box">
  <div class="profile vcard">
    <h1 class="fn">Lisa Fehr</h1>
    <p><a href="mailto:lisa@warfehr.com" class="email"><i class="fa fa-envelope-o"></i>lisa@warfehr.com</a></p>

    <p class="adr"><span class="locality">Waterloo</span>, <span class="region">ON</span></p>
    <br>
    <h2>Education:</h2>
    <p class="note">Bachelor of Science in Computer Science</p>
    <br>
    <h2>Network:</h2>
    <p id="network">
      <a href="https://twitter.com/lisa_warfehr" class="url"><i class="fa fa-twitter"></i></a>
      <a href="https://github.com/lisa-fehr" class="url"><i class="fa fa-github"></i></a>
      <a href="https://www.linkedin.com/in/lisafehr" class="url"><i class="fa fa-linkedin-square"></i></a>
    </p>
  </div>
  <br>
  <div class="tech">
    <h2>Tech:</h2>
    <div id="technologies" class="fa">
      <i class="devicon-linux-plain"></i><i class="devicon-apache-plain"></i><i class="devicon-mysql-original"></i><i class="devicon-php-plain"></i>
      <i class="devicon-html5-plain"></i><i class="devicon-css3-plain"></i><i class="devicon-javascript-plain"></i><i class="devicon-jquery-plain-wordmark"></i><i class="devicon-bootstrap-plain"></i>
      <i class="devicon-git-plain"></i><i class="devicon-github-original-wordmark"></i>
      <i class="devicon-wordpress-plain"></i>
      <i class="devicon-laravel-original"></i><i class="devicon-vuejs-plain-wordmark"></i><i class="devicon-typescript-plain"></i><i class="devicon-sass-original"></i><i class="devicon-phpstorm-plain"></i>
      <i class="devicon-rails-plain-wordmark"></i><i class="devicon-ruby-plain"></i><i class="devicon-rspec-plain-wordmark"></i><i class="devicon-rubymine-plain"></i>
      <i class="devicon-postman-plain"></i><i class="devicon-jest-plain"></i><i class="devicon-cypressio-plain-wordmark"></i><i class="devicon-cucumber-plain"></i>
      <i class="devicon-notion-plain"></i>
    </div>
  </div>
</div>
<div class="intro">
  <p>In addition to professional years, I have freelance experience with remote teams prior to my degree.</p>
  <h2>Recent Skills</h2>
  <p>See my <a href="https://www.linkedin.com/in/lisafehr">LinkedIn</a> for more details</p>
  <ul>
    <li>Optimization and refactoring of large legacy applications</li>
    <li>Test-Driven Development</li>
    <li>Performing code reviews and implementing suggestions</li>
    <li>Follow PSR coding standards</li>
    <li>Strive to meet deadlines</li>
    <li>Accustom to frequent releases of large features and overlapping tasks with other teammates</li>
    <li>Mostly backend but familiar with mockups, web standards, accessibility issues, responsive design, css, and javascript</li>
    <li>Remote work experience, as well as in office</li>
  </ul>
</div>
<br class="clear">
@endsection