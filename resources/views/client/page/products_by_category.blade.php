@extends('app')

@section('content')
<section class="breadcrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-contain">
                    <h2>Shop Left Sidebar</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active">Shop Left Sidebar</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Poster Section Start -->
<section>
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="slider-1 slider-animate product-wrapper no-arrow">
                    <div>
                        <div class="banner-contain-2 hover-effect">
                            <img src="https://images.squarespace-cdn.com/content/v1/52c0509ae4b0330e4569351f/1715852225410-5B8IAIPQWOX7Q4GTWUPR/banner+Miu+Miu+Upcycled+2024_+Ana+Elisa+Brito.jpg?format=2500w" class="bg-img rounded-3 blur-up lazyload" alt="">
                            <div
                                class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                <div>
                                    <h2>Healthy, nutritious & Tasty Fruits & Veggies</h2>
                                    <h3>Save upto 50%</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="banner-contain-2 hover-effect">
                            <img src="../assets/images/shop/1.jpg" class="bg-img rounded-3 blur-up lazyload" alt="">
                            <div
                                class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                <div>
                                    <h2>Healthy, nutritious & Tasty Fruits & Veggies</h2>
                                    <h3>Save upto 50%</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="banner-contain-2 hover-effect">
                            <img src="../assets/images/shop/1.jpg" class="bg-img rounded-3 blur-up lazyload" alt="">
                            <div
                                class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                <div>
                                    <h2>Healthy, nutritious & Tasty Fruits & Veggies</h2>
                                    <h3>Save upto 50%</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Poster Section End -->

<!-- Shop Section Start -->
<section class="section-b-space shop-section">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-custom-3">
                <div class="left-box wow fadeInUp">
                    <div class="shop-left-sidebar">
                        <div class="back-button">
                            <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                        </div>

                        <div class="filter-category">
                            <div class="filter-title">
                                <h2>Filters</h2>
                                <a href="javascript:void(0)">Clear All</a>
                            </div>
                            <ul>
                                <li>
                                    <a href="javascript:void(0)">Vegetable</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Fruit</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Fresh</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Milk</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Meat</a>
                                </li>
                            </ul>
                        </div>

                        <div class="accordion custom-accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne">
                                        <span>Categories</span>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="form-floating theme-form-floating-2 search-box">
                                            <input type="search" class="form-control" id="search"
                                                placeholder="Search ..">
                                            <label for="search">Search</label>
                                        </div>

                                        <ul class="category-list custom-padding custom-height">
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="fruit">
                                                    <label class="form-check-label" for="fruit">
                                                        <span class="name">Fruits & Vegetables</span>
                                                        <span class="number">(15)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="cake">
                                                    <label class="form-check-label" for="cake">
                                                        <span class="name">Bakery, Cake & Dairy</span>
                                                        <span class="number">(12)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="behe">
                                                    <label class="form-check-label" for="behe">
                                                        <span class="name">Beverages</span>
                                                        <span class="number">(20)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="snacks">
                                                    <label class="form-check-label" for="snacks">
                                                        <span class="name">Snacks & Branded Foods</span>
                                                        <span class="number">(05)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="beauty">
                                                    <label class="form-check-label" for="beauty">
                                                        <span class="name">Beauty & Household</span>
                                                        <span class="number">(30)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="pets">
                                                    <label class="form-check-label" for="pets">
                                                        <span class="name">Kitchen, Garden & Pets</span>
                                                        <span class="number">(50)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="egg">
                                                    <label class="form-check-label" for="egg">
                                                        <span class="name">Eggs, Meat & Fish</span>
                                                        <span class="number">(19)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="food">
                                                    <label class="form-check-label" for="food">
                                                        <span class="name">Gourment & World Food</span>
                                                        <span class="number">(30)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="care">
                                                    <label class="form-check-label" for="care">
                                                        <span class="name">Baby Care</span>
                                                        <span class="number">(20)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="fish">
                                                    <label class="form-check-label" for="fish">
                                                        <span class="name">Fish & Seafood</span>
                                                        <span class="number">(10)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="marinades">
                                                    <label class="form-check-label" for="marinades">
                                                        <span class="name">Marinades</span>
                                                        <span class="number">(05)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="lamb">
                                                    <label class="form-check-label" for="lamb">
                                                        <span class="name">Mutton & Lamb</span>
                                                        <span class="number">(09)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="other">
                                                    <label class="form-check-label" for="other">
                                                        <span class="name">Port & other Meats</span>
                                                        <span class="number">(06)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="pour">
                                                    <label class="form-check-label" for="pour">
                                                        <span class="name">Pourltry</span>
                                                        <span class="number">(01)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="salami">
                                                    <label class="form-check-label" for="salami">
                                                        <span class="name">Sausages, bacon & Salami</span>
                                                        <span class="number">(03)</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                        <span>Food Preference</span>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="category-list custom-padding">
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="veget">
                                                    <label class="form-check-label" for="veget">
                                                        <span class="name">Vegetarian</span>
                                                        <span class="number">(08)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox" id="non">
                                                    <label class="form-check-label" for="non">
                                                        <span class="name">Non Vegetarian</span>
                                                        <span class="number">(09)</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                        <span>Price</span>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <div class="range-slider">
                                            <input type="text" class="js-range-slider" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSix">
                                        <span>Rating</span>
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="category-list custom-padding">
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox">
                                                    <div class="form-check-label">
                                                        <ul class="rating">
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                        </ul>
                                                        <span class="text-content">(5 Star)</span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox">
                                                    <div class="form-check-label">
                                                        <ul class="rating">
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                        </ul>
                                                        <span class="text-content">(4 Star)</span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox">
                                                    <div class="form-check-label">
                                                        <ul class="rating">
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                        </ul>
                                                        <span class="text-content">(3 Star)</span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox">
                                                    <div class="form-check-label">
                                                        <ul class="rating">
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                        </ul>
                                                        <span class="text-content">(2 Star)</span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox">
                                                    <div class="form-check-label">
                                                        <ul class="rating">
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                        </ul>
                                                        <span class="text-content">(1 Star)</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                        <span>Discount</span>
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="category-list custom-padding">
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        <span class="name">upto 5%</span>
                                                        <span class="number">(06)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault1">
                                                    <label class="form-check-label" for="flexCheckDefault1">
                                                        <span class="name">5% - 10%</span>
                                                        <span class="number">(08)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault2">
                                                    <label class="form-check-label" for="flexCheckDefault2">
                                                        <span class="name">10% - 15%</span>
                                                        <span class="number">(10)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault3">
                                                    <label class="form-check-label" for="flexCheckDefault3">
                                                        <span class="name">15% - 25%</span>
                                                        <span class="number">(14)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault4">
                                                    <label class="form-check-label" for="flexCheckDefault4">
                                                        <span class="name">More than 25%</span>
                                                        <span class="number">(13)</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                        <span>Pack Size</span>
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <ul class="category-list custom-padding custom-height">
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault5">
                                                    <label class="form-check-label" for="flexCheckDefault5">
                                                        <span class="name">400 to 500 g</span>
                                                        <span class="number">(05)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault6">
                                                    <label class="form-check-label" for="flexCheckDefault6">
                                                        <span class="name">500 to 700 g</span>
                                                        <span class="number">(02)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault7">
                                                    <label class="form-check-label" for="flexCheckDefault7">
                                                        <span class="name">700 to 1 kg</span>
                                                        <span class="number">(04)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault8">
                                                    <label class="form-check-label" for="flexCheckDefault8">
                                                        <span class="name">120 - 150 g each Vacuum 2 pcs</span>
                                                        <span class="number">(06)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault9">
                                                    <label class="form-check-label" for="flexCheckDefault9">
                                                        <span class="name">1 pc</span>
                                                        <span class="number">(09)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault10">
                                                    <label class="form-check-label" for="flexCheckDefault10">
                                                        <span class="name">1 to 1.2 kg</span>
                                                        <span class="number">(06)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault11">
                                                    <label class="form-check-label" for="flexCheckDefault11">
                                                        <span class="name">2 x 24 pcs Multipack</span>
                                                        <span class="number">(03)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault12">
                                                    <label class="form-check-label" for="flexCheckDefault12">
                                                        <span class="name">2x6 pcs Multipack</span>
                                                        <span class="number">(04)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault13">
                                                    <label class="form-check-label" for="flexCheckDefault13">
                                                        <span class="name">4x6 pcs Multipack</span>
                                                        <span class="number">(05)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault14">
                                                    <label class="form-check-label" for="flexCheckDefault14">
                                                        <span class="name">5x6 pcs Multipack</span>
                                                        <span class="number">(09)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault15">
                                                    <label class="form-check-label" for="flexCheckDefault15">
                                                        <span class="name">Combo 2 Items</span>
                                                        <span class="number">(10)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault16">
                                                    <label class="form-check-label" for="flexCheckDefault16">
                                                        <span class="name">Combo 3 Items</span>
                                                        <span class="number">(14)</span>
                                                    </label>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault17">
                                                    <label class="form-check-label" for="flexCheckDefault17">
                                                        <span class="name">2 pcs</span>
                                                        <span class="number">(19)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault18">
                                                    <label class="form-check-label" for="flexCheckDefault18">
                                                        <span class="name">3 pcs</span>
                                                        <span class="number">(14)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault19">
                                                    <label class="form-check-label" for="flexCheckDefault19">
                                                        <span class="name">2 pcs Vacuum (140 g to 180 g each
                                                            )</span>
                                                        <span class="number">(13)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault20">
                                                    <label class="form-check-label" for="flexCheckDefault20">
                                                        <span class="name">4 pcs</span>
                                                        <span class="number">(18)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault21">
                                                    <label class="form-check-label" for="flexCheckDefault21">
                                                        <span class="name">4 pcs Vacuum (140 g to 180 g each
                                                            )</span>
                                                        <span class="number">(07)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault22">
                                                    <label class="form-check-label" for="flexCheckDefault22">
                                                        <span class="name">6 pcs</span>
                                                        <span class="number">(09)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault23">
                                                    <label class="form-check-label" for="flexCheckDefault23">
                                                        <span class="name">6 pcs carton</span>
                                                        <span class="number">(11)</span>
                                                    </label>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="form-check ps-0 m-0 category-list-box">
                                                    <input class="checkbox_animated" type="checkbox"
                                                        id="flexCheckDefault24">
                                                    <label class="form-check-label" for="flexCheckDefault24">
                                                        <span class="name">6 pcs Pouch</span>
                                                        <span class="number">(16)</span>
                                                    </label>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-custom-">
                <div class="show-button">
                    <div class="filter-button-group mt-0">
                        <div class="filter-button d-inline-block d-lg-none">
                            <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                        </div>
                    </div>

                    <div class="top-filter-menu">
                        <div class="category-dropdown">
                            <h5 class="text-content">Sort By :</h5>
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown">
                                    <span>Most Popular</span> <i class="fa-solid fa-angle-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" id="pop" href="javascript:void(0)">Popularity</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="low" href="javascript:void(0)">Low - High
                                            Price</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="high" href="javascript:void(0)">High - Low
                                            Price</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="rating" href="javascript:void(0)">Average
                                            Rating</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="aToz" href="javascript:void(0)">A - Z Order</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="zToa" href="javascript:void(0)">Z - A Order</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" id="off" href="javascript:void(0)">% Off - Hight To
                                            Low</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="grid-option d-none d-md-block">
                            <ul>
                                <li class="three-grid">
                                    <a href="javascript:void(0)">
                                        <img src="https://themes.pixelstrap.com/fastkart/assets/svg/grid-3.svg" class="blur-up lazyload" alt="">
                                    </a>
                                </li>
                                <li class="grid-btn d-xxl-inline-block d-none active">
                                    <a href="javascript:void(0)">
                                        <img src="https://themes.pixelstrap.com/fastkart/assets/svg/grid-4.svg"
                                            class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                        <img src="https://themes.pixelstrap.com/fastkart/assets/svg/grid.svg"
                                            class="blur-up lazyload img-fluid d-lg-none d-inline-block" alt="">
                                    </a>
                                </li>
                                <li class="list-btn">
                                    <a href="javascript:void(0)">
                                        <img src="https://themes.pixelstrap.com/fastkart/assets/svg/list.svg" class="blur-up lazyload" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div
                    class="row g-sm-4 g-3 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">

                    @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="product-box-3 h-100 wow fadeInUp">
                            <div class="product-header">
                                <div class="product-image">
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <img src="{{ optional($product->images->first())->url ? Storage::url($product->images->first()->url) : asset('images/no-image.png') }}"
                                            class="card-img-top p-2"
                                            alt="{{ $product->name }}"
                                            style="object-fit: contain;"> </a>
                                </div>
                            </div>
                            <div class="product-footer">
                                <div class="product-detail">
                                    <span class="span-name">{{ $product->category->name ?? 'Danh mục khác' }}</span>
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <h5 class="name">{{ $product->name }}</h5>
                                    </a>
                                    <p class="text-content mt-1 mb-2 product-content">{{ $product->description }}</p>

                                    <h6 class="unit">{{ $product->unit ?? '1 item' }}</h6>
                                    <h5 class="price">
                                        <span class="theme-color">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 300px;">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" alt="No products" width="150">
                        <p class="text-muted mt-3">Không có sản phẩm nào trong danh mục này.</p>
                    </div>
                    @endif

                </div>
                @endsection
