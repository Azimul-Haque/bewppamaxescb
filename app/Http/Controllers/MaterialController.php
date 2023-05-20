<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Material;

use Carbon\Carbon;
use DB;
// use Hash;
use Auth;
// use Image;
// use File;
use Session;
// use Artisan;
use Redirect;
// use OneSignal;
use Cache;

class MaterialController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware(['admin'])->only('storeMaterial', 'updateMaterial', 'deleteMaterial');
        // $this->middleware(['manager'])->only();
    }

    public function getMaterials()
    {
        if(!(Auth::user()->role == 'admin' || Auth::user()->role == 'manager')) {
            abort(403, 'Access Denied');
        }
        
        $totalmaterials = Material::count();
        $materials = Material::orderBy('id', 'desc')->paginate(10);

        return view('dashboard.materials.index')
                    ->withMaterials($materials)
                    ->withTotalmaterials($totalmaterials);
    }

    public function storeMaterial(Request $request)
    {
        // dd($request->all());
        $this->validate($request,array(
            'type'    => 'required|integer',
            'title'    => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'author_desc'    => 'required|string|max:255',
            'content'    => 'required',
            'url'     => 'sometimes',
            'status'     => 'required|integer',
        ));

        $material             = new Material;
        $material->type   = $request->type;
        $material->title   = $request->title;
        $material->author    = $request->author;
        $material->author_desc    = $request->author_desc;
        $material->content    = $request->content;
        $material->url    = $request->url;
        $material->status     = $request->status;
        $material->save();

        Cache::forget('lecturematerials');
        Session::flash('success', 'Material added successfully!');
        return redirect()->back();
        // if(request()->routeIs('dashboard.questionstopicbased')) {
        //     return redirect()->route('dashboard.questionstopicbased', $request->topic_id);
        // } else {
        //     return redirect()->route('dashboard.questions');
        // }
        
    }

    public function updateMaterial(Request $request, $id)
    {
        // dd($request->file('image'));
        $this->validate($request,array(
            'type'    => 'required|integer',
            'title'    => 'required|string|max:255',
            'author'    => 'required|string|max:255',
            'author_desc'    => 'required|string|max:255',
            'content'    => 'required',
            'url'     => 'sometimes',
            'status'     => 'required|integer',
        ));

        // dd($request->tags_ids);

        $material =  Material::findOrFail($id);
        $material->type   = $request->type;
        $material->title   = $request->title;
        $material->author    = $request->author;
        $material->author_desc    = $request->author_desc;
        $material->content    = $request->content;
        $material->url    = $request->url;
        $material->status     = $request->status;
        $material->save();

        Cache::forget('lecturematerials');
        Cache::forget('singlelecturematerial' . $id);
        Session::flash('success', 'Material updated successfully!');
        return redirect()->back();
    }

    public function deleteMaterial($id)
    {
        $material = Material::find($id);
        
        $material->delete();

        Cache::forget('lecturematerials');
        Session::flash('success', 'Material deleted successfully!');
        return redirect()->route('dashboard.materials');
    }
}
