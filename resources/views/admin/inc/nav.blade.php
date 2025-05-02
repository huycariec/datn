 <!-- tap on top start -->
 <div class="tap-top">
     <span class="lnr lnr-chevron-up"></span>
 </div>
 <!-- tap on tap end -->

 <!-- page-wrapper Start-->
 <div class="page-wrapper compact-wrapper" id="pageWrapper">
     <!-- Page Header Start-->
     <div class="page-header">
         <div class="header-wrapper m-0">
             <div class="header-logo-wrapper p-0">
                 <div class="logo-wrapper">
                     <a href="index.html">
                         <img class="img-fluid main-logo" src="/assets/images/logo/1.png" alt="logo">
                         <img class="img-fluid white-logo" src="/assets/images/logo/1-white.png" alt="logo">
                     </a>
                 </div>
                 <div class="toggle-sidebar">
                     <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
                     <a href="index.html">
                         <img src="/assets/images/logo/1.png" class="img-fluid" alt="">
                     </a>
                 </div>
             </div>
             <div class="nav-right col-6 pull-right right-header p-0">
                 <ul class="nav-menus">
                     <li>
                         <span class="header-search">
                             <i class="ri-search-line"></i>
                         </span>
                     </li>
                     <li class="profile-nav onhover-dropdown pe-0 me-0">
                         <div class="media profile-media">
                             <img class="user-profile rounded-circle"
                                 src="{{ Auth::user()->profile?->avatar ? asset('storage/image/' . Auth::user()->profile->avatar) : '/assets/images/user_placeholder_image.jpg' }}"
                                 alt="Avatar">
                             <div class="user-name-hide media-body">
                                 <span>{{Auth::user()->name}}</span>
                                 <p class="mb-0 font-roboto">Quản trị viên<i class="middle ri-arrow-down-s-line"></i></p>
                             </div>
                         </div>
                         <ul class="profile-dropdown onhover-show-div">
                             <li>
                                 <a href="{{route('admin.profile')}}">
                                     <i data-feather="users"></i>
                                     <span>Thông tin cá nhân</span>
                                 </a>
                             </li>
                             <li>
                                 <a href="{{ route('orders.index') }}">
                                     <i data-feather="archive"></i>
                                     <span>Đơn hàng mới</span>
                                 </a>
                             </li>
                             <li>
                                 <a data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                     href="javascript:void(0)">
                                     <i data-feather="log-out"></i>
                                     <span>Đăng xuất</span>
                                 </a>
                             </li>
                         </ul>
                     </li>
                 </ul>
             </div>
         </div>
     </div>
     <!-- Page Header Ends-->
