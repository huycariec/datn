<!-- latest jquery-->
<script src="{{ asset('assets/client/assets/js/jquery-3.6.0.min.js') }}"></script>

<!-- jquery ui-->
<script src="{{ asset('assets/client/assets/js/jquery-ui.min.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('assets/client/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/client/assets/js/bootstrap/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/client/assets/js/bootstrap/popper.min.js') }}"></script>

<!-- feather icon js-->
<script src="{{ asset('assets/client/assets/js/feather/feather.min.js') }}"></script>
<script src="{{ asset('assets/client/assets/js/feather/feather-icon.js') }}"></script>

<!-- Lazyload Js -->
<script src="{{ asset('assets/client/assets/js/lazysizes.min.js') }}"></script>

<!-- Slick js-->
<script src="{{ asset('assets/client/assets/js/slick/slick.js') }}"></script>
<script src="{{ asset('assets/client/assets/js/slick/slick-animation.min.js') }}"></script>
<script src="{{ asset('assets/client/assets/js/slick/custom_slick.js') }}"></script>

<!-- Auto Height Js -->
<script src="{{ asset('assets/client/assets/js/auto-height.js') }}"></script>

<!-- WOW js -->
<script src="{{ asset('assets/client/assets/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/client/assets/js/custom-wow.js') }}"></script>

<!-- script js -->
<script src="{{ asset('assets/client/assets/js/script.js') }}"></script>

<!-- theme setting js -->
<script src="{{ asset('assets/client/assets/js/theme-setting.js') }}"></script>

<script>
    // Kiểm tra xem thông báo có tồn tại hay không
    window.onload = function() {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        if (successMessage) {
            // Ẩn thông báo thành công sau 2 giây
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 2000);
        }

        if (errorMessage) {
            // Ẩn thông báo lỗi sau 2 giây
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 2000);
        }
    };
</script>
