<?php

namespace App\Http\Livewire\Admin\Services\Alerst;

use Livewire\Component;
use App\Models\Alert;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AlerstLiveWire extends Component
{
    public $image_default;
    public function __construct()
    {
     $this->image_default = asset('assets/images/logo-sm.png');
    }

    public function index()
    {
        $alert_one = Alert::find(1);
        $alert_two = Alert::find(2);
        $alert_three = Alert::find(3);
        $alert_four = Alert::find(4);
        $alert_five = Alert::find(5);
        $image_default = $this->image_default;
        return view('admin.services.alerts.index', compact('alert_one', 
                                                    'alert_two', 'alert_three',
                                                    'alert_four', 'alert_five', 'image_default'));
    }

    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();

            foreach($data['alert_id'] as $key => $alert_id){
                $alert = Alert::where('id', '=', $alert_id)
                ->first();
                $new_image = '';
                $digits = 4;
                $code = rand(pow(10, $digits-1), pow(10, $digits)-1);
                if (isset($request->file('image')[$key])) {
                    $get_image = $request->file('image')[$key];
                    $new_image          = 'alert_' . $code . '.' . $get_image->getClientOriginalExtension();
                    $get_image->storeAs('images/alerts/', $new_image);    
                }
                $alert->image = !empty($new_image) ? $new_image : $alert->image;
                $alert->link = $data["link"][$key];
                $date_start = new DateTime($data["date_start"][$key]);
                $date_end = new DateTime($data["date_end"][$key]);
                $today = new DateTime(date('Y-m-d'));
                if($date_start > $today){  
                    return redirect()->back()->with('message', trans('translation.Please_enter_start_date_that_is_less_than_the_current_date'));  
                }
                if($date_start > $date_end){
                    return redirect()->back()->with('message', trans('translation.Please_enter_start_date_that_is_less_than_the_end_date'));  
                }   
                $alert->date_start = $data["date_start"][$key];
                $alert->date_end = $data["date_end"][$key];
                $alert->status = $data["status"][$key];
                $alert->save();
               
            }
            DB::commit();
            return redirect()->back()->with('success', trans('translation.Your_work_has_been_saved')); 
        }catch(Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            return redirect()->back()->with('error', trans('translation.Something_went_wrong'));
        }    
    }
}
