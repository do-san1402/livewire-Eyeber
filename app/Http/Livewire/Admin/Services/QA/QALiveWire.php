<?php

namespace App\Http\Livewire\Admin\Services\QA;

use Livewire\Component;
use App\Models\QA;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QALiveWire extends Component
{
    public function index()
    {
        $ads_stautus  = config('apps.common.ads_status');
        return view('livewire.admin.services.QA.index', compact('ads_stautus'));
    }

    public function fetchData(Request $request)
    {
        $qas = QA::query();
        return datatables()::of($qas)
            ->filter(function ($instance) use ($request) {
                $data = $request->all();
                if (isset($data["list_post_status"]) &&  count($data["list_post_status"])) {
                    $instance->whereIn('status', $data["list_post_status"]);
                }


                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->Where('name', 'LIKE', "%$search%");
                    });
                }
                $instance->get();
            })->addColumn('status_name', function (QA $qa) {
                if($qa->status === config('apps.common.ads_status.hide')){
                    return trans('translation.hide');
                }else{
                    return trans('translation.show');
                }
            })->addColumn('checkbox', function ($item) {
                return '<input role="button" type="checkbox" class="single_checkbox" value="' . $item->id . '" name="qa_id[]" />';
            })->addColumn('action', function ($item) {
                return '<a href="' . route('admin.services.qa.edit', $item->id) . '" class="btn btn-outline-secondary btn-sm edit">
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
            if (isset($data['qas']) && count($data['qas'])) {
                QA::whereIn('id', $data['qas'])
                ->update(['status' => $data['status']]);
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

            if (isset($data['qas']) && count($data['qas'])) {
                QA::whereIn('id', $data['qas'])->delete();
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

    public function register()
    {
        return view('livewire.admin.services.QA.register');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string',
                'description' => 'required'
            ],
        );
        try {
            $qa = new QA();
            $qa->name = $request->name;
            $qa->description = $request->description;
            $qa->registration_date = date("Y/m/d");
            $qa->status = config('apps.common.ads_status.show');
            $qa->save();
            return redirect()->route('admin.services.qa.index')->with('success', trans('translation.Your_work_has_been_saved'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
    }

    public function edit($id)
    {
        $qa  = QA::findOrFail($id);

        $ads_stautus  = config('apps.common.ads_status');
        foreach($ads_stautus as $key => $ad_stautus){
            if($qa->status === $ad_stautus){
                $qa->status_name = $key;
                break;
            }
        }
        return view('livewire.admin.services.QA.edit', compact('qa', 'ads_stautus'));
    }
    
    public function update($id,Request $request)
    {

        $request->validate(
            [
                'name' => 'required|string',
                'description' => 'required',
            ],
        );
        try {
            $qa =  QA::findOrFail($id);
            $qa->name = $request->name;
            $qa->description = $request->description;
            $qa->status = $request->status;
            $qa->save();
            return redirect()->back()->with('success', trans('translation.Your_work_has_been_saved'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
    }
}
