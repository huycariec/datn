<!-- resources/views/client/blog-list.blade.php -->

@extends('app')

@section('content')

    <section class="breadcrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-contain">
                        <h2>Bài viết</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">Danh sách bài viết</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Start -->
    <section class="blog-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-4">
                <div class="col-xxl-9 col-xl-8 col-lg-7 order-lg-2">
                    <div class="row g-4">
                        @foreach($blogs as $blog)
                            <div class="col-12">
                            <div class="blog-box blog-list wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                                <div class="blog-image">
                                    <img src="{{ asset('storage/' . $blog->image) }}" class="blur-up lazyload" alt="{{ $blog->title }}">
                                </div>

                                <div class="blog-contain blog-contain-2">
                                    <div class="blog-label">
                                    <span class="time"><i data-feather="clock"></i> <span>{{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('d F, Y') }}</span></span>
                                    <span class="super"><i data-feather="user"></i> <span>{{ $blog->user->name }}</span></span>
                                    </div>
                                    <a href="blog-detail.html">
                                        <h3>{{ $blog->title }}</h3>
                                    </a>
                                    <p>{{ $blog->content }}</p>
                                </div>
                            </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection
