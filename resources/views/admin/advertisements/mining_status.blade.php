@extends('layouts.master')
@section('title') @lang('translation.Mining_Status') @endsection
@section('content')
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        input[type="checkbox"], input[type="search"]::-webkit-search-cancel-button, .checkbox_all {cursor: pointer;}
        .dataTable > thead > tr > th[class*="sort"]:before,
        .dataTable > thead > tr > th[class*="sort"]:after {
            content: "" !important;
        }
    </style>
@endsection
 @component('common-components.breadcrumb')
        @slot('pageTitle')
            @lang('translation.Home')
        @endslot
        @slot('MenuTitle')
            @lang('translation.Advertising_Management')
        @endslot
        @slot('title')
            @lang('translation.income_status')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body mining_status_filter">
                    <div class="col-md-12">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Period_setting')</label>
                            <div class="col-md-8">
                                <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-rounded waves-effect waves-light selectDate btn-secondary" id="1">@lang('translation.1_day')</button>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-rounded waves-effect waves-light selectDate"  id="7">@lang('translation.1_week')</button>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary btn-rounded waves-effect waves-light selectDate" id="30">@lang('translation.1_month')</button>
                                    </div>
                                    <div class="col-12">
                                        <input type="date" class="form-control" name="date_start" />
                                    </div>
                                    <div class="col-12">
                                        ~
                                    </div>
                                    <div class="col-12">
                                        <input type="date" class="form-control" name="date_end" />
                                       
                                    </div>
                                </div>
                            </div>
                            <p id="date_start_validate" class="text-danger"></p>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="example-name-input" class="col-md-4 col-form-label">@lang('translation.Top_10_Mining_Masters')</label>
                            <form class="setting_notice_table">
                                <table id="mining_status_top_ten" class="table table-bordered dt-responsive"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>@lang('translation.ranking')</th>
                                            <th>@lang('translation.id')</th>
                                            <th>@lang('translation.Mining')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="col-md-6">
                         <label for="example-name-input" class="col-md-4 col-form-label">@lang('translation.mining_amount_graph')</label>
                            {{-- <div id="mining_amount_graph" class="apex-charts" dir="ltr"></div> --}}
                            <canvas id="mining_amount_graph" height="240" ></canvas>
                        </div>
                    </div> 
                </div>
                <div class="card-body user_filter">
                    <div class="col-md-12">
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Cumulative_mining_ranking')</label>
                        </div>
                    </div>
                    <div class="col-12">
                            <div class="row py-4">
                                <div class="col-12 col-md-4">
                                    <input type="search" placeholder="{{trans('translation.Member_Search')}}" class="form-control"
                                         name="search" />
                                </div>
                                <div class="col-12 col-md-2">
                                    <button type="button" class="btn btn-primary waves-effect waves-light">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <div class="mb-3 row">
                        <div class="col-md-12">
                            <form class="setting_notice_table">
                                <table id="mining_status_top_from_1_to_50" class="table table-bordered dt-responsive"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>@lang('translation.ranking')</th>
                                            <th>@lang('translation.id')</th>
                                            <th>@lang('translation.Mining')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
       <!-- apexcharts -->
       <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
       <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>

       <script src="{{ URL::asset('/assets/libs/chart-js/chart-js.min.js') }}"></script>
       <script src="{{ URL::asset('/assets/js/pages/chartjs.init.js') }}"></script>
      <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

       <script>
        var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            url = '/datatable-translations/lang-' + lang + '.json';
        var mining_status_top_ten = $('#mining_status_top_ten').DataTable({
                serverSide: true,
                searching: false,
                paging : false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.advertisements.mining_status.fetch_data') !!}",
                    data: function(d) {
                        d.limit = 10;
                        // Retrieve dynamic parameters
                        var date = $('#mining_status_top_ten').data('dates');
                        d.dates = date;
                        d.date_start = $('input[name="date_start"]').val();
                        d.date_end = $('input[name="date_end"]').val();
                    }
                },
                drawCallback: (setting, json) => {
                    array_users = [];
                    array_mining =  [];
                    for(let users  of setting.json.data){
                        array_users.push(users.user_name)
                        array_mining.push(users.sum_cumulative_mining)
                    }
                    var i = 1;
                    var labels = [];
                    for(i ; i <= array_users.length ; i++) {
                        labels.push(i)
                    }

                    var char_data = {
                        labels:labels,
                        datasets:[
                            {
                                label: "@lang('translation.Mining')",
                                backgroundColor: "#4d62c5",
                                data: array_mining,
                            }
                        ]
                    };
                    
                    var lineChart = document.getElementById('mining_amount_graph');
                    var myChart = new Chart(lineChart, {
                        type: 'bar',
                        data: char_data ,
                        options: {
                            tooltips: {
                            displayColors: true,
                            callbacks:{
                                mode: 'x',
                                },
                            },

                            scales: {
                                xAxes: [{
                                    stacked: true,
                                    gridLines: {
                                    display: false,
                                    }
                                }],
                                yAxes: [{
                                    stacked: true,
                                    ticks: {
                                    beginAtZero: false,
                                    },
                                    type: 'linear',
                                    gridLines: {
                                        drawBorder: false,
                                    },
                                }],
                            },
                            responsive: true,
                            maintainAspectRatio: true,
                            legend: { position: 'top' },
                        }
                    });

                    $(".selectDate").on("click", function(){
                        myChart.destroy();
                    });
                    $('input[name="date_start"]').on('chang', function(){
                        check_date  =  check_date_start();
                        if(check_date){
                            myChart.destroy();
                        }
                    })
                    $('input[name="date_end"]').on('change', function(){
                        check_date  =  check_date_end();
                        if(check_date){
                            myChart.destroy();
                        }
                    })  
                },
                columns: [
                    { data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'sum_cumulative_mining',
                        render: function ( data, type, row, meta ) {
                            return   Intl.NumberFormat('de-DE', { style: 'currency', currency: 'BST' }).format(data);
                        } 
                    }
                    
                ],
                "bLengthChange" : false, //thought this line could hide the LengthMenu
                "bInfo":false, 
                columnDefs: [
                    {orderable: false, targets: 0 },
                    {orderable: false, targets: '_all'},
                ],
                order: [[1, 'asc']],
            });

            var mining_status_top_from_1_to_50 = $('#mining_status_top_from_1_to_50').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.advertisements.mining_status.fetch_data') !!}",
                    data: function(d) {
                        d.limit = 100;
                        // Retrieve dynamic parameters
                        var date = $('#mining_status_top_ten').data('dates');
                        d.dates = date;
                        d.date_start = $('input[name="date_start"]').val();
                        d.date_end = $('input[name="date_end"]').val();
                        d.search = $('input[name="search"]').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', 'orderable': false, 'searchable': false },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'sum_cumulative_mining',
                        render: function ( data, type, row, meta ) {
                            return   Intl.NumberFormat('de-DE', { style: 'currency', currency: 'BST' }).format(data);
                        } 
                    }
                ],
                columnDefs: [
                    {orderable: false, targets: '_all'},
                ],
                order: [[ 1, "asc" ]],
            });
            $('input[name="search"]').on('keyup', function(){
                mining_status_top_from_1_to_50.draw();
            })
            $('input[name="search"]').on('click', function() {
                setTimeout(function(){
                    mining_status_top_from_1_to_50.draw();
                },100);
            })
            $('.selectDate').on('click', function(){
                $('input[name="date_end"]').val('')
                $('input[name="date_start"]').val('')
                $('div.mining_status_filter').find('button.btn-secondary').removeClass(' btn-secondary');
                $(this).addClass(' btn-secondary')
                $('#mining_status_top_ten').data('dates', { date: $(this).attr('id') });
                mining_status_top_ten.draw();
                $('#mining_status_top_from_1_to_50').data('dates', { date: $(this).attr('id') });
                mining_status_top_from_1_to_50.draw();
            })
            // Create our number formatter.
            
            var formatter = new Intl.NumberFormat('en-IN', { maximumSignificantDigits: 3 });
            var today = new Date();
            $('input[name="date_start"]').on('change', function(){
                    $('#date_start_validate').html('');
                    var date_start = new Date($(this).val());
                    var date_end = new Date($('input[name="date_end"]').val());
                    if(date_start > today ){
                        $('#date_start_validate').html('{{trans("translation.Please_enter_start_date_that_is_less_than_the_current_date")}}');
                            return false;
                    };
                    if(!$('input[name="date_end"]').val()){
                            return false;
                    };
                    if(date_start > date_end){
                            $('#date_start_validate').html('{{trans("translation.Please_enter_start_date_that_is_less_than_the_end_date")}}');
                            return false;
                    }
                    $('div.mining_status_filter').find('button.btn-secondary').removeClass(' btn-secondary');
                    mining_status_top_ten.draw();
                    mining_status_top_from_1_to_50.draw();

            })
            $('input[name="date_end"]').on('change', function(){
                    var date_end = new Date($(this).val());
                    $('#date_start_validate').html('');
                    if(date_end > today ){
                        $('#date_start_validate').html('{{trans("translation.Please_enter_end_date_that_is_less_than_the_current_date")}}');
                            return false;
                    };
                    if(!$('input[name="date_start"]').val()){
                            $('#date_start_validate').html('{{trans("translation.Please_enter_start_date")}}')
                            return false;
                    };
                    var date_start = new Date($('input[name="date_start"]').val());
                    if(date_start > date_end){
                            $('#date_start_validate').html('{{trans("translation.Please_enter_start_date_that_is_less_than_the_end_date")}}');
                            return false;
                    }
                    $('div.mining_status_filter').find('button.btn-secondary').removeClass(' btn-secondary');
                    mining_status_top_from_1_to_50.draw();
                    mining_status_top_ten.draw();
            })
       </script>
@endsection