<?php

namespace App\Http\Controllers\Api\QA;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resource\PaginateResource;
use App\Http\Resource\QAResource;
use App\Models\QA;
use Illuminate\Http\Request;

class QAController extends BaseController
{
    const paginate_size = 4;

    public function index(Request $request)
    {
        $paginate_size =  $request->paginate_size ?? self::paginate_size;
        $qas = new QA();
        $qas = $qas->orderBy('created_at', 'desc');
        $qas = $qas->where('status', config('apps.common.ads_status.show'))->paginate($paginate_size);
        return $this->sendResponse(new PaginateResource($qas), 'Question and answer list success');
    }

    public function detail($id)
    {
        $qa = QA::findOrFail($id);
        return $this->sendResponse(new QAResource($qa), 'Question and answer Detail success');
    }
}