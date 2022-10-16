<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Models\Blog;
use App\Http\Requests\Admin\BlogStoreRequest;
use App\Http\Requests\Admin\BlogIndexRequest;
use App\Http\Resources\Admin\BlogResource;
use App\Http\Resources\Admin\BlogMinifiedResource;
use App\Http\Filters\AdminBlogFilter;

class BlogController extends Controller
{
    public function index(BlogIndexRequest $request, AdminBlogFilter $filter)
    {
        $per_page = $request->get('per_page', config('settings.paginate'));

        $blogs = Blog::with(['author', 'html_blocks'])
            ->filter($filter)
            ->paginate($per_page);

        return BlogMinifiedResource::collection($blogs);
    }

    public function show(Blog $blog)
    {
        return new BlogResource($blog);
    }

    public function store(BlogStoreRequest $request)
    {
        $user = Auth::user();
        DB::beginTransaction();
        try {
            $blog = new Blog;
            $blog->user_id = $user->id;
            $blog->title = $request->title;
            $blog->status = Blog::DRAFT_STT;
            $blog->slug = Str::slug($request->title);
            if(Blog::where('slug', $blog->slug)->exists()) {
                $blog->slug = Str::slug($request->title) . '-' . uniqid();
            }
            $blog->is_draft = true;
            $blog->save();

            DB::commit();
            return response()->json([
                'message' => trans('success.blog.store'),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Store blog exception', [
                'input' => $request->all(),
                'exception' => [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ]
            ]);
            throw $e;
        }
    }
}
