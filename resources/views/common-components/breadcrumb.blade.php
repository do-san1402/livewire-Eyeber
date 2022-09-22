<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <div class="d-flex ">
                <h4 class="mb-0">{{$title }}</h4>
                @isset($subTitle)
                    <ol class="breadcrumb mx-3 sub-title">
                        <li class="breadcrumb-item remote-old"><a class="text-primary" href="javascript: void(0);" onclick="setting_date(1)">@lang('translation.Daily')</a></li>
                        <li class="breadcrumb-item remote-old"><a href="javascript: void(0);" onclick="setting_date(7)">@lang('translation.Weekly')</a></li>
                        <li class="breadcrumb-item remote-old"><a href="javascript: void(0);" onclick="setting_date(30)">@lang('translation.Monthly')</a></li>
                    </ol>
                @endisset
            </div>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ $pageTitle ??  $pagetitle }}</a></li>
                    @isset($MenuTitle)
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{$MenuTitle}}</a></li>
                    @endisset
                    @isset($ParentTitle)
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{$ParentTitle}}</a></li>
                    @endisset
                    @isset($childrenTitle)
                        <li class="breadcrumb-item"><a href="javascript: void(0);">{{$childrenTitle}}</a></li>
                    @endisset
                    <li class="breadcrumb-item active">{{ $Title ?? $title }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->