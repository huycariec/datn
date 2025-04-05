<!DOCTYPE html>
<html lang="en" dir="ltr">


<!-- Mirrored from themes.pixelstrap.com/fastkart/back-end/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 10 Feb 2025 06:28:00 GMT -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Fastkart admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Fastkart admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="/assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trang quản trị viên</title>
    @yield('css')

    @include("admin.inc.style")
</head>

<body>
    @include("admin.inc.nav")

    <!-- Page Header Ends-->

    <!-- Page Body Start-->
    <!-- Page Sidebar Start-->
    @include("admin.inc.sidebar")

    <!-- Page Sidebar Ends-->

    <!-- index body start -->
    @yield("content")


    <!-- footer start-->
    @include("admin.inc.footer")
    <!-- footer End-->
    </div>
    <!-- index body end -->

    </div>
    <!-- Page Body End -->
    </div>
    <!-- page-wrapper End-->

    <!-- Modal Start -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="staticBackdropLabel">Logging Out</h5>
                    <p>Are you sure you want to log out?</p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="button-box">
                        <button type="button" class="btn btn--no" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn  btn--yes btn-primary">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stack("modal")
    <!-- Modal End -->
    @include("admin.inc.script")
    @include('admin.inc.notification')
    @stack("script")
    @yield('js-custom')

</body>

</html>
