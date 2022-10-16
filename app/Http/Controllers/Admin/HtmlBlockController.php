<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\HtmlBlock;
use App\Models\Blog;
use App\Http\Requests\Admin\HtmlBlockStoreRequest;
use App\Http\Requests\Admin\HtmlBlockUpdateRequest;

class HtmlBlockController extends Controller
{
    public function store(HtmlBlockStoreRequest $request, Blog $blog)
    {
        DB::beginTransaction();
        try {
            $html_block = new HtmlBlock;
            $html_block->blog_id = $blog->id;
            $html_block->type = $request->type;
            $html_block->content = $request->content;
            $html_block->sort = $blog->html_blocks->count() + 1;
            $html_block->save();

            DB::commit();
            return response()->json([
                'message' => trans('success.html_block.store'),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Store html block exception', [
                'input' => $request->all(),
                'exception' => [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]
            ]);
            throw $e;
        }
    }

    public function update(HtmlBlockUpdateRequest $request)
    {
    }

    public function delete(HtmlBlock $block)
    {
        $block->delete();
        return response()->json([
            'message' => trans('success.provider.delete'),
        ], Response::HTTP_OK);
    }
}
