<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\BannerModel;
use App\Models\Api\V1\Ecommerce\CategoryPostModel;
use App\Models\Api\V1\Ecommerce\PostModel;
use App\Models\Api\V1\Ecommerce\PostTypeModel;
use App\Models\Api\V1\Ecommerce\TagModel;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Str;

class PostController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new PostModel();
        parent::__construct($request);
    }
    public function index(Request $request,$post_type = null)
    {
        try {
            if($post_type){
                $this->_params['post_type'] = $post_type;
            }
            $result = $this->table->listItem([...$this->_params], ['task' => 'list']);
            if (!$result) return $this->error('Thông tin không hợp lệ');
            return $this->successResponsePagination('Lấy danh sách sản phẩm thành công!', $result->items(), $result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
    public function post_sidebar($post_type)
    {
        try {
            $post_type_id = PostTypeModel::where(['name' => strtoupper($post_type)])->pluck('id')->first();
            $data['categories'] = CategoryPostModel::with('post_type')->where('post_type_id', $post_type_id)->get();
            $data['tags'] = TagModel::select('ecommerce_tags.*')
                ->distinct()
                ->leftJoin('ecommerce_post_tag_relations as tp', 'tp.tag_id', '=', 'ecommerce_tags.id')
                ->leftJoin('ecommerce_posts as p', 'p.id', '=', 'tp.post_id')
                ->leftJoin('ecommerce_categories_posts as c', 'c.id', '=', 'p.category_post_id')
                ->leftJoin('ecommerce_post_types', 'ecommerce_post_types.id', '=', 'c.post_type_id')
                ->where('ecommerce_post_types.name', strtoupper($post_type))->get();

            $data['banners'] = BannerModel::where(['placement' => strtolower($post_type)])->limit(20)->get();


            return $this->successResponse('success', $data);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
     public function getPostFilter(Request $request)
    {
        try {
            $posts = PostModel::query()->with('author', 'category.post_type', 'post_tags');

            // Apply filters
            if (!empty($request->post_type)) {
                $type_id = PostTypeModel::where('name', $request->post_type)->pluck('id')->first();
                $categories_ids = CategoryPostModel::where('post_type_id', $type_id)->pluck('id')->all();
                $posts->whereIn('category_post_id', $categories_ids);
            }

            $posts->when($request->is_show, function ($query) use ($request) {
                $query->where('is_show', $request->is_show);
            });

            $posts->when($request->is_published, function ($query) use ($request) {
                $query->where('is_published', $request->is_published);
            });

            $posts->when($request->author_id, function ($query) use ($request) {
                $query->where('author_id', $request->author_id);
            });

            $posts->when($request->start_date, function ($query) use ($request) {
                $query->whereDate('published_at', '>=', $request->start_date);
            });

            $posts->when($request->end_date, function ($query) use ($request) {
                $query->whereDate('published_at', '<=', $request->end_date);
            });

            $posts->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });

            $posts->when($request->archive, function ($query) use ($request) {
                $query->where('archive', $request->archive);
            });

            $posts->when($request->min_views, function ($query) use ($request) {
                $query->where('view', '>=', $request->min_views);
            });

            // Fetch the posts with pagination
            //
            $posts = $posts->orderBy('created_at', 'desc')->paginate($request->get('limit', 10)); // Default limit 10 if not provided

            return $this->successResponsePagination('success', $posts->items(), $posts);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function createCategoryPost(Request $req)
    {
        try {
            $validator = Validator::make($req->all(), [
                'name' => 'required|string|max:255',
                'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:1024',
                'post_type_id' => 'required',
                'description' => 'max:255',
            ]);

            // return $req->post_type_id;

            if ($validator->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors(), 400);
            }
            // ang ang
            $slug = Str::slug($req->input('name'));

            // $counter = 1;
            // $newSlug = $slug;

            // while (PostModel::where('slug', $newSlug)->exists()) {
            //     $newSlug = $slug . '-' . $counter;
            //     $counter++;
            // }


            $type_from = "";
            switch ($req->post_type_id) {
                case 1:
                    $type_from = "blog";
                    break;
                case 2:
                    $type_from = "edu";
                    break;
                case 3:
                    $type_from = "qa";
                    break;
            }

            if ($req->hasFile('icon')) {
                $file = $req->file('icon');
                $fileService = new FileService();
                $imagePath = $fileService->uploadFile($file, $type_from, auth('ecommerce')->user()->id); // Adjusted to use `$type` for dynamic folder naming
            }

            $isShow = filter_var($req->is_show, FILTER_VALIDATE_BOOLEAN);
            $newCategory = CategoryPostModel::create([
                'name' => $req->name,
                'slug' => $slug,
                'icon' => $imagePath['url'],
                'is_show' => $isShow,
                'post_type_id' => $req->post_type_id,
                'description' => $req->description,
                'parent_id' => 1, //assuming parent id is 1
            ]);

            return $this->successResponse('success!', $newCategory);
        } catch (\Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }

    public function createPost(Request $req)
    {
        // return now();
        try {
            // Validate incoming request data
            $validator = Validator::make($req->all(), [
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'hashtag' => 'required|string',
                'category_post' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors(), 400);
            }

            // Generate slug from title
            $slug = Str::slug($req->input('title'));

            $counter = 1;
            $newSlug = $slug;

            while (PostModel::where('slug', $newSlug)->exists()) {
                $newSlug = $slug . '-' . $counter;
                $counter++;
            }

            $slug = $newSlug;

            $isShow = filter_var($req->is_show, FILTER_VALIDATE_BOOLEAN);
            // Handle file upload if thumbnail is provided
            if ($req->hasFile('thumbnail')) {
                $file = $req->file('thumbnail');
                $fileService = new FileService();
                $imagePath = $fileService->uploadFile($file, "blog", auth('ecommerce')->user()->id);

                if (!isset($imagePath['url'])) {
                    return $this->errorResponse('Failed to upload thumbnail.', null, 500);
                }
            } else {
                return $this->errorResponse('Thumbnail is required.', null, 400);
            }

            // Create new post with flexible post_type
            $newPost = PostModel::create([
                'thumbnail' => $imagePath['url'],
                'title' => $req->title,
                'content' => $req->input('content'),
                'is_show' => $isShow,
                'slug' => $slug,
                'author_id' => auth('ecommerce')->user()->id,
                'category_post_id' => $req->category_post,
            ]);

            // Process hashtagModel: split by commas, trim whitespace
            $hashtags = array_map('trim', explode(',', $req->hashtag));
            // return $hashtags;
            foreach ($hashtags as $tag) {
                // Check if the hashtag already exists
                $hashtag = TagModel::firstOrCreate(['tag_name' => strtolower($tag)]);
                $newPost->tags()->attach($hashtag->id, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            $newPost->tags;
            return $this->successResponse('Post created successfully!', $newPost);
        } catch (\Exception $e) {
            return $this->errorResponse('Đã xảy ra lỗi! Vui lòng thử lại sau.', $e->getMessage(), 500);
        }
    }
     public function deleteEntityById($type, $id)
    {
        try {
            $model = null;
            switch ($type) {
                case 'post':
                    $model = PostModel::find($id);
                    break;
                case 'category':
                    $model = CategoryPostModel::find($id);
                    break;
                default:
                    return $this->errorResponse("Invalid entity type: must be 'post' or 'category'.", null, 400);
            }

            if (!$model) {
                return $this->errorResponse('Entity not found.', null, 404);
            }

            $model->delete();

            return $this->successResponse('Entity deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while attempting to delete the entity.', $e->getMessage(), 500);
        }
    }
     public function recoverEntityById($type, $id)
    {
        try {
            $model = null;

            // Determine the model based on the entity type
            switch ($type) {
                case 'post':
                    $model = PostModel::withTrashed()->find($id); // Get the soft-deleted post as well
                    // return $model;
                    break;
                case 'category':
                    $model = CategoryPostModel::withTrashed()->find($id); // Get the soft-deleted category as well
                    break;
                default:
                    return $this->errorResponse("Invalid entity type: must be 'post' or 'category'.", null, 400);
            }

            // If model is not found
            if (!$model) {
                return $this->errorResponse('Entity not found or not soft-deleted.', null, 404);
            }

            if (!$model->trashed()) {
                return $this->successResponse('Entity is already active and not deleted.', null, 200);
            }

            // Restore the soft-deleted entity
            $model->restore();

            return $this->successResponse('Entity recovered successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while attempting to recover the entity.', $e->getMessage(), 500);
        }
    }
    public function editPostById(Request $req, $id)
    {
        // return $id;
        try {
            // Find the post by ID
            $post = PostModel::find($id);
            // return $post;
            if (!$post) {
                return $this->errorResponse('Post not found.', null, 404);
            }

            // Validate input data
            $validator = Validator::make($req->all(), [
                'title' => 'sometimes|string|max:255',
                'content' => 'sometimes|string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed.', $validator->errors(), 400);
            }

            // Update post fields only if provided
            if ($req->input('title')) {
                $post->title = $req->title;
                $slug = Str::slug($req->input('title'));
                $post->slug = $slug;
            }

            if ($req->input('content')) {
                $post->content = $req->input('content');
            }

            // Handle file upload for thumbnail
            if ($req->hasFile('thumbnail')) {
                $file = $req->file('thumbnail');
                $fileService = new FileService();
                $thumbnailPath = $fileService->uploadFile($file, "posts", $post->id);  // Assuming uploadFile method returns the correct path
                $post->thumbnail = $thumbnailPath['url'];  // Assuming the URL key is returned
            }
            $post->is_show = $req->is_show ==1 ?true :false;

            if ($req->input('category_post')) {
                $post->category_post_id = $req->category_post;
            }

            if ($req->input('hashtag')) {
                // Process hashtagModel: split by commas, trim whitespace
                $hashtags = array_map('trim', explode(',', $req->hashtag));
                // return $hashtags;

                // Get all the current tags associated with the post
                $currentHashtags = $post->tags->pluck('tag_name')->toArray(); // Get current tag names

                // return $currentHashtags;
                // Determine which tags need to be removed
                $hashtagsToRemove = array_diff($currentHashtags, $hashtags); // Find tags that are no longer in the request
                $tagsToAdd = array_diff($hashtags, $currentHashtags); // Find tags that are new
                // return $hashtagsToRemove;
                // return $tagsToAdd;


                // Remove hashtags that were deleted
                foreach ($hashtagsToRemove as $tagName) {
                    $tag = TagModel::where('tag_name', strtolower($tagName))->first();

                    // return $tag;

                    if ($tag) {
                        $post->tags()->detach($tag->id);  // Detach the removed tag from the post
                    }
                }

                foreach ($tagsToAdd as $tag) {
                    // Check if the hashtag already exists
                    $hashtag = TagModel::firstOrCreate(['tag_name' => strtolower($tag)]);

                    // Check if the tag is already attached to the post
                    if (!$post->tags()->where('tag_id', $hashtag->id)->exists()) {
                        // If the tag is not already attached, then attach it
                        $post->tags()->attach($hashtag->id, [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
                $post->tags;
            }
            // Save the updated post
            $post->save();

            return $this->successResponse('Post updated successfully.', ['updatedPost' => $post]);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while attempting to edit the post.', $e->getMessage(), 500);
        }
    }
     public function editCategoryPostById(Request $req, $id)
    {
        try {
            // Find the category post by ID and type
            $categoryPost = CategoryPostModel::find($id);
            // return $categoryPost;
            // Check if the category post exists and matches the type
            if (!$categoryPost) {
                return $this->errorResponse('Category post not found or type mismatch.', null, 404);
            }

            // Validate input data
            $validator = Validator::make($req->all(), [
                'name' => 'sometimes|string|max:255',
                'icon' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:1024', // Use 'nullable' for file to avoid validation when it's absent
                // 'is_show' => 'sometimes|boolean|nullable', // Use 'nullable' for boolean to avoid validation when it's absent
                'description' => 'sometimes|string|nullable',
                'parent_id' => 'nullable|integer|exists:categories_posts,id', // Use 'nullable' to ensure it's optional
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Validation failed.', $validator->errors(), 400);
            }

            // Update fields only if they are provided in the request
            if ($req->has('name')) {
                $slug = Str::slug($req->name);
                $categoryPost->name = $req->name;
                $categoryPost->slug = $slug;
            }

            if ($req->has('slug')) {
                $categoryPost->slug = $req->slug;
            }


            if ($req->hasFile('icon')) {
                // Handle file upload for the icon
                $file = $req->file('icon');
                $fileService = new FileService();
                $imagePath = $fileService->uploadFile($file, "category_icons", auth('ecommerce')->user()->id);  // Adjust as needed
                $categoryPost->icon = $imagePath['url'];  // Assuming the 'url' key is returned
            }

            if ($req->has('is_show')) {
                // return $req->is_show;
                $isShow = filter_var($req->is_show, FILTER_VALIDATE_BOOLEAN);
                // return $isShow;
                $categoryPost->is_show = $isShow;
            }

            if ($req->has('description')) {
                $categoryPost->description = $req->description;
            }

            if ($req->has('parent_id')) {
                $categoryPost->parent_id = $req->parent_id;
            }

            // Save the updated category post
            $categoryPost->save();

            return $this->successResponse('Category post updated successfully.', ['updatedCategoryPost' => $categoryPost]);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while attempting to edit the category post.', $e->getMessage(), 500);
        }
    }
     public function getPostBySlug($slug)
    {
        try {
            if (!$slug) {
                return $this->errorResponse('Thiếu slug');
            }
            $post           = PostModel::where('slug', $slug)->with('category', 'author', 'post_tags.tag')->first();
            if (!$post) {
                return $this->errorResponse('Bài viết không tồn tại');
            }
            $type_id        = PostTypeModel::where('name', 'BLOG')->pluck('id')->first();
            $categories_ids = CategoryPostModel::where('post_type_id', $type_id)->pluck('id')->all();

            $sameAuthor     = PostModel::where('author_id', $post->author_id)
                            ->whereIn('category_post_id', $categories_ids)
                            ->whereNotIn('id', [$post->id])->orderByDesc('created_at')->limit(10)->get();
            return $this->successResponse('success', ['post' => $post, 'same_author_posts' => $sameAuthor]);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while attempting to edit the category post.', $e->getMessage(), 500);
        }
    }
     public function getPostCategory(Request $request)
    {
        try {
            $query = CategoryPostModel::with('post_type');
            if (!empty($request->type)) {
                $type = PostTypeModel::where('slug', $request->type)->first();
                if ($type) {
                    $query->where('post_type_id', $type->id);
                }
            }
            $data = $query->get();
            return $this->successResponse('success', $data);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while attempting to edit the category post.', $e->getMessage(), 500);
        }
    }
     public function my_post(Request $request)
    {
        try {
            $posts = PostModel::where('author_id', auth('ecommerce')->id())->with('author', 'category.post_type', 'post_tags.tag');

            // Apply filters
            if (!empty($request->post_type)) {
                $type_id = PostTypeModel::where('name', $request->post_type)->pluck('id')->first();
                $categories_ids = CategoryPostModel::where('post_type_id', $type_id)->pluck('id')->all();
                $posts->whereIn('category_post_id', $categories_ids);
            }

            $posts->when($request->is_show, function ($query) use ($request) {
                $query->where('is_show', $request->is_show);
            });

            $posts->when($request->is_published, function ($query) use ($request) {
                $query->where('is_published', $request->is_published);
            });

            $posts->when($request->author_id, function ($query) use ($request) {
                $query->where('author_id', $request->author_id);
            });

            $posts->when($request->start_date, function ($query) use ($request) {
                $query->whereDate('published_at', '>=', $request->start_date);
            });

            $posts->when($request->end_date, function ($query) use ($request) {
                $query->whereDate('published_at', '<=', $request->end_date);
            });

            $posts->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });

            $posts->when($request->archive, function ($query) use ($request) {
                $query->where('archive', $request->archive);
            });

            $posts->when($request->min_views, function ($query) use ($request) {
                $query->where('view', '>=', $request->min_views);
            });
            if($request->sort){
                $posts->orderBy('created_at',$request->sort);
            }else{
                $posts->orderBy('created_at', 'desc');
            }
            // Fetch the posts with pagination

            $posts = $posts->paginate($request->get('limit', 10));

            return $this->successResponsePagination('success', $posts->items(), $posts);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while attempting to edit the category post.', $e->getMessage(), 500);
        }
    }
     public function getPostByIDPostShop($id)
    {
        try {
            if (!$id) {
                return $this->errorResponse('Thiếu id');
            }
            $post = PostModel::where(['id' => $id, 'author_id' => auth('ecommerce')->id()])->with('category', 'tags')->first();
            if (!$post) {
                return $this->errorResponse('Bài viết không tồn tại');
            }

            return $this->successResponse('success', $post);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while attempting to edit the category post.', $e->getMessage(), 500);
        }
    }
}
