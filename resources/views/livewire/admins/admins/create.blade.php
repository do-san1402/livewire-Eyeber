@extends('layouts.master')
@section('title')
    @lang('translation.Admin_Registration')
@endsection
@section('content')
    @component('common-components.breadcrumb')
         @slot('pageTitle')
            @lang('translation.Home')
        @endslot
        @slot('MenuTitle')
            @lang('translation.Admin_Menu')
        @endslot
          @slot('ParentTitle')
            @lang('translation.Admin_Manager')
        @endslot
        @slot('childrenTitle')
            @lang('translation.Admin_List')
        @endslot
        @slot('title')
            @lang('translation.Admin_Registration')
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation"  action="{{ route('admin.admins.store') }}" method="POST">
                        @csrf
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Email')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="email" 
                                    placeholder="@lang('translation.Email')" value="{{old('enail')}}" name="email"/>
                                @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.id')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" 
                                    placeholder="@lang('translation.id')" value="{{old('nick_name')}}" name="nick_name"  />
                                @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('nick_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Contract')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="number"  value="{{old('number_phone')}}"
                                    placeholder="@lang('translation.Contract')" name="number_phone" />
                                @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('number_phone') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Full_Name')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" value="{{old('full_name')}}"
                                    placeholder="@lang('translation.Full_Name')" name="full_name" />
                                @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('full_name') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">@lang('translation.Rank')</label>
                            <div class="col-md-4">
                                <select class="form-select" name="rank_id" >
                                    <option value="">@lang('translation.Rank')</option>
                                    @foreach ($ranks as $rank)
                                        <option value="{{ $rank->id }}">{{ $rank->name }}</option>
                                    @endforeach
                                </select>
                                 @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('rank_id') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="example-text-input" class="col-md-2 col-form-label">@lang('translation.Password')</label>
                            <div class="col-md-4">
                                <input class="form-control" type="password" 
                                    placeholder="@lang('translation.Password')" value="{{old('password')}}" name="password"  />
                                @if ($errors->any())
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('admin.admins.index') }}" class="btn btn-info waves-effect waves-light">@lang('translation.Back_page')</a>
                                <button type="submit"
                                    class="btn btn-primary  waves-effect waves-light ms-2 create_admin">@lang('translation.Registration')</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('/assets/libs/parsleyjs/parsleyjs.min.js') }}"></script>

@endsection