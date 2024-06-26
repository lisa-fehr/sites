<!DOCTYPE html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css" type="text/css" media="screen">
    <link rel='stylesheet' media='only screen and (max-width: 775px)' href='/css/style-small.css'>
    <link rel="shortcut icon" type="image/gif" href="/images/favicon.gif">
    <link rel="apple-touch-icon" href="/images/iPhone-icon.png">
    <link rel="stylesheet" href="/css/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type='text/css' href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css">
    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body id="top">
    <nav>
      <ul>
        <li>
          <a href="{{route('projects')}}" 
          @if(Route::current()->getName() == 'projects')
            class="active"
          @endif
          >
            <i class="fa fa-file-text"></i>Projects
          </a>
        </li>
        <li>
          <a href="{{route('home')}}" 
          @if(Route::current()->getName() == 'home')
            class="active"
          @endif
          >
            <i class="fa fa-home"></i>Home
          </a>
        </li>
      </ul>
    </nav>
    <div id="blur">
      <div id="container">
        <header></header>
        <a href="{{route('home')}}"><img src="/images/lisafehr-logo.png" width="239" height="95" alt="Lisa Fehr" id="logo"></a>
        <div id="tagline" class="button">Web Developer</div>
        <section>
          @if (View::hasSection('header'))
            <h1>@yield('header')</h1>
          @endif
        
          @if (count($errors) > 0)
            <div class="alert alert-error">
              <strong>Please correct these errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
          @yield('content')
        </section>
        <footer>
          <a class="alignleft button" rel="nofollow" href="http://validator.w3.org/check?uri={{urlencode("http://warfehr.com".$_SERVER['REQUEST_URI'])}}">
            <i class="fa fa-check-square-o"></i>W3C valid
          </a>
          <a href="#top" class="alignright button">Back to top</a>
          <div id="copyright">&copy; {{date("Y")}} Lisa Fehr</div>
          <ul id="bottom-nav">
            <li>
              <a href="{{route('home')}}">Home</a>
            </li>
            <li>
              <a href="{{route('projects')}}">Projects</a>
            </li>
          </ul>
        </footer>
      </div>
    </div>
  </body>
</html>