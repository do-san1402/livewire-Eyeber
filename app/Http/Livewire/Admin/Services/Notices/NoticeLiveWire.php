<?php

namespace App\Http\Livewire\Admin\Services\Notices;

use Livewire\Component;
use App\Http\Requests\NoticeRequest;
use App\Models\Notice;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class NoticeLiveWire extends Component
{
    public function index()
    {
        $ads_stautus  = config('apps.common.ads_status');
        return view('admin.services.notices.index', compact('ads_stautus'));
    }

    public function fetchData(Request $request)
    {
        $users = Notice::query();
        return Datatables::of($users)
            ->filter(function ($instance) use ($request) {
                $data = $request->all();

                if (isset($data["list_post_status"]) &&  count($data["list_post_status"])) {
                    $instance->whereIn('ad_status_id', $data["list_post_status"]);
                }


                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->Where('title', 'LIKE', "%$search%");
                    });
                }
                $instance->get();
            })->addColumn('ad_status_name', function (Notice $notice) {
                if($notice->ad_status_id === config('apps.common.ads_status.hide')){
                    return trans('translation.hide');
                }else{
                    return trans('translation.show');
                }
            })->editColumn('views', function (Notice $notice) {
                return number_format($notice->views);

            })->addColumn('checkbox', function ($item) {
                return '<input role="button" type="checkbox" class="single_checkbox" value="' . $item->id . '" name="notice_id[]" />';
            })->addColumn('action', function ($item) {
                return '<a href="' . route('admin.services.notices.edit', $item->id) . '" class="btn btn-outline-secondary btn-sm edit">
                            <i class="fas fa-pencil-alt"></i>
                        </a>';
            })->make(true);
    }

    public function changeStatus(Request $request)
    {
        try {
            $response = [
                'status' =>  config('apps.common.status.success'),
                'message' =>  trans('translation.Success')
            ];
            $data = $request->all();
            if (isset($data['notices']) && count($data['notices'])) {
                Notice::whereIn('id', $data['notices'])
                ->update(['ad_status_id' => $data['status']]);
            }
            return  response()->json($response);
        } catch (Exception $e) {
            $response = [
                'status' => config('apps.common.status.fail'),
                'message' => config('apps.common.Fail'),
            ];
            Log::error($e->getMessage());
            return  response()->json($response);
        }
    }

    public function delete(Request $request)
    {
        try {
            $response = [
                'status' => config('apps.common.status.success'),
                'message' => trans('translation.Success'),
            ];
            $data = $request->all();

            if (isset($data['notices']) && count($data['notices'])) {
                Notice::whereIn('id', $data['notices'])->delete();
            }
            return  response()->json($response);
        } catch (Exception $e) {
            $response = [
                'status' => config('apps.common.status.fail'),
                'message' => trans('translation.Fail'),
            ];
            Log::error($e->getMessage());

            return  response()->json($response);
        }
    }

    public function create()
    {
        return view('admin.services.notices.register');
    }

    public function store(NoticeRequest $request)
    {
        try {
            $notice = new Notice();
            $notice->title = $request->title;
            $notice->content = $request->content;
            $notice->views = 0;//new register => views = 0
            $notice->registration_date = date("Y/m/d");
            $notice->ad_status_id = config('apps.common.ads_status.show');
            $notice->save();
            $id = Notice::orderBy('id', 'desc')->first()->id;
            return redirect()->route('admin.services.notices.index')->with('success', trans('translation.Your_work_has_been_saved'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
    }

    public function edit($id)
    {

        $notice  = Notice::findOrFail($id);

        $ads_stautus  = config('apps.common.ads_status');
        foreach($ads_stautus as $key => $ad_stautus){
            if($notice->ad_status_id === $ad_stautus){
                $notice->status = $key;
                break;
            }
        }
        return view('admin.services.notices.edit', compact('notice', 'ads_stautus'));
    }

    public function update(Request $request,$id)
    {
        try {
            $notice =  Notice::findOrFail($id);
            $notice->title = $request->title;
            $notice->content = $request->content;
            $notice->ad_status_id = $request->status;
            $notice->save();
            return redirect()->back()->with('success', trans('translation.Your_work_has_been_saved'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
    }
    
    public function upload_video(Request $request)
    {
        if ($request->hasFile('upload')) {
            $get_image = $request->file('upload');
            $new_image          = 'prodcut_' . time() . '.' . $get_image->getClientOriginalExtension();
            $get_image->storeAs('images/products/', $new_image);    
        }
        $url = url('/storage/images/products/' . $new_image);
        return response()->json(['filename'=>$new_image, 'uploaded' =>1, 'url' =>$url]);
    }
}
