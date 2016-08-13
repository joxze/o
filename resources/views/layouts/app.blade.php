<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="ooo" content="{{ csrf_token() }}">
    <title>O - @yield('title')</title>

    <link href="{{ asset('/assets/o/library/bootstrap-3.3.7/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/assets/o/js/jquery-ui-1.11.4.custom/jquery-ui.min.css') }}" rel="stylesheet">
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="{{ asset('/assets/o/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/o/library/bootstrap-3.3.7/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/o/js/jquery-ui-1.11.4.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/assets/o/js/piratesgridview.js') }}"></script>
    <script src="{{ asset('/assets/o/js/formmultiplerow.js') }}"></script>
    <script type="text/javascript">
        $(".datepicker").datepicker({
            defaultDate: "+1w",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            onClose: function( selectedDate ) {
            $( ".to" ).datepicker( "option", "minDate", selectedDate );
            }
        }).attr('readOnly', 'readOnly');;
    </script>
    @yield('script')
</body>
</html>
