@extends('layouts.master')
@section('title') @lang('translation.Product_purchase_status') @endsection
@section('content')
@section('css')
<style>input[type="search"]::-webkit-search-cancel-button {cursor: pointer;}</style>
@endsection
@component('common-components.breadcrumb')
    @slot('pageTitle')
             @lang('translation.Home')
        @endslot
        @slot('childrenTitle')
          @lang('translation.Product_management')
        @endslot
         @slot('title')
             @lang('translation.Product_purchase_status')
        @endslot
@endcomponent 
  <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body user_filter">
                    <form id="orders_filter_form">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <input type="search" placeholder="@lang('translation.Enter_a_search_term')" class="form-control" 
                                        name="search" />
                                </div>
                                <div class="col-12 col-md-2">
                                    <button type="button" class="btn btn-primary waves-effect waves-light">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-3 col-form-label pr-0">@lang('translation.Product_category')</label>
                                    <div class="col-8 float-end px-0 ">
                                        <select class="form-select" name='order_category'>
                                                <option value="-1">@lang('translation.all')</option>
                                                @foreach ($order_categorys as $key => $order_category)
                                                    <option value="{{$order_category}}">{{trans('translation.'.$key)}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-3 px-0 col-form-label">@lang('translation.product_selection')</label>
                                    <div class="col-md-8 px-0">
                                        <select class="form-select" name='product_id'>
                                                    <option value="-1">@lang('translation.all')</option>
                                                @foreach ($products as $product)
                                                    <option value="{{$product->id}}" {{$product->id === (int)$product_id ?  "selected" : ''}}>{{$product->name}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 row">
                                    <label for="example-text-input" class="col-md-3 col-form-label px-0">@lang('translation.purchase_status')</label>
                                    <div class="col-md-8 mt-2 px-0">
                                        <input class="ms-2" type="checkbox" id="all_status_member" />
                                        <label for="all_status_member"> @lang('translation.All')</label>
                                        @foreach ($status_orders as $key => $status_order)
                                            <input class="ms-2" type="checkbox" id="purchase_status_{{$status_order}}"
                                                        name="status" value="{{ $status_order }}" />
                                            <label for="purchase_status_{{$status_order}}">{{ trans('translation.'.$key) }}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="setting_order_table">
                        <table id="order_table" class="table table-bordered dt-responsive"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('translation.Product_purchase_date')</th>
                                    <th>@lang('translation.id')</th>
                                    <th>@lang('translation.Product_category')</th>
                                    <th>@lang('translation.purchase_product')</th>
                                    <th>@lang('translation.purchase_status')</th>
                                    <th>@lang('translation.method_of_payment')</th>
                                    <th>@lang('translation.Amount_of_payment')</th>
                                    <th>@lang('translation.Cancellation_processing')</th>
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
    <div id="modal_delete_admin" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_delete_admin_la_bel" aria-hidden="true">
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
                    <button type="button" class="btn btn-danger waves-effect waves-light delete_admin"
                        data-bs-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-success waves-effect" data-bs-dismiss="modal">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-content -->

    <div id="modal_change_status_admin" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modal_change_status_admin_label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">@lang('translation.Status_Member')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <select class="form-select" name="change_status_member">
                        <option>@lang('translation.Select_state_value')</option>
                    </select>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger waves-effect waves-light setting_change_status_admin"
                        data-bs-dismiss="modal">@lang('translation.Setting')</button>
                    <button type="button" class="btn btn-success waves-effect"
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
            var order_table = $('#order_table').DataTable({
                serverSide: true,
                searching: false,
                language: {
                    url: url,
                },
                ajax: {
                    url: "{!! route('admin.products.orders.fetchData') !!}",
                    data: function(d) {
                        var userFilterData = new FormData($('form#orders_filter_form')[0]);
                            d.user_id =  "{{$user_id}}";
                            d.search = userFilterData.get('search'),
                            d.category_id = userFilterData.get('order_category'),
                            d.product_id = userFilterData.get('product_id'),
                            d.list_status = userFilterData.getAll('status')
                    }
                },
                columns: [
                    {
                        data: 'product_purchase_date',
                        name: 'product_purchase_date'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        data: 'status_order',
                        name: 'status_order'
                    },
                    {
                        data: 'method_of_payment',
                        name: 'method_of_payment'
                    },
                    {
                        data: 'amount_of_payment',
                        name: 'amount_of_payment'
                    },
                    {   data: 'cancellation',
                        name: 'cancellation',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
          
            $('select[name="product_id"]').on('change', function(){
                order_table.draw();
            })
            $('select[name="order_category"]').on('change', function(){
                order_table.draw();
            })
            $('form#orders_filter_form input:checkbox').on('change', function(){
                // All
                if($('#all_status_member').is(':checked')){
                    $('input[name="status"]').prop('disabled', true);
                }else{
                    $('input[name="status"]').prop('disabled', false);
                }
                // Other
                if($('input[name="status"]').is(':checked')){
                    $('#all_status_member').prop('disabled', true);
                }else{
                    $('#all_status_member').prop('disabled', false);
                }

                order_table.draw();
            });
            $('form#orders_filter_form input[name="search"]').on('keyup', function() {
                order_table.draw();
            })
            $('button.delete_admin').on('click', function() {
                var users = []
                $("input[name='user_id[]']:checked").each(function() {
                    users.push(parseInt($(this).val()));
                });
                if (users.length === 0) {
                    return false;
                }
                data = {
                    users: users
                };
                $.ajax({
                    url: '{{ route('admin.admins.deleteAdmin') }}',
                    datatype: "html",
                    type: "delete",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        order_table.draw();
                    },
                    error: function(error) {

                    },
                })
            })
            $('button.setting_change_status_admin').on('click', function() {
                    console.log(134);
                    status_user = parseInt($('.modal-body select[name="change_status_member"]').val());
                    if (!status_user) {
                        return false;
                    }
                    var users = []
                    $("input[name='user_id[]']:checked").each(function() {
                        users.push(parseInt($(this).val()));
                    });
                    data = {
                        status_user: status_user,
                        users: users,
                    };
                    $.ajax({
                        url: '{{ route('admin.admins.changeStatusAdmin') }}',
                        datatype: "html",
                        type: "put",
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            order_table.draw();
                        },
                        error: function(error) {

                        },
                    })
                })
        });
    </script>
    <script src="{{ URL::asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/datatables.init.js') }}"></script>
@endsection