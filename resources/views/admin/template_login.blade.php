<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>{{ isset($title) ? $title : '' }} {{ isset($title) ? ' | '. $admin_app : $admin_app }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets.admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets.admin/font-awesome/4.2.0/css/font-awesome.min.css') }}" />

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('assets.admin/fonts/fonts.googleapis.com.css') }}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('assets.admin/css/ace.min.css') }}" />

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="{{ asset('assets.admin/css/ace-part2.min.css') }}" />
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('assets.admin/css/ace-rtl.min.css') }}" />

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="{{ asset('assets.admin/css/ace-ie.min.css') }}" />
    <![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="{{ asset('assets.admin/js/html5shiv.min.js') }}"></script>
    <script src="{{ asset('assets.admin/js/respond.min.js') }}"></script>
    <![endif]-->
  </head>

  <body class="login-layout">
    <div class="main-container">
      <div class="main-content">
        <div class="row">

          <div class="col-sm-10 col-sm-offset-1">

            <div class="login-container">
              <div class="center">
                <h1>
                  <i class="ace-icon fa fa-leaf green"></i>
                  <span class="red">Apanel</span>
                  <span class="white" id="id-text2">Apps</span>
                </h1>
                <h4 class="blue" id="id-company-text">&copy; {{ $company_name }}</h4>
              </div>

              <!-- [notifications] -->
              @include('admin.partials.notification')
              <!-- [notifications] -->

              <div class="space-6"></div>

              <div class="position-relative">
                @yield('body')
              </div><!-- /.position-relative -->

              <div class="navbar-fixed-top align-right">
                <br />
                &nbsp;
                <a id="btn-login-dark" href="#">Dark</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-blur" href="#">Blur</a>
                &nbsp;
                <span class="blue">/</span>
                &nbsp;
                <a id="btn-login-light" href="#">Light</a>
                &nbsp; &nbsp; &nbsp;
              </div>
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    @yield('scripts')

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="{{ asset('assets.admin/js/jquery.2.1.1.min.js') }}"></script>

    <!-- <![endif]-->

    <!--[if IE]>
<script src="{{ asset('assets.admin/js/jquery.1.11.1.min.js') }}"></script>
<![endif]-->

    <!--[if !IE]> -->
    <script type="text/javascript">
      window.jQuery || document.write("<script src='{{ asset('assets.admin/js/jquery.min.js') }}'>"+"<"+"/script>");
    </script>

    <!-- <![endif]-->

    <!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='{{ asset('assets.admin/js/jquery1x.min.js') }}'>"+"<"+"/script>");
</script>
<![endif]-->
    <script type="text/javascript">
      if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets.admin/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
    </script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {
       $(document).on('click', '.toolbar a[data-target]', function(e) {
        e.preventDefault();
        var target = $(this).data('target');
        $('.widget-box.visible').removeClass('visible');//hide others
        $(target).addClass('visible');//show target
       });
      });
      
      
      
      //you don't need this, just used for changing background
      jQuery(function($) {
       $('#btn-login-dark').on('click', function(e) {
        $('body').attr('class', 'login-layout');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'blue');
        
        e.preventDefault();
       });
       $('#btn-login-light').on('click', function(e) {
        $('body').attr('class', 'login-layout light-login');
        $('#id-text2').attr('class', 'grey');
        $('#id-company-text').attr('class', 'blue');
        
        e.preventDefault();
       });
       $('#btn-login-blur').on('click', function(e) {
        $('body').attr('class', 'login-layout blur-login');
        $('#id-text2').attr('class', 'white');
        $('#id-company-text').attr('class', 'light-blue');
        
        e.preventDefault();
       });
       
      });
    </script>
  </body>
</html>

