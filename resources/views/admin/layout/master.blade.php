<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/favicon.png')}}">
        <title>Jadidly Admin Panel - A place to find best car</title>
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{asset('assets/css/et-line-font/et-line-font.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/themify-icons/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/simple-lineicon/simple-line-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/datatables/css/dataTables.bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/skins/_all-skins.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/formwizard/jquery-steps.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dropify.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/chartist-js/chartist.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/chartist-js/chartist-plugin-tooltip.css')}}"> 
        <link rel="stylesheet" href="{{asset('assets/css/font/stylesheet.css')}}"> 
    </head>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper boxed-wrapper">
            <!-- Navbar -->
            @include('admin.layout.header')
            <!-- /.navbar -->
            <!-- Main Sidebar Container -->
            <!-- <div class="dashboard-section"> -->
            @include('admin.layout.sidebar')
            <!-- Content Wrapper. Contains page content -->
            <!-- <div class="content-wrapper"> -->
            <!-- <div id="loader" class="lds-dual-ring hidden overlay"></div> -->
            <!-- Content Header (Page header) -->
            @yield('content')
            <!-- /.content-header -->
            <!-- </div> -->
            <!-- Main Footer -->
            @include('admin.layout.footer')
            <!-- </div> -->
            <!-- /.content-wrapper -->

        </div>

        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/bizadmin.js')}}"></script>
        <script src="{{asset('assets/plugins/jquery-sparklines/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('assets/plugins/jquery-sparklines/sparkline-int.js')}}"></script>
        <script src="{{asset('assets/plugins/raphael/raphael-min.js')}}"></script>
        <script src="{{asset('assets/plugins/morris/morris.js')}}"></script>
        <script src="{{asset('assets/plugins/functions/dashboard1.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/demo.js')}}"></script>
        <script src="{{asset('assets/plugins/formwizard/jquery-steps.js')}}"></script>
        <script src="{{asset('assets/plugins/dropify/dropify.min.js')}}"></script>
        <script src="{{asset('assets/plugins/chartjs/chart.min.js')}}"></script>
        <script src="{{asset('assets/plugins/chartjs/chart-int.js')}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable()
    $('#example3').DataTable()
    $('#example4').DataTable({
        'paging': true,
        'lengthChange': false,
        'searching': false,
        'ordering': true,
        'info': true,
        'autoWidth': false
    })
})
        </script>
        <script>
            var frmRes = $('#frmRes');
            var frmResValidator = frmRes.validate();

            var frmInfo = $('#frmInfo');
            var frmInfoValidator = frmInfo.validate();

            var frmLogin = $('#frmLogin');
            var frmLoginValidator = frmLogin.validate();

            var frmMobile = $('#frmMobile');
            var frmMobileValidator = frmMobile.validate();

            $('#demo1').steps({
                onChange: function (currentIndex, newIndex, stepDirection) {
                    console.log('onChange', currentIndex, newIndex, stepDirection);
                    // tab1
                    if (currentIndex === 0) {
                        if (stepDirection === 'forward') {
                            var valid = frmRes.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmResValidator.resetForm();
                        }
                    }

                    // tab2
                    if (currentIndex === 1) {
                        if (stepDirection === 'forward') {
                            var valid = frmInfo.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmInfoValidator.resetForm();
                        }
                    }

                    // tab3
                    if (currentIndex === 2) {
                        if (stepDirection === 'forward') {
                            var valid = frmLogin.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmLoginValidator.resetForm();
                        }
                    }

                    // tab4
                    if (currentIndex === 3) {
                        if (stepDirection === 'forward') {
                            var valid = frmMobile.valid();
                            return valid;
                        }
                        if (stepDirection === 'backward') {
                            frmMobileValidator.resetForm();
                        }
                    }

                    return true;

                },
                onFinish: function () {
                    alert('Wizard Completed');
                }
            });
        </script> 
        <script>
            $('#demo').steps({
                onFinish: function () {
                    alert('Wizard Completed');
                }
            });
        </script>
        <script>
            $(document).ready(function () {
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove: 'Supprimer',
                        error: 'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function (event, element) {
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function (event, element) {
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function (event, element) {
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function (e) {
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        </script>
        <script type="text/javascript">

            $(".imgAdd").click(function () {
                $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-3 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
            });
            $(document).on("click", "i.del", function () {
                $(this).parent().remove();
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
                            uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url(" + this.result + ")");
                        }
                    }

                });
            });
        </script>
        <script>
            var imgflag = true;
            $(document).ready(function () {

                $(".alphanum").keypress(function (e) {
                    var specialKeys = new Array();
                    specialKeys.push(8); //Backspace
                    specialKeys.push(9); //Tab
                    specialKeys.push(46); //Delete
                    specialKeys.push(36); //Home
                    specialKeys.push(35); //End
                    specialKeys.push(37); //Left
                    specialKeys.push(39); //Right
                    var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
                    var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (keyCode == 124) || (keyCode == 58) || (keyCode >= 37 && keyCode <= 46) || (keyCode == 32) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));

                    if (ret == true) {
                        return true;
                    } else {
                        e.preventDefault();
                        return false;
                    }

                });

                // $('.arabicinput').keyup(function(e){
                //      var specialKeys = new Array();
                //     specialKeys.push(8); //Backspace
                //     specialKeys.push(9); //Tab
                //     specialKeys.push(46); //Delete
                //     specialKeys.push(36); //Home
                //     specialKeys.push(35); //End
                //     specialKeys.push(37); //Left
                //     specialKeys.push(39); //Right
                //     // var unicode=e.charCode? e.charCode : e.keyCode
                //     var unicode = e.keyCode == 0 ? e.charCode : e.keyCode;

                //     var ret=(( unicode<48 || unicode>57) || (unicode < 0x0600 || unicode > 0x06FF) || (unicode == 124) || (unicode == 58) || (unicode >= 37 && unicode <= 46) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
                //         alert(ret);
                //         if (ret){
                //             return true;
                //         } else{
                //             e.preventDefault();
                //             return false;
                //         }
                // });
            });

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


            function checkPrice(element) {
                if (isNaN(element.val())) {
                    return false;
                } else {
                    return true;
                }
            }

            function validImage(obj, wi, hi) {
                var _URL = window.URL || window.webkitURL;
                var file = $(obj).prop('files')[0];

                var img = new Image();
                var min_wi = parseInt(wi) - 50;
                img.onload = function () {
                    var wid = this.width;
                    var ht = this.height;
                    if (file.type == 'image/png') {
                        if ((wid < min_wi || wid > wi) || ht !== hi) {
                            imgflag = false;
                            $("#img_error").html("image dimensions must be " + wi + "*" + hi);
                            $("#submitButton").attr('type', 'button');
                        } else {
                            imgflag = true;
                            $("#img_error").html("");
                            $("#submitButton").attr('type', 'submit');
                        }
                    } else {
                        $("#img_error").html(".png type image is required");
                        $("#submitButton").attr('type', 'button');
                    }

                };
                img.src = _URL.createObjectURL(file);

            }
        </script>
        <script>
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
        </script>
        <script>
            function errorOccured(data) {
                swal({
                    title: "Error Occured!",
                    text: data.message,
                    icon: "warning",
                    buttons: false,
                    timer: 2000,
                });
                $("#error").html(data.message);
            }
            function successMessage(data) {
                swal({
                    title: data.title,
                    text: data.message,
                    icon: "success",
                    buttons: false,
                    timer: 2000,
                });
                setTimeout(function () {
                    location.reload();
                }, 2000);
            }
        </script>
    </body>
</html>