@extends('layouts.master')
@section('title')    @lang('translation.Sales_status') @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>#oder_status_table tbody tr{cursor: pointer;}</style>
@endsection
@section('content')
@section('content')
    @component('common-components.breadcrumb')
        @slot('pageTitle')
            @lang('translation.Home')
        @endslot
        @slot('MenuTitle')
            @lang('translation.Manage_Products')
        @endslot
        @slot('title')
          @lang('translation.Sales_status')
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  <div class="row">
                        <div class="col-md-10">
                            <form action="" id="order_status_filter_form"></form>
                            <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                                <div class="col-12">
                                    <h4 class="card-title">@lang('translation.Setting_the_time_period')</h4>
                                </div>
                                <div class="col-md-4">
                                    <button value="7" class="btn btn-primary btn-secondary action-btn-time btn-rounded waves-effect waves-light date_btn 1_week_btn handle_hover_chart"  onclick="setting_date(7)">@lang('translation.1_week')
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button value="30" class="btn btn-primary btn-rounded waves-effect waves-light action-btn-time date_btn handle_hover_chart" onclick="setting_date(30)" >@lang('translation.1_month')</button>
                                </div>
                                <div class="col-md-4">
                                    <button value="180"  class="btn btn-primary btn-rounded waves-effect waves-light action-btn-time date_btn handle_hover_chart" onclick="setting_date(180)">@lang('translation.6_month')</button>
                                </div>
                                <div class="d-flex align-items-center input-daterange">
                                    <div class="col-md-5 input-daterange">
                                        <input type="date" class="form-control" name="date_start" placeholder="dd-mm-yyyy" />
                                    </div>
    
                                    <div class="col-md-1 text-center">
                                    <i class="">~</i>
                                    </div>
    
                                    <div class="col-md-5 input-daterange">
                                        <input type="date" class="form-control" name="date_end" placeholder="dd-mm-yyyy" />
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row mt-2">
                                <p id="date_start_validate" class="text-danger text-center"></p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a  class="btn btn-success float-end" id="btnExport">
                                @lang('translation.Download_excel')
                            </a>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('translation.Coin_revenue_status')</h4>
                    <div class="">
                        <table class="table table-hover tbl_order_status" id="oder_status_table" style="width: 100%">
                            <thead>
                                <tr class="bg-secondary text-white">
                                    <th>@lang('translation.date')</th>
                                    <th>@lang('translation.Polygon_(MATIC)')</th>
                                    <th>@lang('translation.BTS')</th>
                                    <th>@lang('translation.BMT')</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>

                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">@lang('translation.Coin_Revenue_Graph')</h4>
                    <canvas id="line-chart" height="240" ></canvas>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


    <div class="row">
        <h4 class="card-title mb-4">@lang('translation.Coin_revenue_details')</h4>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table_matic">
                            <thead>
                                <tr class="" style="background: #b0b7c5">
                                    <th>@lang('translation.Polygon_(MATIC)') 100%</th>
                                    <th class="float-end total_matic">0 @lang('translation.MATIC')</th>
                                </tr>
                            </thead>
                            <tbody id="sum_each_matic">
                                    <tr>
                                        <th>2022-06-29</th>
                                        <td class="float-end">23,492 MATIC</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table_bst">
                            <thead>
                                <tr style="background: #b0b7c5">
                                    <th>@lang('translation.BST') 100%</th>
                                    <th class="float-end total_bst">0 @lang('translation.BST')</th>
                                </tr>
                            </thead>
                            <tbody id="sum_each_bst">
                                    <tr>
                                        <th>2022-06-29</th>
                                        <td class="float-end">23,492 MATIC</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table_bmt">
                            <thead>
                                <tr style="background: #b0b7c5">
                                    <th>@lang('translation.BMT') 100%</th>
                                    <th class="float-end total_bmt">0 @lang('translation.BMT')</th>
                                </tr>
                            </thead>
                            <tbody id="sum_each_bmt">
                                    <tr>
                                        <th>2022-06-29</th>
                                        <td class="float-end">23,492 MATIC</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
            $('.tbl_order_status tbody tr').click(function(e) {
                $('.tbl_order_status tbody tr.table-dark').removeClass('table-dark');
                $(this).addClass('table-dark');
            });

            $('.action-btn-time').click(function(e) {
                $('.action-btn-time.btn-secondary').removeClass('btn-secondary');
                $(this).addClass('btn-secondary');
                $('input[name="date_end"]').val('');
                $('input[name="date_start"]').val('');
                oder_status_table.draw();
            });

            $("#oder_status_table").on('click','tbody tr',function(){
                var currentRow=$(this).closest("tr"); 
                var date=currentRow.find("td:eq(0)").text(); 
                var matic=currentRow.find("td:eq(1)").text(); 
                var bst=currentRow.find("td:eq(2)").text(); 
                var bmt=currentRow.find("td:eq(3)").text(); 
                var data=date+"\n"+matic+"\n"+bst+"\n"+bmt;
                data = {
                    date : date,
                    matic : matic,
                    bst : bst,
                    bmt : bmt,
                };
                tbody_sum_detail(data);

            });
            var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            url = '/datatable-translations/lang-' + lang + '.json';
            var oder_status_table = $('#oder_status_table').DataTable({
                createdRow: function( row, data, index) {
                    if(index == 0) {
                        $(row).addClass('table-dark');
                    }
                },
                serverSide: true,
                searching: false,
                lengthChange: false,
                ordering: false,
                info: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.products.orders.sales.fetchdata') !!}",
                    data: function(d) {
                        var dates = $('#oder_status_table').data('dates');
                        d.date = dates
                        d.from_date = $('input[name="date_start"]').val(),
                        d.to_date = $('input[name="date_end"]').val()
                    }
                },
                drawCallback: function( settings ) {
                    var date = [];
                    var bmt = [];
                    var bst = [];
                    var matic = [];
                    var count = 0; 
                    for(count; count <settings.aoData.length;count++) {
                        date.push(settings.aoData[count]._aData.date);
                        bmt.push(settings.aoData[count]._aData.sum_money_bmt);
                        bst.push(settings.aoData[count]._aData.sum_money_bst);
                        matic.push(settings.aoData[count]._aData.sum_money_matic);
                    }
                    var char_data = {
                        labels:date,
                        datasets:[
                            {
                                label: 'MATIC',
                                backgroundColor: "#45c490",
                                data: matic,
                            }, {
                                label: 'BST',
                                backgroundColor: "#008d93",
                                data: bst,
                            }, {
                                label: 'BMT',
                                backgroundColor: "#2e5468",
                                data: bmt,
                            }
                        ]
                    };
                    
                    var lineChart = document.getElementById('line-chart');
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
                    $(".handle_hover_chart").on("click", function(){
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
                    array = [];
                    setTimeout(function(){
                    $('#oder_status_table').find('.table-dark td').each (function() {
                        array.push($(this).text())
                    });
                    date =  array[0];
                    matic =  array[1];
                    bst =  array[2];
                    bmt =  array[3];
                    data = {
                        date :  array[0],
                        matic : matic,
                        bst : bst,
                        bmt : bmt,
                    };
                    tbody_sum_detail(data);
                    
                },2000);
                },
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'sum_money_matic', render: function ( data, type, row, meta ) {
                            return data+' MATIC';
                        } 
                    },
                    { data: 'sum_money_bst', render: function ( data, type, row, meta ) {
                            return data+' BST';
                        } 
                    },
                    { data: 'sum_money_bmt', render: function ( data, type, row, meta ) {
                            return data+' BMT';
                        } 
                    },
                ],
                pageLength: 30,
                paging: false
            });

          
            var table = $('#oder_status_table').DataTable();
            $("#btnExport").click(function(e) 
            {
                table.page.len( -1 ).draw();
                window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#oder_status_table').parent().html()));
                setTimeout(function(){
                    table.page.len(10).draw();
                }, 1000)
            });
        
            
            function setting_date(date) {
                $('#oder_status_table').data('dates', { date: date });
                $("#date_start_validate").html('')
                oder_status_table.draw();
            }

            $('#oder_status_table').hover(function () {
                $('tbody tr').click(function () {
                    $('.tbl_order_status tbody tr.table-dark').removeClass('table-dark');
                    $(this).addClass('table-dark');
                });
            });      
            
        
            var today = new Date();
            $('input[name="date_start"]').on('change', function(){
                check_date  =  check_date_start();
                if(check_date){
                    if($('input[name="date_end').val() != undefined) {
                    $('.action-btn-time.btn-secondary').removeClass('btn-secondary');
                    oder_status_table.draw();
                    }
                }
              
            })

            $('input[name="date_end"]').on('change', function(){
                check_date =  check_date_end();
                console.log(check_date);
                if(check_date){
                    $('.action-btn-time.btn-secondary').removeClass('btn-secondary');
                    oder_status_table.draw();
                }
                
            })
            
            function check_date_start(){
                $('#date_start_validate').html('');
                var date_start = new Date($('input[name="date_start"]').val());
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
                return true;
            }
            function check_date_end(){
                var date_end = new Date($('input[name="date_end"]').val());
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
                };
                return true;
            }

            function tbody_sum_detail(data){
                $.ajax({
                    url: '{{ route('admin.products.orders.revenue_detail') }}',
                    datatype: "json",
                    type: "POST",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        
                        sum_each_matic_html = '';
                        sum_each_bmt_html = '';
                        if(response.response.purchase){
                            if(response.response.purchase.sum_money_matic){
                                sum_each_matic_html += `<tr>
                                <th> {{trans('translation.purchase')}} (${response.response.purchase.percent_matic}%)</th>
                                <td class="float-end"> ${response.response.purchase.sum_money_matic +" MATIC"}</td>
                                </tr>`;
                            }
                        }
                        if(response.response.repair){
                            if(response.response.repair.sum_money_matic){
                                sum_each_matic_html += `<tr>
                                <th> {{trans('translation.repair')}} (${response.response.repair.percent_matic}%)</th>
                                <td class="float-end"> ${response.response.repair.sum_money_matic +" MATIC"}</td>
                                </tr>`;
                            }
                        }
                        if(response.response.upgrade){
                            if(response.response.upgrade.sum_money_matic){
                                sum_each_matic_html += `<tr>
                                <th> {{trans('translation.upgrade')}} (${response.response.upgrade.percent_matic}%)</th>
                                <td class="float-end"> ${response.response.upgrade.sum_money_matic +" MATIC"}</td>
                                </tr>`;
                            }
                        }
                        if(response.response.purchase){
                            if(response.response.purchase.sum_money_bmt){
                                sum_each_bmt_html += `<tr>
                                <th> {{trans('translation.purchase')}} (${response.response.purchase.percent_bmt}%)</th>
                                <td class="float-end"> ${response.response.purchase.sum_money_bmt +" BMT"}</td>
                                </tr>`;
                            }
                        }
                        if(response.response.upgrade){
                            if(response.response.upgrade.sum_money_bmt){
                                sum_each_bmt_html += `<tr>
                                <th> {{trans('translation.upgrade')}} (${response.response.upgrade.percent_bmt}%)</th>
                                <td class="float-end"> ${response.response.upgrade.sum_money_bmt +" BMT"}</td>
                                </tr>`;
                            }
                        }
                        if(response.response.repair){
                            if(response.response.repair.sum_money_bst){
                                sum_each_bmt_html += `<tr>
                                <th> {{trans('translation.repair')}} (${response.response.repair.percent_bmt}%)</th>
                                <td class="float-end"> ${response.response.repair.sum_money_bst +" BMT"}</td>
                                </tr>`;
                            }
                        }
                        sum_each_bst_html = '';
                        if(response.response.purchase){
                            if(response.response.purchase.sum_money_bst){
                                sum_each_bst_html += `<tr>
                                <th> {{trans('translation.purchase')}} (${response.response.purchase.percent_bst}%)</th>
                                <td class="float-end"> ${response.response.purchase.sum_money_bst +" BST"}</td>
                                </tr>`;
                            }
                        }
                        if(response.response.upgrade){
                            if(response.response.upgrade.sum_money_bst){
                                sum_each_bst_html += `<tr>
                                <th> {{trans('translation.upgrade')}} (${response.response.upgrade.percent_bst}%)</th>
                                <td class="float-end"> ${response.response.upgrade.sum_money_bst +" BST"}</td>
                                </tr>`;
                            }
                        }
                        if(response.response.repair){
                            if(response.response.repair.sum_money_bmt){
                                sum_each_bst_html += `<tr>
                                <th> {{trans('translation.repair')}} (${response.response.repair.percent_bst}%)</th>
                                <td class="float-end"> ${response.response.repair.sum_money_bst +" BST"}</td>
                                </tr>`;
                            }
                        }
                        $("#sum_each_matic").html(sum_each_matic_html)
                        $("#sum_each_bst").html(sum_each_bst_html)
                        $("#sum_each_bmt").html(sum_each_bmt_html)
                        $('.table_matic .total_matic').text(response.matic);
                        $('.table_bmt .total_bmt').text(response.bmt);
                        $('.table_bst .total_bst').text(response.bst);
                    },
                    error: function(error) {

                    },
                })
            }
        </script>
@endsection
