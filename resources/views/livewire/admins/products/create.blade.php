@extends('layouts.master')
@section('title')
    @lang('translation.Product_Detail')
@endsection
@section('css')
    <style>
    .set-width-modal{
        height: 300px;
        overflow-y: auto;
    }
    </style>
@endsection
@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle')
            @lang('translation.Home')
        @endslot
         @slot('MenuTitle')
            @lang('translation.Product_management')
        @endslot
          @slot('ParentTitle')
            @lang('translation.Product_List')
        @endslot
        @slot('title')
            @lang('translation.Product_registration')
        @endslot
    @endcomponent
    <form acction="{{route('admin.products.register')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row mb-4">
            <div class="col-xl-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row align-items-end">
                            <label for="example-text-input" class="col-md-12 col-form-label">@lang('translation.Product_Thumbnail')</label>
                            <div class="col-md-6">
                                <img src="{{URL::asset('assets/images/logo-sm.png')}}" alt=""
                                    class="avatar-lg img-thumbnail">
                            </div>
                            <div class="col-md-6">
                                <input type="file" name="image" value="" class="hidden"
                                    id="upload_file_input" class="form-control">
                                <a type="submit"
                                    class="btn btn-success waves-effect waves-light mb-1 change-image float-end">@lang('translation.Image_registration')</a>
                                 
                            </div>
                            <p class="d-none text-danger form-text" id="image_validation">{{trans('translation.please_select_the_correct_format_image')}}</p>
                            @error('image') 
                                <small class="form-text text-danger">
                                    @lang('translation.Please_enter_image')
                                </small>
                            @enderror   
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <a  class="btn btn-success w-lg waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#product_upgrade_setting">@lang('translation.Upgrade_Settings')</a>
                            <a  class="btn btn-primary waves-effect waves-light mb-1"
                                data-bs-toggle="modal" data-bs-target="#product_enhancement_settings">@lang('translation.Enhancement_Settings')</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-0">
                    <div class="card-body">
                        <h4 class="card-title">@lang('translation.Product_information')</h4>
                        <div class="mb-3 row">
                            <label for="example-id-input" class="col-md-3 col-form-label">@lang('translation.Product_name')</label>
                            <div class="col-md-8">
                                <input class="form-control" name="name" type="text" value="{{old('name')}}" placeholder="@lang('translation.Product_name')"
                                    id="example-id-input">
                                 @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif    
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-name-input" class="col-md-3 col-form-label">@lang('translation.Brief_description')</label>
                            <div class="col-md-8">
                                <textarea id="textarea" class="form-control" name="description" placeholder="@lang('translation.Brief_description')" maxlength="225" rows="3">{{old('description')}}</textarea>
                                  @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif 
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-name-input" class="col-md-3 col-form-label">@lang('translation.Available_Coins')</label>
                            <div class="col-md-8">
                                <select class='form-select' name="available_coin_id">
                                    @if(old('available_coin_id'))
                                        @foreach ($available_coins as $key => $available_coin)
                                            @if(old('available_coin_id') == $available_coin )
                                                <option value="{{old('available_coin_id')}}">{{trans('translation.' . $key)}}</option>
                                            @endif
                                        @endforeach
                                    @else
                                        <option value="">@lang('translation.Choose')</option>
                                    @endif
                                    @foreach ($available_coins as $key => $available_coin)
                                        <option value="{{ $available_coin }}">{{ trans('translation.' . $key) }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->any())        
                                <p class="text-danger">{{ $errors->first('available_coin_id') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Sales_Amount_(Polygon)')</label>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input class="form-control" type="number" step="any" name="price_matic"
                                        value="{{old('price_matic')}}"  id="price_matic" placeholder="@lang('translation.MATIC')">
                                    @if ($errors->any())        
                                    <p class="text-danger">{{ $errors->first('price_matic') }}</p>
                                    @endif
                                    </div>
                                    <label class="col-md-4 col-form-label" for="price_matic">@lang('translation.MATIC')</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-id-input" class="col-md-3 col-form-label">@lang('translation.Durability')</label>
                            <div class="col-md-8">
                                <input class="form-control" type="number" name="durability" value="{{old('durability')}}" placeholder="@lang('translation.Durability')"
                                    id="example-id-input">
                                @if ($errors->any())        
                                    <p class="text-danger">{{ $errors->first('durability') }}</p>
                                    @endif            
                            </div>
                        </div>
                         <div class="mb-3 row">
                            <label class="col-md-3 col-form-label"></label>
                            <div class="col-md-9">
                                <div class="row">
                                        <div class="col-md-2">
                                             <label class="col-md-12 col-form-label"
                                                for="Direct_setting">@lang('translation.Durability')</label>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="row">
                                               <div class="col-md-6">
                                                    <input type="number" step=any min="1" id="mining_amount_when__decrease" class="form-control" name="mining_amount_when__decrease"
                                                        value="">
                                                    @if ($errors->any())        
                                                        <p class="text-danger">{{ $errors->first('mining_amount_when__decrease') }}</p>
                                                    @endif            
                                                </div>
                                                <label class="col-md-6 col-form-label"
                                                    for="mining_amount_when__decrease">@lang('translation.Mining_amount_when_%_decrease')</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input  type="number" min="1" step=any id="decrease" class="form-control" name="decrease"
                                                        value="">
                                                    @if ($errors->any()) 
                                                        <p class="text-danger">{{ $errors->first('decrease') }}</p>       
                                                    @endif    
                                                </div>
                                                <label class="col-md-6 col-form-label"
                                                    for="decrease">@lang('translation.%decrease')</label>
                                            </div>
                                        </div>
                                    </div>
                            </div>          
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Repair_cost')</label>
                            <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <label class="col-md-6 col-form-label"
                                                    for="Durability_used">@lang('translation.Durability_used')</label>
                                                <div class="col-md-6">
                                                    <select class="form-select" name="durability_used" >
                                                        @for ($i = 0; $i < 100; $i++)
                                                            <option value='{{ $i }}'>{{ $i }}
                                                            </option>
                                                        @endfor
                                                        <select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <label class="col-md-12 col-form-label"
                                                    for="Direct_setting">@lang('translation.%Party')</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <!-- upgrade-setting -->
                            <input type="text" class="d-none" name="bmt_upgrade_setting">
                            <input type="text" class="d-none" name="level">
                            <input type="text" class="d-none" name="bst_upgrade_setting">
                            <input type="text" class="d-none" name="durability_upgrade_setting">
                            <input type="text" class="d-none" name="mining_upgrade_setting">
                   
                        <div class="mb-3 row">
                            <label for="select_glass" class="col-md-3 col-form-label">@lang('translation.glass')</label>
                            <div class="col-md-8">
                                <select class='form-select' name="glass" id="select_glass">
                                    <option value="">@lang('translation.Choose')</option> 
                                    @foreach($glass_category as $key => $glass)
                                        <option value="{{$glass}}">@lang('translation.'.$key)</option> 
                                    @endforeach
                                </select>
                                @if ($errors->any())        
                                <p class="text-danger">{{ $errors->first('glass')   }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">@lang('translation.Glasses_value')</label>
                            <div class="col-md-8">
                                <div class='row'>
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="@lang('translation.BST')"
                                            id="BST_input_glass" readonly >  
                                    </div>
                                    <input type="hidden" class="hidden" name="mining"> 
                                    <label class="col-md-4 col-form-label" for="on">@lang('translation.BST')</label>
                                </div>
                            </div>
                        </div>
                        <div class="float-end">
                                <a  href="{{route('admin.products.index')}}" class="btn btn-secondary waves-effect">
                                    @lang('translation.Back_page')
                                </a>
                                <button type="submit" class="btn btn-success inner">
                                    @lang('translation.registration')
                                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>    

        <div id="product_upgrade_setting"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container">
                            <div class="row justify-content-center">
                                <h5 class="modal-title text-center">@Lang('translation.Upgrade_Settings')</h5>
                            </div>
                        </div>
                        <a  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                    </div>
                    <div class="modal-body set-width-modal">
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Upgrade_Settings')</label>
                            <div class="col-md-10">
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="number" class="form-control" name="BMT" value="1" id="bmt_upgrade_settings" />
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <label class="form-check-label" for="customRadioInline2">:</label>
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="number" class="form-control" name="BST" value="5" id="bst_upgrade_settings" />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Upgrade_stat_settings')</label>
                            <div class="col-md-10">
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="number" name="durability_upgrade_setting_123"  step="any"  class="form-control" id="durability_upward_fixed" value="0.1" />
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <label class="form-check-label"  for="customRadioInline2">:</label>
                                </div>
                                <div class="custom-radio form-check form-check-inline">
                                    <input type="number" class="form-control"  step="any"  name="Mining_amount" value="0.12" id="Mining_amount_upward_fixed"  />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class='col-md-7 ms-4 mt-2'>
                                    <a class="btn btn-primary form-control btn-sm waves-effect waves-light ms-2" onclick="apply()">@lang('translation.Apply')</a>
                                </div>
                            </div>
                        </div>
                        <table id="product_upgrade" class="table table-bordered border-dark mb-0" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="2">@lang('translation.Level_classification')</th>
                                    <th colspan="2" class="text-center">@lang('translation.Upgrade_cost')</th>
                                    <th colspan="2" class="text-center">@lang('translation.Upgrade_stats')</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>BMT</th>
                                    <th>BST</th>
                                    <th>@lang('translation.Durability')</th>
                                    <th>@lang('translation.Mining_volume')</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_upgrade_settings">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a  class="btn btn-danger waves-effect cancelSetting"
                            data-bs-dismiss="modal">@lang('translation.Cancellation')</a>
                        <a  class="btn btn-success waves-effect waves-light set_upgrade_setting" data-bs-dismiss="modal">@lang('translation.Set')</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div id="product_enhancement_settings"class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="container">
                            <div class="row justify-content-center">
                                <h5 class="modal-title text-center">@lang('translation.Enhancement_Settings')</h5>
                            </div>
                        </div>
                        <a  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
                    </div>
                    <div class="modal-body set-width-modal">
                        <table class="table table-bordered border-dark mb-0" border="1">
                            <thead>
                                <tr>
                                    <th rowspan="2">@lang('translation.Reinforced_division')</th>
                                    <th class="text-center">@lang('translation.Fortification_cost')</th>
                                    <th colspan="2" class="text-center">@lang('translation.Reinforcement_stats')</th>
                                </tr>
                            </thead>
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>BST</th>
                                    <th>@lang('translation.Durability')</th>
                                    <th>@lang('translation.Mining_volume')</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_Enhancement_Settings">
                                @for($i = 2; $i< 31 ;$i++)
                                    <tr>
                                        <th scope="row">+{{$i}}<input type="hidden" value="{{$i}}" name="reinforced_division[]"/></th>
                                        <td><input type="number" name="bst_enhancement[]" step="any" class="form-control"></td>
                                        <td><input type="number" name="durability_enhancement[]" step="any" class="form-control"></td>
                                        <td><input type="number" name="mining_volume_enhancement[]" step="any" class="form-control"></td>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <a class="btn btn-danger waves-effect Cancellation_Enhancement_Settings"
                            data-bs-dismiss="modal">@lang('translation.Cancellation')</a>
                        <a class="btn btn-success waves-effect waves-light" data-bs-dismiss="modal">@lang('translation.Set')</a>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>
@endsection
@section('script')
    <!-- apexcharts -->
    <script>
        $(function() {
            $('input[name="repair_cost"]').on('change', function() {
                if (parseInt($(this).val()) === 1) {
                    $('select[name="durability_used"]').prop('disabled', false);
                    $('select[name="of_mining"]').prop('disabled', true);
                    $('#bst_input_number').prop('disabled', false);
                } else {
                    $('select[name="durability_used"]').prop('disabled', true);
                    $('select[name="of_mining"]').prop('disabled', false);
                    $('#bst_input_number').prop('disabled', true);
                }
            });
            $('.change-image').on('click', function() {
                $('#upload_file_input').trigger('click');
            })
            $('input#BST_input').on('keyup', function(){
                $('input#bst_input_number').val($(this).val())
            })
            $('input[name="image"]').on('change', function(){
                var image = $('.avatar-lg');
                if(isImage($(this).val())){
                image[0].src = URL.createObjectURL(this.files[0]);  
                $('#image_validation').addClass("d-none");
                }else{
                    this.files[0] =  this.files[0] ?  this.files[0] : null;
                    $('#image_validation').removeClass("d-none");
                }
            })
        })
        function apply(){
            html_table_product_upgrade();
        }

        bmt_upgrade_setting   = [];
        level_array = [];
        bst_upgrade_setting = [];
        durability_upgrade_setting = [];
        mining_upgrade_setting = [];
        var level =  1;
        function html_table_product_upgrade(cancel){
            if(cancel){
                level = 1;
                bmt_upgrade_setting   = [];
                level_array = [];
                bst_upgrade_setting = [];
                durability_upgrade_setting = [];
                mining_upgrade_setting = [];
                $('#tbody_upgrade_settings').html('');
                $('input[name="bmt_upgrade_setting"]').val('');
                $('input[name="level"]').val(level_array);
                $('input[name="bst_upgrade_setting"]').val('');
                $('input[name="durability_upgrade_setting"]').val('');
                $('input[name="mining_upgrade_setting"]').val('');
                return true;
            }
            level++;
            var bmt  = parseInt($('#bmt_upgrade_settings').val());
                bst = parseFloat($('#bst_upgrade_settings').val());
                divisor_bmt = bst / bmt;
                html_table = '';
                level_limit = parseInt('{{$level_limit_product_upgrade}}');
                durability = parseFloat($('#durability_upward_fixed').val());
                mining = parseFloat($('#Mining_amount_upward_fixed').val());
                    html_table += `<tr>
                                    <td>${level}</td>    
                                    <td>${bmt}</td>    
                                    <td>${bmt * divisor_bmt}</td>    
                                    <td>${durability}</td>    
                                    <td>${mining}</td>    
                                </tr>`
                $('#tbody_upgrade_settings').append(html_table);
                bmt_upgrade_setting.push(bmt);
                level_array.push(level);
                bst_upgrade_setting.push( bmt * divisor_bmt);
                durability_upgrade_setting.push(durability);
                mining_upgrade_setting.push(mining);              
                $('input[name="bmt_upgrade_setting"]').val(bmt_upgrade_setting);
                $('input[name="level"]').val(level_array);
                $('input[name="bst_upgrade_setting"]').val(bst_upgrade_setting);
                $('input[name="durability_upgrade_setting"]').val(durability_upgrade_setting);
                $('input[name="mining_upgrade_setting"]').val(mining_upgrade_setting);
        }
        $('.cancelSetting').on('click', function(){
            html_table_product_upgrade(1);
        })
        tbody_Enhancement_Settings_old = $('#tbody_Enhancement_Settings').html(); 
        $('.Cancellation_Enhancement_Settings').on('click', function(){
            $('#tbody_Enhancement_Settings').html(tbody_Enhancement_Settings_old);
        })

        function isImage(filename) {
            var ext = getExtension(filename);
            switch (ext.toLowerCase()) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'bmp':
            case 'ico':
                // etc
                return true;
            }
            return false;
        }
        function getExtension(filename) {
            var parts = filename.split('.');
            return parts[parts.length - 1];
        }


        $('select[name="glass"]').on('change', function() {
            var glass_category = {!! json_encode($glass_category) !!};
            var glass_type = {!! json_encode($glass_type) !!};
            var glass_category_value = $('select[name="glass"]').find(":selected").val();
            $.each(glass_category , function (k_type, v_type){  
                if(glass_category_value == v_type) {
                    $.each(glass_type , function (k_glass, v_glass){  
                        if(k_glass == k_type) {
                            $("#BST_input_glass").val(v_glass);
                            $('input[name="mining"]').val(v_glass);
                        }
                    })  
                }
            }); 
        })
    </script>
    <script src="{{ URL::asset('/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/pages/dashboard.init.js') }}"></script>
@endsection
