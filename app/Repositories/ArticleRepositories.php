<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class ArticleRepositories implements ArticleRepositoryInterface
{
    public function all()
    {
        try {
            return Article::with('user')->get();
        } catch (Exception $e) {
            throw new Exception('Error while displaying  user in repository : ' . $e->getMessage());
        }
    }


    public function store($article)
    {
        try {
            DB::beginTransaction();
            $article = Article::create($article);
            DB::commit();
            return $article;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error in repository while storing article : ' . $e->getMessage());
        }
    }

    public function find($id)
    {
        try {
            return Article::findOrFail($id);
        } catch (Exception $e) {
            throw new Exception('Error in repository while finding article : ' . $e->getMessage());
        }
    }
    public function update(array $data, $id)
    {
        try {
            DB::beginTransaction();
            $article = $this->find($id);
            if (!$article) {
                throw new Exception('Article not found');
            }
            if (isset($data['title'])) {
                $article->title = $data['title'];
            }
            if (isset($data['description'])) {
                $article->description = $data['description'];
            }
            if (isset($data['image'])) {
                $article->image = $data['image'];
            }
            $article->save();
            DB::commit();
            return $article;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error in repository while updating Article: ' . $e->getMessage());
        }
    }



    public function delete($id): void
    {
        try {
            DB::beginTransaction();
            $article= $this->find($id);
            if ($article->image) {
                unlink("storage/".$article->image);
            }
            $article->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception('Error in repository while deleting article : ' . $e->getMessage());
        }
    }
}
