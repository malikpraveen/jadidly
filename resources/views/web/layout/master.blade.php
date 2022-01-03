<!DOCTYPE html>

<html lang="en">

    <head>  

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assetsFront/images/favicon.png')}}">

        <title>Jadidly Website | Book your service with us online or visit your nearest workshop today.</title>

        <meta name="description" content="At Jadidly we strive to provide the best levels of service to all our customers ensuring they enjoy a safe and pleasant driving experience." />

        <meta name="keywords" content="jadidly.com" />

        <meta name="author" content="Jadidly" />

        <link href="https://www.jadidly.com/" rel="canonical" />

        <meta name="Classification" content="Jadidly " />

        <meta name="abstract" content="https://www.jadidly.com/" />

        <meta name="audience" content="All" />

        <meta name="robots" content="index,follow" />

        <meta property="og:locale" content="en_US" />

        <meta property="og:title" content="Book your service with us online or visit your nearest workshop today." />

        <meta property="og:description" content="At Jadidly we strive to provide the best levels of service to all our customers ensuring they enjoy a safe and pleasant driving experience." />

        <meta property="og:url" content="https://www.jadidly.com/" />

        <meta property="og:image" content="{{asset('assetsFront/images/og.png')}}" />

        <meta property="og:site_name" content="Jadidly" />

        <meta name="googlebot" content="index,follow" />

        <meta name="distribution" content="Global" />

        <meta name="Language" content="en-us" />

        <meta name="doc-type" content="Public" />

        <meta name="site_name" content="Jadidly" />

        <meta name="url" content="https://www.jadidly.com/" /> 

        <link rel="stylesheet" href="{{asset('assetsFront/css/bootstrap.css')}}">

        <link rel="stylesheet" href="{{asset('assetsFront/css/style.css')}}"> 

        <link rel="stylesheet" href="{{asset('assetsFront/css/font-awesome.min.css')}}">

        <link rel="stylesheet" href="{{asset('assetsFront/css/animate.min.css')}}">      

        <link rel="stylesheet" href="{{asset('assetsFront/css/responsive.css')}}">

        <link rel="stylesheet" href="{{asset('assetsFront/css/color-switcher-design.css')}}">  

        <link rel="stylesheet" href="{{asset('assetsFront/fonts/stylesheet.css')}}">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>

    <body>


        <div class="page-wrapper">

            <!-- Preloader -->

            <div class="preloader"></div>
            <!-- Navbar -->
            @include('web.layout.header')
            @yield('content')
            <!-- Main Footer -->
            @include('web.layout.footer')
            <!-- </div> -->
            <!-- /.content-wrapper -->
        </div>
        <div id="logoutModal" class="modal bs-example-modal-new checkout-modal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">

            <div class="modal-dialog">

                <!-- Modal Content: begins -->
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header border-bottom-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    </div>

                    <!-- Modal Body -->  
                    <div class="modal-body text-center">
                        <div class="body-message">
                            <a href="#"><i class="fa fa-power-off confirm-booking-icon" style="background: #0000cc;"></i></a>

                            <h4 class="text-dark mb-4">Are you sure you want to logout?</h4>
                            <!--<p>Our Service is on the way for you</p>-->
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary col-12 " onclick="logoutUser(this);"><strong>Yes</strong></button>
                                    <button class="btn btn-danger col-12 mt-1" id="nobtn" data-dismiss="modal" aria-label="Close"><strong>No</strong></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-top-0 text-center"> 
                    </div>

                </div>
                <!-- Modal Content: ends -->

            </div>

        </div>
        <script src="{{asset('assetsFront/js/jquery.js')}}"></script>
        <script src="{{asset('assetsFront/js/popper.min.js')}}"></script>
        <script src="{{asset('assetsFront/js/bootstrap.min.js')}}"></script> 
        <script src="{{asset('assetsFront/js/owl.js')}}"></script>
        <script src="{{asset('assetsFront/js/wow.js')}}"></script>
        <script src="{{asset('assetsFront/js/appear.js')}}"></script>
        <script src="{{asset('assetsFront/js/validate.js')}}"></script>
        <!--  <script src="{{asset('assetsFront/js/jquery.modal.min.js')}}"></script>  -->
        <script src="{{asset('assetsFront/js/script.js')}}"></script> 
        <script src="{{asset('assetsFront/js/color-settings.js')}}"></script> 
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyDaaCBm4FEmgKs5cfVrh3JYue3Chj1kJMw&amp;ver=5.2.4"></script>
        <script src="{{asset('assetsFront/js/map-script.js')}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
                                        $(document).ready(function () {
                                            $(".numberOnly").keypress(function (e) {
                                                var regex = new RegExp(/^[0-9]+$/);
                                                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                                                if (regex.test(str)) {
                                                    return true;
                                                } else {
                                                    e.preventDefault();
                                                    return false;
                                                }
                                            });

                                            $(".characterOnly").keypress(function (e) {
                                                var regex = new RegExp(/^[a-zA-Z\s]+$/);
                                                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                                                if (regex.test(str)) {
                                                    return true;
                                                } else {
                                                    e.preventDefault();
                                                    return false;
                                                }
                                            });
                                        });

                                        $(function () {
                                            $(document).on("change", ".uploadFile", function ()
                                            {

                                                var uploadFile = $(this);
                                                var files = !!this.files ? this.files : [];
                                                if (!files.length || !window.FileReader)
                                                    return; // no file selected, or no FileReader support

                                                if (/^image/.test(files[0].type)) { // only image file
                                                    var reader = new FileReader(); // instance of the FileReader
                                                    reader.readAsDataURL(files[0]); // read the local file

                                                    reader.onloadend = function () { // set image data as background of div
                                                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                                                        $(".imgUp").attr("src", this.result);
                                                    }
                                                }

                                            });
                                        });

                                        function setSessionKeys(data) {
                                            $.ajax({
                                                url: '<?= url('web/setSession') ?>',
                                                type: 'POST',
                                                data: 'user_id=' + data.user_id + '&name=' + data.name + '&image=' + data.image + '&country_code=' + data.country_code + '&mobile_number=' + data.mobile_number + '&email=' + data.email + '&token=' + data.token + '&_token=<?= csrf_token() ?>',
                                                success: function (d) {
                                                    return true;
                                                }
                                            });
                                        }

                                        function unsetSessionKeys(key) {
                                            $.ajax({
                                                url: '<?= url('web/unsetSession') ?>',
                                                type: 'POST',
                                                data: 'key=' + key + '&_token=<?= csrf_token() ?>',
                                                success: function (d) {
                                                    return true;
                                                }
                                            });
                                        }
        </script>
        <script>
            function logout(obj) {
//                $("#logoutModal").modal();
//                $("#nobtn").focus();
                swal({
                    title: "Are you sure?",
                    text: "You will be logged out of your account",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    dangerMode: true,
                })
                        .then((willDelete) => {
                            if (willDelete) {
                                logoutUser(this);
//                                swal("Poof! Your imaginary file has been deleted!", {
//                                    icon: "success",
//                                });
                            } else {
//                                swal("Your imaginary file is safe!");
                            }
                        });
            }

            function logoutUser(obj) {
                $.ajax({
                    headers: {'Authorization': 'Bearer <?= isset($this->user_data['token']) && $this->user_data['token'] ? $this->user_data['token'] : '' ?>'},
                    url: '<?= url('api/logout') ?>',
                    type: 'POST',
                    data: '',
                    success: function (data) {
                        unsetSessionKeys('login_info');
                        location.reload();
                    }
                });
            }

            function showPassword(obj, id) {
                if ($('#' + id).attr('type') == 'text') {
                    $('#' + id).attr('type', 'password');
                    $(obj).removeClass('fa-eye-slash');
                    $(obj).addClass('fa-eye');
                } else {
                    $('#' + id).attr('type', 'text');
                    $(obj).removeClass('fa-eye');
                    $(obj).addClass('fa-eye-slash');
                }
            }

            function readURL(input, count) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#image' + count)
                                .attr('src', e.target.result);
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            function errorReported(data) {
                if (data.status_code == 401) {
                    sessionExpired(data);
                } else {
                    swal({
                        title: "Error Reported",
                        text: (data.error ? data.error : data.message),
                        icon: "warning",
                        buttons: "Ok"
                    });
                    $("#success").html("");
                    if (data.error) {
                        $("#error").html(data.error);
                    } else {
                        $("#error").html(data.message);
                    }
                }
            }

            function sessionExpired(data) {
                swal({
                    title: "Session Expired!",
                    text: data.message,
                    icon: "warning",
                    buttons: false,
                });
                setTimeout(function () {
                    logoutUser(this);
                }, 2000);
            }
        </script>

    </body>
</html>
