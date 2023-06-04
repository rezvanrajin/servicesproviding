
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <meta name="meta_title" content="@if($seosetting) {{$seosetting->meta_title}} @endif">
        <meta name="meta_keyword" content="@if($seosetting){{$seosetting->meta_keyword}} @endif">
        <meta name="meta_description" content="@if($seosetting) {{$seosetting->meta_description}} @endif"> --}}
        <meta name="api-token" content="{{ \Session::get('token') }}">
        <meta name="user-id" content="{{ \Session::get('user') }}">
        <title>Handyman | {{$title}}</title>
        <!-------- css links start -------->
        @include('layout.front_layouts._layout.head')
        @yield('css')
        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
        <script type="text/javascript">
            Ziggy.url = "{{ url('/') }}";
                @if ($_SERVER['SERVER_PORT'] != 80 || $_SERVER['SERVER_PORT'] != 443)
                    Ziggy.port = {{ $_SERVER['SERVER_PORT'] }};
                @endif
        </script>
        <!---------- css links end -------->
    </head>
    <body>

        
        @yield("content")
        <!-- Back to Top Button Starts -->
        <div class="back-to-top">
            <a href="#"><i class="fa-solid fa-angle-up"></i> </a>
        </div>
        <!-- Back to Top Button Ends -->

        <!-- Footer Starts -->
        @include('layout.front_layouts._layout.footer')
        <!-- Footer Ends -->

        <!---------- js links ---------->
        @include('layout.front_layouts._layout.script')

        @yield('js_vendor')
        @yield('js_page')
            {{-- js link end --}}
        <script src="{{asset('frontend/custom_js/menuBar.js')}}"></script> 

    </body>
</html>
