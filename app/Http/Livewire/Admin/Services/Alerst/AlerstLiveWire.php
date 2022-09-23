<?php

namespace App\Http\Livewire\Admin\Services\Alerst;

use Livewire\Component;
use App\Models\Alert;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AlerstLiveWire extends Component
{
    public $image_default;
    public function __construct()
    {
        $this->image_default = asset('assets/images/logo-sm.png');
    }

    public function index()
    {

        $alerts = Alert::all();
        $image_default = $this->image_default;
        return view('livewire.admin.services.alerts.index', compact(
            'alerts',
            'image_default'
        ));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();

            foreach ($data['alert_id'] as $key => $alert_id) {
                $alert = Alert::where('id', '=', $alert_id)
                    ->first();
                $new_image = '';
                $digits = 4;
                $code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                if (isset($request->file('image')[$key])) {
                    $rules = array(
                        'image' => 'mimes:jpeg,jpg,png,gif' 
                    );
                    $fileArray = array('image' => $request->file('image')[$key]);
                    $validator = Validator::make($fileArray, $rules);
                    if ($validator->fails()) {
                        throw new Exception('Image error.');
                    } else {
                        $get_image = $request->file('image')[$key];
                        $new_image          = 'alert_' . $code . '.' . $get_image->getClientOriginalExtension();
                        $get_image->storeAs('storage/images/alerts/', $new_image, 'real_public');
                    };
                }
                $alert->image = !empty($new_image) ? $new_image : '';
                $alert->link = $data["link"][$key];
                $date_start = new DateTime($data["date_start"][$key]);
                $date_end = new DateTime($data["date_end"][$key]);
                $today = new DateTime(date('Y-m-d'));
                if ($date_start > $today) {
                    return redirect()->back()->with('message', trans('translation.Please_enter_start_date_that_is_less_than_the_current_date'));
                }
                if ($date_start > $date_end) {
                    return redirect()->back()->with('message', trans('translation.Please_enter_start_date_that_is_less_than_the_end_date'));
                }
                $alert->date_start = $data["date_start"][$key];
                $alert->date_end = $data["date_end"][$key];
                $alert->status = $data["status"][$key];
                $alert->save();
            }
            DB::commit();
            return redirect()->back()->with('success', trans('translation.Your_work_has_been_saved'));
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }
    }
}
