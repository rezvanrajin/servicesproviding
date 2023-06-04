<!DOCTYPE html>
<html lang="en" data-url-prefix="/" data-footer="true"
    @isset($html_tag_data)
    @foreach ($html_tag_data as $key => $value)
    data-{{ $key }}='{{ $value }}'
    @endforeach
@endisset>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- theme meta -->
    <meta name="api-token" content="{{ \Session::get('token') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="theme-name" content="focus" />
    <title>SB Admin 2 - Dashboard</title>

    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    @routes
    @include('layout.provider.layout.head')
    @yield('css')
</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layout.provider.layout.sidebar')

        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <div class="header" id="header" class="header-container d-flex"
                @isset($custom_nav_data) @foreach ($custom_nav_data as $key => $value)
                data-{{ $key }}="{{ $value }}"
                    @endforeach
                    @endisset>
            @include('layout.provider.layout.header')
            </div>
               
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
            
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
            @include('layout.provider.layout.footer')
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery vendor -->
    @include('layout.provider.layout.modal_settings')
    @include('layout.provider.layout.modal_search')
    @include('layout.provider.layout.script')
    @yield('js_vendor')
    @yield('js_page')
</body>




</html>
