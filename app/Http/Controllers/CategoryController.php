<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::withCount('products')->get();
    }

    public function getBySlug($slug)
    {
        return Category::where('slug', $slug)->first();
    }

    public function getListProduct($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();
        if ($category) {
            return $category->products;
        }
        return null;
    }

    /**
     * Store a newly created catetory in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category = new Category($request->all());

        if ($category->slug === '') {
            $category->slug = Str::slug($category->name);
        }

        $imageField = 'banner';

        if ($request->hasFile($imageField))

            if ($request->file($imageField)->isValid()) {
                try {
                    $extension = $request->banner->extension();
                    $imageName = $category->slug . '-' . time() . '.' . $extension;
                    $imagePath = $request->banner->storeAs('upload/categories', $imageName);
                    $category->banner = $imagePath;
                } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
                    throw $e;
                }
            }

        $category->save();

        $responseData = [
            'data' => $category,
            'message' => 'Create category successful',
            'error_code' => 0,
            'status' => 1
        ];

        return response($responseData, 201);
    }

    /**
     * Display the specified category.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return [
            'data' => $category,
            'error_code' => 0,
            'status' => 1
        ];
    }

    /**
     * Update the specified category in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category = Category::find($category->id);

        if (!$category) {
            return response([
                'error_code' => 1,
                'status' => 1,
                'message' => 'Category not found'
            ]);
        }

        if ($category->slug === '') {
            $category->slug = Str::slug($category->name);
        }

        $imageField = 'banner';

        if ($request->hasFile($imageField))

            if ($request->file($imageField)->isValid()) {
                try {
                    $extension = $request->banner->extension();
                    $imageName = $category->slug . '-' . time() . '.' . $extension;
                    $imagePath = $request->banner->storeAs('upload/categories', $imageName);
                    $category->banner = $imagePath;
                } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $e) {
                    throw $e;
                }
            }

        $category->save();

        $responseData = [
            'data' => $category,
            'message' => 'Create category successful',
            'error_code' => 0,
            'status' => 1
        ];

        return response($responseData, 200);
    }

    /**
     * Remove the specified category from database.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        return Category::destroy($category);
    }
}
