<?php

namespace App\Services;

use App\Models\NewCategories;
use App\Models\News;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use App\Services\TranslationService;

class NewService
{

    public function showItem($request, $slug)
    {
        $localeLang = $request->query('lang', 'en');

        App::setLocale($localeLang);

        $item = News::where('slug', $slug)->with('categories')->firstOrFail();

        $translationService = new TranslationService();

        $item->title = $translationService->translate($item->title, $localeLang);
        $item->text = $translationService->translate($item->text, $localeLang);

        return $item;
    }


    public function update($data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            $update = News::findOrFail($id);
            $oldThumbnail = $update->thumbnail;

            if (request()->hasFile('thumbnail')) {
                $thumbnail = request()->file('thumbnail');
                $thumbnailPath = $thumbnail->store('public/news_medias');
                $data['thumbnail'] = str_replace('public/', 'storage/', $thumbnailPath);
                $url = url($data['thumbnail']);
            } elseif (isset($data['thumbnail']) && is_string($data['thumbnail']) && filter_var($data['thumbnail'], FILTER_VALIDATE_URL)) {
                $url = $data['thumbnail'];
            }

            $updateData = [
                'category_id' => $data['category_id'],
                'title' => $data['title'],
                'text' => $data['text'],
                'store_date' => now(),
            ];

            if (isset($url)) {
                $updateData['thumbnail'] = $url;
            }

            $update->update($updateData);

            if (isset($url) && $oldThumbnail) {
                $oldThumbnailPath = str_replace('storage/', 'public/', $oldThumbnail);
                Storage::delete($oldThumbnailPath);
            }

            return $update;
        });
    }


    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            $url = null;
            if (request()->hasFile('thumbnail')) {
                $thumbnail = request()->file('thumbnail');
                $thumbnailPath = $thumbnail->store('public/news_medias');
                $data['thumbnail'] = str_replace('public/', 'storage/', $thumbnailPath);
                $url = url($data['thumbnail']);
            }
            $new = News::create([
                'category_id' => $data['category_id'],
                'title' => $data['title'],
                'text' => $data['text'],
                'thumbnail' => $url,
                'store_date' => now(),
            ]);

            return $new;
        });
    }

    public function updateCategory($data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            $category = NewCategories::findOrFail($id);

            if (request()->hasFile('image')) {
                $oldImage = $category->image;

                $image = request()->file('image');
                $imagePath = $image->store('public/new_category_images');
                $data['image'] = str_replace('public/', 'storage/', $imagePath);
                $url = url($data['image']);

                $category->update([
                    'name' => $data['name'],
                    'about' => $data['about'],
                    'image' => $url,
                    'user_id' => $data['user_id'],
                ]);

                if ($oldImage) {
                    $oldImagePath = str_replace('storage/', 'public/', $oldImage);
                    Storage::delete($oldImagePath);
                }
            } else {
                $category->update([
                    'name' => $data['name'],
                    'about' => $data['about'],
                    'user_id' => $data['user_id'],
                ]);
            }

            return $category;
        });

    }

    public function storeCategory($data)
    {
        return DB::transaction(function () use (&$data) {

            if (!isset($data['user_id'])) {
                $data['user_id'] = auth()->id();
            }

            $url = null;

            $url = null;
            if (request()->hasFile('image')) {
                $image = request()->file('image');
                $imagePath = $image->store('public/new_category_images');
                $data['image'] = str_replace('public/', 'storage/', $imagePath);
                $url = url($data['image']);
            }

            $categoryData = [
                'name' => $data['name'],
                'about' => $data['about'],
                'image' => $url,
                'user_id' => $data['user_id'],
            ];

            $category = NewCategories::create($categoryData);
            return $category;
        });
    }

    public function showNews()
    {
        $newses = News::with('categories')->get();
        return $newses;
    }

    public function showCategories()
    {
        $categories = NewCategories::all();
        return $categories;
    }

    public function deleteCategory($id)
    {
        $category = NewCategories::find($id);
        $new = News::where('category_id', $category->id)->delete();

        return $category->delete();
    }

    public function delete($id)
    {
        return News::find($id)->delete();
    }
}
