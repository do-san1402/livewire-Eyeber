<?php

namespace App\Http\Controllers\Api\Notices;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\NoticeResouce;
use App\Http\Resource\PaginateResource;
use App\Models\Notice;
use Illuminate\Http\Request;


class NoticeController extends BaseController
{
    const paginate_size = 4;

    public function index(Request $request)
    {
        $paginate_size =  $request->paginate_size ?? self::paginate_size;
        $notices = new Notice();
        $notices = $notices->orderBy('created_at', 'desc');
        $notices = $notices->where('ad_status_id', config('apps.common.ads_status.show'))->paginate($paginate_size);

        return  $this->sendResponse(new PaginateResource($notices), 'Notice list success');
    }

    public function show($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->views = (int) $notice->views +1;
        $notice->save();
        return $this->sendResponse(new NoticeResouce($notice), 'Detail notice');
    }
}