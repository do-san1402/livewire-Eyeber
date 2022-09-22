<?php
namespace App\Http\Controllers\Web\advertisements;

use App\Models\WatchAdvertisementsLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MiningStatusController
{
    public function index()
    {
        return view('admin.advertisements.mining_status');
    }
    
    public function fetchData(Request $request)
    {
        $miningStatuses = WatchAdvertisementsLog::select('user_id',
        DB::raw('sum(cumulative_mining) as sum_cumulative_mining'))
        ->groupBy('user_id')->orderBy('sum_cumulative_mining', 'desc');
        return DataTables::of($miningStatuses)
            ->filter(function ($instance) use ($request) {
                $data = $request->all();
                if(!is_array($request->get('search'))){
                    $search = $request->get('search');
                        $instance->whereHas('user' ,function($q) use($search){
                            $q->where('nick_name', 'like', "%$search%");
                        });
                }
                if(isset($data['date_start'])  && $data['date_start'] && isset($data['date_end']) &&  $data['date_end']){
                    $instance->whereBetween('created_at', [$data['date_start'], $data['date_end']]);
                }
                $date  = isset($data['dates']) ? $data['dates']['date'] : 1; 
                if($date) {
                    $instance->whereBetween('created_at', [ Carbon::now()->subDay($date), Carbon::now() ] );
                }else {
                    $instance->whereBetween('created_at', [Carbon::now()->subDay($data['dates']['date']), Carbon::now()]);
                }

                if($request->limit){ 
                    $instance->limit((int)$request->limit);
                }
                $instance->get();
            })->addIndexColumn()
            ->addColumn('user_name', function (WatchAdvertisementsLog $watchAdvertisementsLog) {
               return  $watchAdvertisementsLog->user->nick_name;
            })->addColumn('sum_cumulative_mining', function (WatchAdvertisementsLog $watchAdvertisementsLog) {
                return   $watchAdvertisementsLog->sum_cumulative_mining;
            })->make(true);
    }
}