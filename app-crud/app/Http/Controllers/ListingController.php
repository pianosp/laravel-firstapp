<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ListingController extends Controller
{
    //show all listings
    public function index(){
        return view('listings.index', [ //listings.index คือ folder listings ไฟล์ index ใน View
            'listings' => Listing::latest()->filter(request(['tag','search']))->paginate(6) // paginate เลือกให้่แสดงตามจำนวนที่ต้องการ
            //filter จาก Request ที่มาจาก query string ในที่มี 2 ตัวคือ 'tag', 'search' หรือถ้าไม่มี query string ก็เรียกข้อมูลทั้งหมด
        ]);
    }

    //show single listing
    public function show(Listing $listing){
        return view('listings.show', ['listing' => $listing ]);
    }

    //show create form
    public function create(){
        return view('listings.create');
    }

    //store listing
    public function store(Request $request){
        // dd($request->all()); debug ข้อมูลที่ได้จาก submit form
        $formFields = $request-> validate([
            'title' => 'required',
            'company'=> ['required', Rule::unique('listings','company')], //การกำหนดว่า company ต้องไม่ว่างและ ต้องไม่ซ้ำในตาราง listings
            'location'=> 'required',
            'website'=>'required',
            'email'=> ['required','email'],
            'tag'=> 'required',
            'description'=> 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
            //เช็คว่า req มีไฟล์จาก logo มาให้เพิ่ม logo ลงใน formFields และเก็บลงใน folder logos
        }

        $formFields['user_id'] = auth()->id(); //เพิ่ม 'user_id' ไปใน Maps ของ formFields โดยเอามาจาก auth() session

        Listing::create($formFields); //Listing Model แทนตัวแปร DB (เสมือน DB context ของ c#)
        return redirect('/')->with('message','Listing created successfully!'); //สร้าง massage บอกว่าสร้างสำเร็จ
    }

    //show Edit Form
    public function edit(Listing $listing){
        return view('listings.edit', ['listing' => $listing]);
    }

    //Update Listing
    public function update(Request $request, Listing $listing){

        //Make Sure Logged in user in owner
        if($listing->user_id != auth()->id()){   //เช็คว่า Listing ที่จะ update เป็นของ user ปัจจุบันรึเปล่า
            abort(403, 'Unauthotized Action');
        }
        // dd($request->all()); debug ข้อมูลที่ได้จาก submit form
        $formFields = $request-> validate([
            'title' => 'required',
            'company'=> 'required',
            'location'=> 'required',
            'website'=>'required',
            'email'=> ['required','email'],
            'tag'=> 'required',
            'description'=> 'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
            //เช็คว่า req มีไฟล์จาก logo มาให้เพิ่ม logo ลงใน formFields และเก็บลงใน folder logos
        }

        $listing->update($formFields); //ใช้ $request->all() ในการ debug
        return back()->with('message','Listing updated successfully!');
    }

    //Delete Listing
    public function destroy(Listing $listing){

        //Make Sure Logged in user in owner
        if($listing->user_id != auth()->id()){ //เช็คว่า Listing ที่จะ update เป็นของ user ปัจจุบันรึเปล่า
            abort(403, 'Unauthotized Action');
        }

        $listing->delete();
        return redirect('/')->with('message','Listing deleted successfully!');
    }

    //Manage Listing
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
