<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Multipic;
use Image;
use Auth;

class HomeController extends Controller
{

    public function Home(){
        $brands = DB::table('brands')->get();
        $abouts = DB::table('home_abouts')->first();
        $images = Multipic::all();
        return view('home', compact('brands','abouts','images'));
    }


    public function HomeSlider(){
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function AddSlider(){
        return view('admin.slider.create');
    }

    public function StoreSlider(Request $request){

        $slider_image =  $request->file('image');

       
        $name_gen = hexdec(uniqid()).'.'.$slider_image->getClientOriginalExtension();
        Image::make($slider_image)->resize(1920,1088)->save('image/slider/'.$name_gen);

        $last_img = 'image/slider/'.$name_gen;
 
        Slider::insert([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $last_img,
            'created_at' => Carbon::now()
        ]);
         
        return Redirect()->route('home.slider')->with('success','Slider Inserted Successfully');

    }




}
 