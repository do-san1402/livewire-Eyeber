<?php

namespace App\Http\Livewire\Admin\Services\Banners;

use Livewire\Component;
use App\Models\Banner;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BannersLiveWire extends Component
{
    public $image_default;
    public function __construct()
    {
     $this->image_default = asset('assets/images/logo-sm.png');
    }

    public function index()
    {
        $banner_one = Banner::find(1);
        $banner_two = Banner::find(2);
        $banner_three = Banner::find(3);
        $banner_four = Banner::find(4);
        $banner_five = Banner::find(5);
        $image_default = $this->image_default;
        return view('admin.services.banners.index', compact('banner_one', 
                                                    'banner_two', 'banner_three',
                                                    'banner_four', 'banner_five', 'image_default'));
    }

    public function update(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();

            foreach($data['banner_id'] as $key => $banner_id){
                $banner = Banner::where('id', '=', $banner_id)
                ->first();
                $new_image = '';
                $digits = 4;
                $code = rand(pow(10, $digits-1), pow(10, $digits)-1);
                if (isset($request->file('image')[$key])) {
                    $get_image = $request->file('image')[$key];
                    $new_image          = 'banner_' . $code . '.' . $get_image->getClientOriginalExtension();
                    $get_image->storeAs('images/banners/', $new_image);    
                }
                $banner->image = !empty($new_image) ? $new_image : $banner->image;
                $banner->link = $data["link"][$key];
                $date_start = new DateTime($data["date_start"][$key]);
                $date_end = new DateTime($data["date_end"][$key]);
                $today = new DateTime(date('Y-m-d'));
                if($date_start > $today){  
                    return redirect()->back()->with('message', trans('translation.Please_enter_start_date_that_is_less_than_the_current_date'));  
                }
                if($date_start > $date_end){
                    return redirect()->back()->with('message', trans('translation.Please_enter_start_date_that_is_less_than_the_end_date'));  
                }   
                $banner->date_start = $data["date_start"][$key];
                $banner->date_end = $data["date_end"][$key];
                $banner->status = $data["status"][$key];
                $banner->save();
              
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
