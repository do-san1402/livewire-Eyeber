@extends('layouts.master')
@section('title')    @lang('translation.Advertising_monitoring') @endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <style>input[type="search"]::-webkit-search-cancel-button, #datatable_ads tbody tr {cursor: pointer;}</style>
@endsection
@section('content')
@section('content')
    @component('common-components.breadcrumb')
        @slot('pageTitle')
            @lang('translation.Home')
        @endslot
        @slot('MenuTitle')
            @lang('translation.Advertising_Management')
        @endslot
        @slot('title')
            @lang('translation.Advertising_monitoring')
        @endslot
    @endcomponent
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">@lang('translation.Advertisement_name_is_entered')</h4>
                  
                    <canvas id="line-chart" height="300"></canvas>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <form class="setting_product_table">
                        <table id="datatable_ads" class="table table-bordered dt-responsive"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('translation.Ranking')</th>
                                    <th>@lang('translation.Advertisement_name')</th>
                                    <th>@lang('translation.Advertising_period')</th>
                                    <th>@lang('translation.Number_of_participants')</th>
                                    <th>@lang('translation.Cumulative_mining')</th> 
                                    <th>@lang('translation.id')</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>

                        </table>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="setting_product_table">
                        <h4 class="card-title">@lang('translation.Advertisement_List')</h4>
                        <table id="datatable" class="table table-bordered dt-responsive"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th >@lang('translation.Turn')</th>
                                    <th>@lang('translation.advertisement_name')</th>
                                    <th>@lang('translation.advertisement_date')</th>
                                    <th>@lang('translation.views')</th>
                                    <th>@lang('translation.Number_of_participants')</th>
                                    <th>@lang('translation.Total_mining')</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                            </tbody>

                        </table>
                    </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    
@endsection
@section('script')


    <script>
        $('.datatable_ads tbody tr').click(function(e) {
            $('.datatable_ads tbody tr.table-dark').removeClass('table-dark');
            $(this).addClass('table-dark');
        });

        $(function() {
            var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            url = '/datatable-translations/lang-' + lang + '.json';
            
            var advertisement_table = $('#datatable').DataTable({
                serverSide: true,
                responsive: true,
                language: {
                    url: url,
                    search: "@lang('translation.Ad_search')",
                },
                ajax: {
                    url: "{!! route('admin.advertisements.fetchDataMonitor') !!}",
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
                        data: 'views',
                        name: 'views'
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

            $('form#advertisement_filter_form input:checkbox').on('change', function() {
                advertisement_table.draw();
            });
            $('form#advertisement_filter_form input[name="search"]').on('keyup', function() {
                advertisement_table.draw();
            })

            var advertisement_table = $('#datatable_ads').DataTable({
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
                    url: "{!! route('admin.advertisements.ads_statistics.datatable_ads') !!}",
                },
                drawCallback: function( settings ) {
                    setTimeout(function(){
                        $('#datatable_ads').find('.table-dark td').each (function() {
                            var currentRow = $(this).closest("tr");
                            sum_datatable_ads(currentRow);
                        });
                    },300);
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
                    {
                        data: 'advertisement_id',
                        name: 'advertisement_id',
                        visible: false,
                    },
                ],
               
                order: [[3, 'desc']],
                });

            });

            $('#datatable_ads').hover(function () {
                $('#datatable_ads tbody tr').click(function () {
                    $('#datatable_ads tbody tr.table-dark').removeClass('table-dark');
                    $(this).addClass('table-dark');
                });
            }); 

            $('#datatable_ads').on('click','tbody tr',function (e) {
                e.preventDefault();  
                var currentRow = $(this).closest("tr");
                sum_datatable_ads(currentRow);
            })

            function sum_datatable_ads(currentRow) {
                var data = $('#datatable_ads').DataTable().row(currentRow).data();
                var id_watch_log  = [];
                var count = 0; 
                for(count; count <data['item'].length; count++) {
                    id_watch_log.push(data['item'][count].id);
                }
                var id_ads = data.advertisement_id;
                var data = {
                    id_watch_log: id_watch_log,
                    id_ads: id_ads, 
                }
                $.ajax({
                    url: "{!! route('admin.advertisements.ads_statistics.fetchDataChart') !!}",
                    datatype: "html",
                    type: "get",
                    data: data,
                    success: function(response) {
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

                    },
                    error: function(error) {

                    },
                })
            }      

       
    </script>
     
    <!-- apexcharts -->
    <script src="{{ URL::asset('/assets/libs/chart-js/chart-js.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/chartjs.init.js') }}"></script>

    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>

    




@endsection