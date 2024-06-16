<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewRequest;
use App\Services\NewService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function store(NewRequest $request)
    {
        $validatedData = $request->validated();
        $news = (new NewService)->store($validatedData);
        return $this->sendResponse($news);
    }

    public function update(NewRequest $request, $id = null)
    {
        $news = (new NewService)->update($request->all(), $id);
        return $this->sendResponse($news);
    }

    public function destroy($id)
    {
        $deleted = (new NewService)->delete($id);
        return $this->sendResponse($deleted);
    }

    public function showNews()
    {
        $newses = (new NewService)->showNews();
        return $this->sendResponse($newses);
    }

    public function showCategories()
    {
        $categories = (new NewService)->showCategories();
        return $this->sendResponse($categories);
    }

    public function showItem(Request $request, $slug)
    {
        $showItem = (new NewService())->showItem($request, $slug);
        return $this->sendResponse($showItem);
    }

    public function destroyCategory($id)
    {
        $deleted = (new NewService)->deleteCategory($id);
        return $this->sendResponse($deleted);
    }

    public function storeCategory(NewRequest $request)
    {
        $category = (new NewService)->storeCategory($request->all());
        return $this->sendResponse($category);
    }

    public function updateCategory(NewRequest $request, $id = null)
    {
        $category = (new NewService)->updateCategory($request->all(), $id);
        return $this->sendResponse($category);
    }
}
