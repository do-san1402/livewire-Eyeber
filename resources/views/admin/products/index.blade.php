@extends('layouts.master')
@section('title')
    @lang('translation.Product_list')
@endsection
@section('css')
    <!-- DataTables -->
    <link href="{{ URL::asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>input[type="checkbox"], input[type="search"]::-webkit-search-cancel-button, .checkbox_all {cursor: pointer;}</style>
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pageTitle')
             @lang('translation.Home')
        @endslot
        @slot('childrenTitle')
          @lang('translation.Manage_Product')
        @endslot
         @slot('title')
             @lang('translation.Product_list')
        @endslot
    @endcomponent
    <div class="filter_datatable_wrap">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body user_filter">
                        <form id="products_filter_form">
                            <div class="col-12 col-md-12">
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <input type="search" placeholder="@lang('translation.Enter_a_search_term')" class="form-control" name="search">
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <button type="button" class="btn btn-primary waves-effect waves-light">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>    
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 col-md-7">
                                    <strong>@lang('translation.Sales_status')</strong>
                                    <input class="ms-2" type="checkbox" id="all_status_product" />
                                    <label for="all_status_product"> @lang('translation.All')</label>
                                    @foreach ($status_sales as $key => $status_sale)
                                        <input class="ms-2" type="checkbox" id="{{$key}}_status_product" name="status_product" value="{{$status_sale}}" />
                                        <label for="{{$key}}_status_product">{{trans('translation.'.$key)}}</label>
                                    @endforeach    
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="col-md-7 float-end">
                                        <a class="btn btn-success float-end" href="{{route('admin.products.register')}}"> @lang('translation.Product_registration')</a>
                                    </div>    
                                </div>
                            </div>
                        </form>
                        <div class="col-12 mt-4">
                            <div class="row row-cols-lg-auto gx-3 gy-2 align-items-center">
                                <div class="col-6 col-md-2">
                                    <button class="btn btn-info waves-effect waves-light active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_change_status_user">@lang('translation.Status_Change')</button>
                                </div>
                                <div class="col-6 col-md-2">
                                    <button class="btn btn-secondary ms-2 active_with_checkbox" disabled data-bs-toggle="modal"
                                        data-bs-target="#modal_delete_product"> @lang('translation.Delete')</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="setting_product_table">
                            <table id="product_table" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th><input role="button" type="checkbox" id="all_age" name="somecheckbox" class="checkbox_all"></th>
                                        <th >@lang('translation.Product_name')</th>
                                        <th>@lang('translation.Polygon')</th>
                                        <th>@lang('translation.Level')</th>
                                        <th>@lang('translation.Durability')</th>
                                        <th>@lang('translation.Sales_status')</th>
                                        <th>@lang('translation.Edit')</th>
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
    </div>



    <div id="modal_delete_product" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_delete_product_la_bel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Delete_Member')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('translation.Cannot_restore_product_when_delete_Are_you_sure_you_want_to_remove')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success waves-effect waves-light delete_product"
                        data-bs-dismiss="modal">@lang('translation.Yes')</button>
                    <button type="button" class="btn btn-danger waves-effect" data-bs-dismiss="modal">@lang('translation.No')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->

    <div id="modal_change_status_user" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_change_status_user_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Status_Member')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-select" name="change_status_member">
                        @foreach ($status_sales as $key => $status_sale)
                        <option value="{{$status_sale}}">@lang("translation.$key")</option>

                        @endforeach
                    </select>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success waves-effect waves-light setting_change_status_product"
                        data-bs-dismiss="modal">@lang('translation.Setting')</button>
                    <button type="button" class="btn btn-danger waves-effect"
                        data-bs-dismiss="modal">@lang('translation.Cancel')</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->
@endsection
@section('script')
    <script>
        $(function() {
            var lang = document.getElementsByTagName("html")[0].getAttribute("lang");
            url = '/datatable-translations/lang-' + lang + '.json';
            var product_table = $('#product_table').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.products.fetchData') !!}",
                    data: function(d) {
                        var products_filter_form = new FormData($('form#products_filter_form')[0]);
                            d.search = products_filter_form.get('search'),
                            d.status_products = products_filter_form.getAll('status_product')
                    }
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price_matic',
                        name: 'price_matic'
                    },
                    {
                        data: 'level',
                        name: 'level'
                    },
                    {
                        data: 'durability',
                        name: 'durability'
                    },
                    {
                        data: 'sale_status_id',
                        name: 'sale_status_id'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                columnDefs: [
                    {orderable: false, targets: 3 },
                ],
                order: [[5, 'asc']],
                
            });

            $('form#products_filter_form input:checkbox').on('change', function() {
                if($('#all_status_product').is(':checked')){
                    $('input[name="status_product"]').prop('disabled', true);
                }else{
                    $('input[name="status_product"]').prop('disabled', false);
                }
                if($('input[name="status_product').is(':checked')){
                    $('#all_status_product').prop('disabled', true);
                }else{
                    $('#all_status_product').prop('disabled', false);
                }
                product_table.draw();
            });

            $('form#products_filter_form input[name="search"]').on('keyup', function() {
                product_table.draw();

            })
            
            $('button.delete_product').on('click', function() {
                var products = []
                $("input[name='product_id[]']:checked").each(function() {
                    products.push(parseInt($(this).val()));
                });
                if(products.length === 0){
                    return false;
                }
                data = {
                    products: products
                };
                $.ajax({
                    url: '{{ route('admin.products.delete') }}',
                    datatype: "html",
                    type: "delete",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        notificationSwal(response.status);
                        $('.active_with_checkbox').prop('disabled', true);
                        product_table.draw();
                        $(".checkbox_all").prop('checked', false); 
                    },
                    error: function(error) {
                        errorSwal();
                    },
                })
            })
            $('.setting_change_status_product').on('click', function(){
                status = parseInt($('.modal-body select[name="change_status_member"]').val()) ;
                if(!status){
                    return false;
                }
                var products = []
                $("input[name='product_id[]']:checked").each(function() {
                    products.push(parseInt($(this).val()));
                });
                data = {
                    status: status,
                    products : products,
                };
                $.ajax({
                    url: '{{ route('admin.products.changeStatus') }}',
                    datatype: "html",
                    type: "put",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        notificationSwal(response.status);
                        $('.active_with_checkbox').prop('disabled', true);
                        product_table.draw();
                        $(".checkbox_all").prop('checked', false); 
                    },
                    error: function(error) {
                        errorSwal();
                    },
                })
            })
        });
    </script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
@endsection
