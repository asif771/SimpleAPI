<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    use ImageTrait;
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    public function index()
    {
        try {
            $article = $this->articleRepository->all();
            return new ArticleCollection($article);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to Display Article',$e->getMessage()], 500);
        }    }

    public function store(StoreArticleRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $user = User::latest()->first();
            $validated['createdBy']=$user->id;
            $validated['image'] = $this->uploadImage($request, 'image', 'ArticleImages');
            $article = $this->articleRepository->store($validated);
            $articleCollection = new ArticleResource($article);
            return response()->json(['message' => 'Article Stored Successfully', 'data' => $articleCollection,
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to Store Article', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $articleId): ArticleResource|JsonResponse
    {
        try {
            $article=Article::find($articleId);
            if (!$article) {
                return response()->json(['message' => 'Article Not Found'], 404);
            }
            $article= new ArticleResource($article);
            return response()->json(['message' => 'Article Found Successfully','data'=>$article]);

        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to Retrieve Article', 'error' => $e->getMessage()], 500);
        }
    }
    public function update(UpdateArticleRequest $request,$articleId): JsonResponse
    {
        try {
            $validated = $request->validated();
            $article = $this->articleRepository->find($articleId);
            if ($request->hasFile('image'))
            {
                $oldLogoPath = $article->image;
                if ($oldLogoPath) {
                    $this->deleteImage($oldLogoPath);
                }
                $imagePath = $this->uploadImage($request, 'image', 'ArticleImages');
                $validated['image'] = $imagePath;
            }
            $articleResource = $this->articleRepository->update($validated,$articleId);
            return response()->json(['message'=>'Article Updated Successfully','data'=>$articleResource]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to Update Article', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($articleId): JsonResponse
    {
        try {
            $this->articleRepository->delete($articleId);
            return response()->json(['message' => 'Article Deleted Successfully']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to Delete Article', 'error' => $e->getMessage()], 500);
        }
    }
    public function search($name)
    {
        $article=Article::where('title','like','%'.$name.'%')->get();
        if(count($article)){
            return $article;
        } else {
            return array('Result', 'No records found');
        }
    }
}
