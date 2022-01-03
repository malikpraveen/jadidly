@extends('web.layout.master')
@section('content')
<!--Page Title-->
<section class="page-title" style="background-image:url(<?= asset('assetsFront/images/background/3.jpg') ?>)">
    <div class="auto-container text-center">
        <h2 id="category_name">Our Services</h2>
        <ul class="page-breadcrumb"> 
            <li id="quote">Listing All The Main Service Categories</li>
        </ul>
    </div>
</section>
<!--End Page Title-->
<section class="about-us style-two service-background pb-0">


    <div class="auto-container">
        <div class="row clearfix">
            <!-- Content Column -->
            <div class="content-column col-lg-12 col-md-12 col-sm-12 order-2 content-side">
                <div class="inner-column"> 
                    <div class="our-shop">
                        <div class="row mb-3"> 
<!--                            <div class="col-md-6 offset-6">
                                <input type="search" name="" placeholder="Search" class="form-control">
                            </div>-->
                        </div>
                        <div class="row clearfix" id="categoryDiv">
                            <!-- Product Block -->
                            <!--                            <div class="product-block col-lg-4 col-md-6 col-sm-12">
                                                            <a href="#">
                                                                <div class="inner-box">
                                                                    <div class="image-box">
                                                                        <figure class="image"><a href="#"><img src="{{asset('assetsFront/images/cars/1.jpg')}}" alt=""></a></figure> 
                                                                    </div>
                                                                    <div class="content-box">
                                                                        <h5><a href="#">Car Inspaction</a></h5> 
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </div>   -->




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
<script src="{{asset('assetsFront/js/jquery.js')}}"></script>
<script>
$(document).ready(function () {
    var url = window.location.origin;
    $.ajax({
        headers: {'Authorization': 'Bearer <?= Session::get('login_info') ? Session::get('login_info')['token'] : '' ?>'},
        url: '<?= url('/api/ourServices') ?>',
        type: 'POST',
        data: 'category_id=<?= $category_id ?>',
        success: function (data) {
//            console.log(data);
            if (data.status == true && data.status_code == 200) {
                if (data.data.category) {
                    $("#category_name").html(data.data.category.name);
                    $("#quote").html("Listing All The Subcategories Under " + data.data.category.name + " Category");
                }
                if ((data.data.category_list).length > 0) {
                    var category_list = data.data.category_list;
                    $(category_list).each(function (i, category) {
                        var html = '<div class="product-block col-lg-4 col-md-6 col-sm-12">' +
                                "<a href='" + (category.has_subcategory == 1 ? '<?=url('/subcategory-list')?>/' + btoa(category.id) : '<?=url('/service')?>/'  + btoa(category.id)) + "'>" +
                                "<div class='inner-box'>" +
                                "<div class='image-box'>" +
                                '<figure class="image"><a href="' + (category.has_subcategory == 1 ? '<?=url('/subcategory-list')?>/' + btoa(category.id) : '<?=url('/service')?>/'  + btoa(category.id)) + '"><img src="' + category.image + '" alt=""></a></figure>' +
                                "</div>" +
                                '<div class="content-box">' +
                                "<h5><a href='" + (category.has_subcategory == 1 ?  '<?=url('/subcategory-list')?>/' + btoa(category.id) : '<?=url('/service')?>/' + btoa(category.id)) + "'>" + category.name + "</a></h5>" +
                                "</div>" +
                                "</div>" +
                                "</a>" +
                                "</div>";
                        $("#categoryDiv").append(html);
                    });
                } else {
                    var html = '<div class="col-lg-12 col-md-12 col-sm-12"><p>No Subcategory found</p></div>';
                    $("#categoryDiv").append(html);
                }



            } else {
//                window.location.href = "<?= url('/login') ?>";
            }
        }
    });
});


</script>

