@extends('web.layout.master')
@section('content')
<section class="banner-section-three home-section">

</section>
<section class="work-section car-work-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>You <a href="#bookService">Book an Appoinment</a>, we'll do the rest</h2> 
        </div>

        <div class="row">
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count"><img src="{{asset('assetsFront/images/service-icons/step_1.png')}}" /></span>
                    <h4>Book Appointment</h4>
                    <div class="text">Just book an appointment and we'll take the pain of your vehicle registration renewal for you.</div>
                </div>
            </div>
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count"><img src="{{asset('assetsFront/images/service-icons/step_2.png')}}" /></span>
                    <h4>Car Pick-up</h4>
                    <div class="text">Our trusted staff will pick-up the vehicle from your Location. No need to bring your car to our office for car registration renewal.</div>
                </div>
            </div>
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count"><img src="{{asset('assetsFront/images/service-icons/step_3.png')}}" /></span>
                    <h4>RTA Car Inspection</h4>
                    <div class="text">Then we’ll take your car to RTA testing point. RTA Testing is necessary to renew your car registration. If you have Traffic fines, we will take care of that.</div>
                </div>
            </div>
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count"><img src="{{asset('assetsFront/images/service-icons/step_4.png')}}" /></span>
                    <h4>Insurance Assistance</h4>
                    <div class="text">If you need insurance, we’ll search for best affordable insurance rates and will do the required agreement for you.</div>
                </div>
            </div>
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count"><img src="{{asset('assetsFront/images/service-icons/step_5.png')}}" /></span>
                    <h4>Registration Renewal</h4>
                    <div class="text">After RTA Inspection and Insurance, we’ll process for RTA vehicle registration renewal and will get the new registration card and expiry sticker as well.</div>
                </div>
            </div>
            <!-- Work Block -->
            <div class="work-block col-lg-4 col-md-6 col-sm-12">
                <div class="inner-box">
                    <span class="count"><img src="{{asset('assetsFront/images/service-icons/step_6.png')}}" /></span>
                    <h4>Drop-off</h4>
                    <div class="text">At last, we’ll drop off your car at your desired location. During the process you can track your car from pick up till drop off. We will ensure your car safety.</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- about Section -->

<section class="style-two about-background testimonial-section text-center">
    <div class="auto-container">
        <div class="row clearfix">
            <!-- Content Column -->
            <div class="content-column col-lg-12 col-md-12 col-sm-12 order-2">
                <div class="sec-title">
                    <h2 class="text-center text-white">Our Step-By-Step Process</h2>
                    <div class="text-box text-white">
                        <strong>Our Process is simple, efficient & quick:</strong>
                        <ul class="list-style-one pt-3 text-white">
                            <li>Book an Appointment Online or by Phone.</li>
                            <li>We send our trusted agent to pick your vehicle & renew your vehicle's registration, handle traffic fines, finalize any remaining paper work & obtain new insurance if required.</li>
                            <li>After all is done, we'll return your car along with your new vehicle registration.</li>
                            <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore voluptatem incidunt veritatis alias fugit non,</li> 
                            <li>expedita assumenda sapiente ipsam magnam, consectetuus non nemo cupiditate?.</li>
                            <li>expedita assumenda sapiente ipsam magnam, consectetur placeat corporis sed vel, temporibus! Minus non nemo cupiditate?.</li>
                            <li>expedita assumenda sapiente ipsam magnam, temporibus! Minus non nemo cupiditate?.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End about Section -->
<!-- Testimonial Section -->
@if(isset($homepage->offers) && $homepage->offers)
<section class="testimonial-section offer-section home-offer" id="offerDiv">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>Offers</h2> 
        </div>
        <div class="row">
            <div class="col-md-12">
                <a href="{{url('offers')}}" class="btn btn-primary pull-right">View all</a>
            </div>
        </div>

        <div class="outer-box">
            <div class="testimonial-carousel owl-carousel owl-theme" id="offerSlider">
                <!--<div class="owl-item active" style="width: 615px;">-->
                @foreach($homepage->offers as $offer)
                <div class="testimonial-block">
                    <div class="inner-box p-0">
                        <div class="image-box">
                            <figure class="image">
                                <a href="#"><img src="{{$offer->image?$offer->image:asset('assetsFront/images/main-slider/image-5.jpg')}}" alt=""></a>
                                <div class="text-box">
                                    <h3> {{$offer->category_name}}</h3>
                                </div>
                                <div class="offer-discount">
                                    <p>{{$offer->percentage}}% Off</p>
                                </div>
                            </figure> 

                        </div>
                        <div class="content-box text-left">
                            <p class="hide-text pl-4 pr-4"><?=$offer->name?>
                                <!--<a href="#" class="text-blue pl-4">view more</a>-->
                            </p> 
                        </div> 
                    </div>
                </div>
                
                @endforeach
                <!--</div>-->
            </div>

        </div>
    </div>
</section>
@endif
<!--End Testimonial Section -->

<!-- Testimonial Section -->
<section class="testimonial-section-two why-choose">
    <div class="auto-container">

        <h2 class="text-white text-center mb-3">WHY CHOOSE US?</h2>
        <div class="text text-left text-white mb-4">
            Working with us is easy, fast and hassle-free. We'll ensure that you no longer have to go through any stress to renew your car registration in UAE. Our client's testimonials and recommendations show that we are the best at what we do. We're passionate about relieving your stress and making Vehicle registration renewal an easy part of life in Dubai.
        </div>
<!--        <div class="single-item-carousel owl-carousel owl-theme">

             Testimonial Block 
            <div class="testimonial-block-two">
                <div class="inner-box"> 
                    <div class="text text-left">Never knew it would be this simple. Nice to see innovation in the UAE. With the pick and drop service its all worth it. Done with waiting in lines at the RTA.</div> 
                    <div class="vehicle mt-3">Arif Khan</div>


                </div>
            </div>
             Testimonial Block 
            <div class="testimonial-block-two">
                <div class="inner-box"> 
                    <div class="text text-left">A lot of thanks really. Best service for car renewal. Good price. Fast service my car take only 2 hours and they finish all process. Only i can say they are professional company. I expect they will the leaders in this field in Dubai. Best Wishes!</div> 
                    <div class="vehicle mt-3">Rihan Khan</div>

                </div>
            </div>

        </div>-->
    </div>
</section>
<!--End Testimonial Section --> 
<!-- Services Section -->
<section class="services-section-two service-section service-list" id="bookService">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>Our Services</h2> 
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
@endsection
