<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    public function all();
    public function store($article);
    public function find($id);
    public function update(array $data,$id);
    public function delete($id);

}
