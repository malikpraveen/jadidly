@extends('web.layout.master')
@section('content')

<!--Page Title-->
<section class="page-title" style="background-image:url(assetsFront/images/background/3.jpg)">
    <div class="auto-container text-center">
        <h2>Know more about Jadidly</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<!-- Why Choose Us -->
<section class="why-choose-us">
    <div class="auto-container">
        <div class="row">
            <div class="content-column col-lg-6 col-md-12">
                <div class="inner-column">
                    <div class="sec-title">
                        <h2>Why Choose Us !!</h2> 
                    </div>
                    <div class="text-box"> 
                        <p>{{$content->text}}</p>    
                    </div>

<!--                    <div class="row">

                         Feature Block Two 
                        <div class="feature-block-two col-lg-6 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <span class="icon flaticon-check-engine"></span>
                                <h5>Modern Workshop</h5>
                                <div class="text">full range of garage services</div>
                            </div>
                        </div>

                         Feature Block Two 
                        <div class="feature-block-two col-lg-6 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <span class="icon flaticon-wrench"></span>
                                <h5>Expert Engineers</h5>
                                <div class="text">full range of garage services</div>
                            </div>
                        </div>
                         Feature Block Two 
                        <div class="feature-block-two col-lg-6 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <span class="icon flaticon-wallet"></span>
                                <h5>Cost Effective</h5>
                                <div class="text">full range of garage services</div>
                            </div>
                        </div>

                         Feature Block Two 
                        <div class="feature-block-two col-lg-6 col-md-6 col-sm-12">
                            <div class="inner-box">
                                <span class="icon flaticon-brain"></span>
                                <h5>Creative Thinking</h5>
                                <div class="text">full range of garage services</div>
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>

            <div class="image-column col-lg-6 col-md-12">
                <div class="inner-column">
                    <figure class="image"><img src="{{asset('assetsFront/images/resource/image-1.jpg')}}" alt=""></figure>
                    <figure class="image-2"><img src="{{asset('assetsFront/images/resource/why-img-1.jpg')}}" alt=""></figure>
                    <figure class="image-3"><img src="{{asset('assetsFront/images/resource/why-img-2.jpg')}}" alt=""></figure>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Why Choose Us -->
<!-- Fun Fact Section -->
<section class="fun-fact-section alternate pt-0">
    <div class="auto-container">
        <div class="fact-counter">
            <div class="row clearfix">
                <!--Column-->
                <div class="counter-column col-lg-3 col-md-6 col-sm-12">
                    <div class="count-box">
                        <span class="count-text" data-speed="3000" data-stop="850">0</span>
                        <h4 class="counter-title">Vehicles Services</h4>
                    </div>
                </div>

                <!--Column-->
                <div class="counter-column col-lg-3 col-md-6 col-sm-12">
                    <div class="count-box">
                        <span class="count-text" data-speed="3000" data-stop="62">0</span>
                        <h4 class="counter-title">Awards Win</h4>
                    </div>
                </div>

                <!--Column-->
                <div class="counter-column col-lg-3 col-md-6 col-sm-12">
                    <div class="count-box">
                        <span class="count-text" data-speed="3000" data-stop="35">0</span>
                        <h4 class="counter-title">Engineers</h4>
                    </div>
                </div>

                <!--Column-->
                <div class="counter-column col-lg-3 col-md-6 col-sm-12">
                    <div class="count-box">
                        <span class="count-text" data-speed="3000" data-stop="638">0</span>
                        <h4 class="counter-title">Happy Clients</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Fun Fact Section -->
<!-- Services Section -->
<section class="services-section-two service-section service-list">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>Our Best Services</h2> 
            <div class="text">Asmet consectetur adipisicing elit. Excepturi alias deleniti atque.<br> Quia hic corporis, quaerat repellendus rerum perferendis modi. Et, unde praesentium.</div>
        </div>

        <div class="carousel-outer">
            <div class="services-carousel owl-carousel owl-theme" id="serviceSlider">
                <!-- Service Block -->
                @if (isset($homepage->category_list) && $homepage->category_list)
                @foreach($homepage->category_list as $category)
                <div class="service-block-two">
                    <a href="<?=$category->has_subcategory ==1?url('subcategory-list/'.base64_encode($category->id)):url('service/'.base64_encode($category->id))?>">
                        <div class="inner-box">
                            <div class="icon-box" style="width:68px;"> <img src="<?=$category->image?$category->image:asset('assetsFront/images/icons/ragis.png')?>" class="service-img"></div>
                            <h4><a href="#"><?=$category->name?></a></h4>
                        </div>
                    </a>
                </div>
                @endforeach
                @endif
            </div>

        </div>
    </div>
</section>
<!--End Services Section -->

<!-- Work Section -->
<section class="work-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>How it Work</h2> 
            <div class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.<br> Maxime enim animi quidem aperiam iusto, id?</div>
        </div>

        <div class="row">
            <!-- Work Block -->
            <div class="work-block col-lg-3 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count">01</span>
                    <h4>Choose Your Service</h4>
                    <div class="text">Maxime enim animi elit amet aperiam iusto</div>
                </div>
            </div>

            <!-- Work Block -->
            <div class="work-block col-lg-3 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count">02</span>
                    <h4>Make An Appointment</h4>
                    <div class="text">Maxime enim animi elit amet aperiam iusto</div>
                </div>
            </div>

            <!-- Work Block -->
            <div class="work-block col-lg-3 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count">03</span>
                    <h4>We'll Take your Car</h4>
                    <div class="text">Maxime enim animi elit amet aperiam iusto</div>
                </div>
            </div>

            <!-- Work Block -->
            <div class="work-block col-lg-3 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count">04</span>
                    <h4>Pickup your Car Keys</h4>
                    <div class="text">Maxime enim animi elit amet aperiam iusto</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Work Section -->



@endsection