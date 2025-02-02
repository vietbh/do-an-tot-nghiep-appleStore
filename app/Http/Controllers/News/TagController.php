<?php

namespace App\Http\Controllers\News;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::paginate(10);
        return view('layouts.admin.News.Tags.index',compact('tags'));
    }

    public function store(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|unique:'.Tag::class,
            'index' =>'required|numeric|min:1|max:99999',
        ],[
            'name.required'=>'Không được để trống trường này!',
            'name.unique'=>'Đã tồn tại tag này rồi!',
            'index.required'=>'Không được để trống trường này!',
            'index.numeric'=>'Vui lòng nhập số !',
            'index.min'=>'Vui lòng nhập số lớn hơn hoặc bằng 1 !',
            'index.max'=>'Vui lòng nhập số nhỏ hơn 99999 !',
        ]);
        $slug = Str::slug($request->name); 
        $tag->name = $request->name;
        $tag->slug = $slug;
        $tag->position = $request->index;
        // $tag->parent_category_id = $request->parent_id;
        $tag->show_hide = $request->show_hide;
        $tag->save();
        return redirect()->route('news.tag.index')->with('success','Thêm mới tag thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $tagDelete = Tag::findOrFail($id);
        $tags = Tag::all();
        return view('layouts.admin.News.Tags.index',compact('tags','tagDelete'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $tag = Tag::findOrFail($id);
        $tags = Tag::paginate(10);
        return view('layouts.admin.News.Tags.index',compact('tag','tags'));       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tag = Tag::findOrFail($id);
        $request->validate([
            'name' => 'required|unique:'.Tag::class.',name,'.$id,
            'index' => 'required|min:1|max:999|numeric',
        ],[
            'name.required'=>'Không được để trống trường này!',
            'name.unique'=>'Đã tồn tại danh mục này rồi!',
            'index.required'=>'Không được để trống trường này!',
            'index.numeric'=>'Vui lòng nhập số!',
            'index.min'=>'Vui lòng nhập số lớn hơn hoặc bằng 1 !',
            'index.max'=>'Vui lòng nhập số nhỏ hơn 999 !',

        ]);
        $slug = Str::slug($request->name); 
        $tag->name = $request->name;
        $tag->slug = $slug;
        $tag->position = $request->index;
        // $tag->parent_category_id = $request->parent_id;
        $tag->show_hide = $request->show_hide;
        $tag->update();
        return redirect()->route('news.tag.index')->with('success','Cập nhật Tag thành công');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $tag = Tag::findOrFail($id);
        $tag->delete();
        $alert='Tag #'.$tag->name.' đã được xóa thành công.';
        return redirect()->route('news.tag.index')->with('success',$alert);
    }
}
