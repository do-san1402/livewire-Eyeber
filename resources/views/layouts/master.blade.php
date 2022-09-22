<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.title-meta')
    @include('layouts.head')
</head>

@section('body')

    <body>
       
        <style>
            th,td{
                line-break: loose ;
                max-width: 100px;
                text-overflow: ellipsis;
            }
            .modal-spindle {
                position:   fixed;
                display:    none;
                top: calc(50% - 32px);
                left: calc(50% - 32px);
                height: 120px;
                width: 120px;
                z-index:    2000;
                border-radius: 50%;
                perspective: 800px;
            }

            .inner-spindle {
                position: absolute;
                box-sizing: border-box;
                width: 100%;
                height: 100%;
                border-radius: 50%;  
            }

            .inner-spindle.one {
                left: 0%;
                top: 0%;
                animation: rotate-one 1s linear infinite;
                border-bottom: 3px solid #2c2c99;
            }

            .inner-spindle.two {
                right: 0%;
                top: 0%;
                animation: rotate-two 1s linear infinite;
                border-right: 3px solid #811318;
            }

            .inner-spindle.three {
                right: 0%;
                bottom: 0%;
                animation: rotate-three 1s linear infinite;
                border-top: 3px solid #d78a16;
            }

            @keyframes rotate-one {
                0% {
                    transform: rotateX(35deg) rotateY(-45deg) rotateZ(0deg);
                }
                100% {
                    transform: rotateX(35deg) rotateY(-45deg) rotateZ(360deg);
                }
            }

            @keyframes rotate-two {
                0% {
                    transform: rotateX(50deg) rotateY(10deg) rotateZ(0deg);
                }
                100% {
                    transform: rotateX(50deg) rotateY(10deg) rotateZ(360deg);
                }
            }

            @keyframes rotate-three {
                0% {
                    transform: rotateX(35deg) rotateY(55deg) rotateZ(0deg);
                }
                100% {
                    transform: rotateX(35deg) rotateY(55deg) rotateZ(360deg);
                }
            
            }
            input[type="search"]::-webkit-search-decoration,
            input[type="search"]::-webkit-search-cancel-button,
            input[type="search"]::-webkit-search-results-button,
            input[type="search"]::-webkit-search-results-decoration {
                -webkit-appearance:none;
            }
        </style>
    @show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @yield('content')
                    <div  id="modal_loading" class="modal-spindle">
                        <div class="inner-spindle one"></div>
                        <div class="inner-spindle two"></div>
                        <div class="inner-spindle three"></div>
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
</body>

<script>
    var url_upload_web = "{{route('admin.services.notices.upload_video') . '?_token='.csrf_token() }}";
    $(document).on({
        ajaxStart: function() { $('#modal_loading').show();},  
        ajaxStop: function() { $('#modal_loading').hide(); }   
    });

    function notificationSwal(status) {
        if(status == {{config('apps.common.status.success')}}) {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: "{{trans('translation.Successful')}}",
                showConfirmButton: false,
                timer: 1500
            });
        }
        if(status == {{config('apps.common.status.fail')}}) {
            errorSwal()
        }
    }

    function errorSwal() {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: "{{trans('translation.Something_went_wrong')}}",
            showConfirmButton: false,
            timer: 1500
        })
    }
    $(".alert").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert").slideUp(1500);
    });
</script>
</html>
