@extends('layouts.master')
@section('title') @lang('translation.Dashboard') @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>table.table tbody tr{cursor: pointer;}</style>
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pageTitle')@lang('Eyeber')@endslot
    @slot('title') @lang('translation.Dashboard') @endslot
    @slot('subTitle')@endslot
@endcomponent 

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">@lang('translation.Real_time_monitoring')</h4>
                <canvas id="line-chart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-xl-4">
        <h4 class="card-title mb-4">@lang('translation.Advertising_situation')</h4>
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <h6 class="mx-2 my-3">@lang('translation.Total_watch_time_minutes')</h6>
                    <div class="progress mb-1" style="height: 1px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%; background: rgb(204 204 205 / 50%);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="card-body py-5">
                        <div class="d-flex flex-column justify-content-center align-items-center ">
                            <h4 class="mb-1 mt-2 total_time"><span data-plugin="counterup">45,254</span></h4>
                        </div>
                    </div><!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col-xl-6">
                <div class="card">
                    <h6 class="mx-2 my-3">@lang('translation.Cumulative_mining')</h6>
                    <div class="progress mb-1" style="height: 1px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%; background: rgb(204 204 205 / 50%);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="card-body py-5">
                        <div class="d-flex flex-column justify-content-center align-items-center ">
                            <h4 class="mb-1 mt-2 total_cumulative_mining"><span data-plugin="counterup">45,254</span></h4>
                            <span class="text me-1 unit_cumulative_mining"></span>
                            
                        </div>
                    </div><!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>

    <div class="col-xl-8">
        <h4 class="card-title mb-4">@lang('translation.Real_time_ad_viewing_rating')</h4>
        <div class="card">
            <div class="card-body">
                <div class="">
                    <table class="table table-bordered dt-responsive tbl_advertisements" id="tbl_advertisements"  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>@lang('translation.Ranking')</th>
                                <th>@lang('translation.Advertisement_name')</th>
                                <th>@lang('translation.Advertising_period')</th>
                                <th>@lang('translation.Number_of_participants')</th>
                                <th>@lang('translation.Cumulative_mining')</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end Col -->
</div> <!-- end row-->

<div class="row">
    <div class="col-xl-4">
        <h4 class="card-title mb-4">@lang('translation.Membership_status')</h4>
        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <h6 class="mx-2 my-3">@lang('translation.Cumulative_connection')</h6>
                    <div class="progress mb-1" style="height: 1px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%; background: rgb(204 204 205 / 50%);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="card-body py-5">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <h4 class="mb-1 mt-2 user_connect"><span  data-plugin="counterup">45,254</span></h4>
                        </div>
                    </div><!-- end card-body-->
                </div> <!-- end card-->
            </div><!-- end col -->
            <div class="col-xl-6">
                <div class="card">
                    <h6 class="mx-2 my-3">@lang('translation.New_member')</h6>
                    <div class="progress mb-1" style="height: 1px;">
                        <div class="progress-bar" role="progressbar" style="width: 100%; background: rgb(204 204 205 / 50%);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="card-body py-5">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <h4 class="mb-1 mt-2 total_new_user"><span data-plugin="counterup">45,254</span></h4>
                        </div>
                    </div><!-- end card-body-->
                </div> <!-- end card-->
            </div><!-- end col -->

        </div>
    </div>


    <div class="col-xl-2">
        <h4 class="card-title mb-4">@lang('translation.Revenue_situation')</h4>
        <div class="card">
            <h6 class="mx-2 my-3">@lang('translation.Product_sales')</h6>
            <div class="progress mb-1" style="height: 1px;">
                <div class="progress-bar" role="progressbar" style="width: 100%; background: rgb(204 204 205 / 50%);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="card-body py-5">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h4 class="mb-1 mt-2 total_matic"><span data-plugin="counterup">45,254</span></h4>
                    <p class="text-muted mt-1 mb-3">
                        <span class="text me-1 unit_total_matic"></span>
                    </p>
                </div>
            </div><!-- end card-body-->
        </div> <!-- end card-->
    </div><!-- end col -->
    <div class="col-xl-6">
        <h4 class="card-title mb-4">@lang('translation.Product_sales_ranking')</h4>
        <div class="card">
            <div class="card-body">
                <div class="">
                    <table class="table table-bordered dt-responsive tbl_order_ranking" id="tbl_order_ranking" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>@lang('translation.Ranking')</th>
                                <th>@lang('translation.Product_name')</th>
                                <th>@lang('translation.Sales_volume')</th>
                                <th>@lang('translation.Sales')</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
              

              
            </div><!-- end card-body-->
        </div> <!-- end card-->
    </div><!-- end col -->

</div>
<!-- end row -->



@endsection
@section('script')
       <!-- apexcharts -->

    <script src="{{ URL::asset('/assets/libs/chart-js/chart-js.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/chartjs.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/datepicker/datepicker.min.js') }}"></script>

        <script>
            $('.sub-title .breadcrumb-item a').click(function(e) {
                $('.breadcrumb-item a.text-primary').removeClass('text-primary');
                $(this).addClass('text-primary');
            });
            $('#tbl_advertisements').hover(function () {
                $('#tbl_advertisements tbody tr').click(function () {
                    $('#tbl_advertisements tbody tr.table-dark').removeClass('table-dark');
                    $(this).addClass('table-dark');
                });
            }); 

            var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            url = '/datatable-translations/lang-' + lang + '.json';
            var tbl_advertisements = $('#tbl_advertisements').DataTable({
                createdRow: function( row, data, index) {
                    if(index == 0) {
                        $(row).addClass('table-dark');
                    }
                },
                serverSide: true,
                rowReorder: true,
                searching: false,
                bLengthChange : false,
                bInfo : false,
                paging : false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.rankingMonitor') !!}",
                    data: function(d) {
                        var dates = $('#tbl_advertisements').data('dates');
                        d.date = dates;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'fulldate',
                        name: 'date'
                    },
                    {
                        data: 'participants',
                        name: 'participants'
                    },
                
                    {
                        data: 'cumulative_mining',
                        render: function ( data, type, row, meta ) {
                            return data+' BST';
                        } 
                    },
                ],
                order: [[3, 'desc']],
            
            });

            $('#tbl_order_ranking').hover(function () {
                $('#tbl_order_ranking tbody tr').click(function () {
                    $('#tbl_order_ranking tbody tr.table-dark').removeClass('table-dark');
                    $(this).addClass('table-dark');
                });
            }); 


            var tbl_order_ranking = $('#tbl_order_ranking').DataTable({
                createdRow: function( row, data, index) {
                    if(index == 0) {
                        $(row).addClass('table-dark');
                    }
                },
                serverSide: true,
                rowReorder: true,
                searching: false,
                bLengthChange : false,
                bInfo : false,
                paging : false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.rankingOrder') !!}",
                    data: function(d) {
                        var dates = $('#tbl_advertisements').data('dates');
                        d.date = dates;
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'sales_volume',
                        name: 'sales_volume'
                    },
                
                    {
                        data: 'money_matic',
                        render: function ( data, type, row, meta ) {
                            return data+' MATIC';
                        } 
                    },
                ],
                order: [[2, 'desc']],
            
            });

            setting_date(date = 1);

            function setting_date(date) {
                $('#modal_loading').show()
                $('#tbl_advertisements').data('dates', { date: date });
                tbl_advertisements.draw();
                $('#tbl_order_ranking').data('dates', { date: date });
                tbl_order_ranking.draw()
               var data = {
                    date: date,
                }
                $.ajax({
                    url: "{!! route('admin.main.fetchData') !!}",
                    datatype: "html",
                    type: "get",
                    data: data,
                    success: function(response) {
                        $('#modal_loading').hide();
                        var lineChart = document.getElementById('line-chart');
                        var myChart = new Chart(lineChart, {
                            type: 'line',
                            data: {
                                labels: response.lable,
                                datasets: [
                                    {
                                        label: "@lang('translation.Number_of_participants')",
                                        data: response.participants,
                                        backgroundColor: 'rgba(0, 128, 128, 0.3)',
                                        borderColor: 'rgba(0, 128, 128, 0.7)',
                                        borderWidth: 1
                                    },
                                    {
                                        label: "@lang('translation.Mining')",
                                        data:  response.cumulative_mining,
                                        backgroundColor: 'rgba(255, 99, 71, 0)',
                                        borderColor: 'rgb(255, 99, 132)',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero:true
                                        }
                                    }],
                                },
                            }
                        });
              
                        $(".breadcrumb-item.remote-old").on("click", function(){
                            myChart.destroy();
                        });
                        $('.total_cumulative_mining').text(response.totalCumulativeMining);
                        $('.total_time').text(response.totalTime);
                        $('.unit_cumulative_mining').text(response.unitCumulativeMining);
                        $('.user_connect').text(response.userConnect);
                        $('.total_new_user').text(response.totalNewUser);
                        $('.total_matic').text(response.totalMatic);
                        $('.unit_total_matic').text(response.unitTotalMatic);
                    },
                    error: function(error) {

                    },
                })
            };

        </script>
@endsection