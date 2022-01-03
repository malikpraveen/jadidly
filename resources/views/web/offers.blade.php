@extends('web.layout.master')
@section('content')
<section class="page-title" style="background-image:url(assetsFront/images/background/3.jpg)">
    <div class="auto-container text-center">
        <h2>Offers</h2>
        <ul class="page-breadcrumb"> 
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        </ul>
    </div>
</section>
<section class="style-two about-us  pb-0 offer-section">


    <div class="auto-container">
        <div class="row clearfix">
            <!-- Content Column -->
            <div class="content-column col-lg-12 col-md-12 col-sm-12 order-2 content-side">
                <div class="inner-column"> 
                    <div class="our-shop">
                        <!--                        <div class="row mb-3"> 
                                                    <div class="col-md-6 offset-6">
                                                        <input type="search" name="" placeholder="Search" class="form-control">
                                                    </div>
                                                </div>-->
                        <div class="row clearfix">
                            <!-- Product Block -->
                            @if($offers)
                            @foreach($offers as $offer)
                            <div class="product-block col-lg-6 col-md-6 col-sm-12"> 
                                <div class="inner-box">
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
                                        <p><strong>{{$offer->name}}</strong></p>
                                        <p class="hide-text">{{$offer->description}}<a href="#" class="text-blue pl-4">view more</a></p> 
                                    </div>
                                </div> 
                            </div>
                            @endforeach
                            @else
                            <div class="product-block col-lg-6 col-md-6 col-sm-12"> 
                                <p>No offers found</p>
                            </div>
                            @endif
                        </div>

                        <!--Styled Pagination-->
                        <!--                        <ul class="styled-pagination text-center">
                                                    <li><a href="#" class="active">1</a></li>
                                                    <li><a href="#">2</a></li>
                                                    <li><a href="#">3</a></li>
                                                    <li><a href="#"><span class="fa fa-angle-right"></span></a></li>
                                                </ul>                -->
                        <!--End Styled Pagination-->
                    </div> 

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
