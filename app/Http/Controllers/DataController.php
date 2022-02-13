<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;
use File;
use Response;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=Data::latest()->paginate(5);
        return view('data.liste')->with('data',$data);
    }

    /**
     * Display a data.
     */
    public function displayData()
    {
        $data=Data::where('status','=','approuve')->latest()->get();
        return view('data.display')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data.formData');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     //rules
        $rules=[
            'titre'=>'required|max:60',
            'image'=>'mimes:doc,docx,jpeg,png',
            'message'=>'required|max:300'
        ];
        //messages Errors
        $messages=[
            'titre.required'=>'remplir les champs',
            'titre.max'=>'trop grande',
            'image.mimes'=>'Les types autorise c est Doc, docx, jpeg, png',
            'message.required'=>'remplir les champs',
            'message.max'=>'trop grande'
        ];

       //validate inputs
        $validator = Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
            ->withInput();
        }
        else{

           //Save data
            $data=Data::create([
                'titre'=>$request->titre,
                'message'=>$request->message
            ]);

            //check if has file
            if ($request->has('image')) {

                $extension= $request->image->getClientOriginalExtension();
                $name= $request->image->getClientOriginalName();
                $imageName = time().''.$name;  

                //check type of file
                if ($extension=='jpeg' || $extension=='png') {
                    $destination = 'images';
                    $request->image->move($destination, $imageName);
                    $data->doc=$destination.'/'.$imageName;

                }
                else{
                    $destination = 'files';
                    $request->image->move($destination, $imageName);
                    $data->doc=$destination.'/'.$imageName;

                }

                $data->save();
               // Storage::put('public/images/',$imageName);  
            }
            return redirect()->route('display')->with('message','Data save Succesfully');
            // $extension= $request->image->getClientOriginalExtension();
            // $name= $request->image->getClientOriginalName();
            // return dd($extension,$name);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data=Data::find($id);
        return view('data.show')->with('data',$data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data=Data::find($id);
        return view('data.edit')->with('data',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $data=Data::find($id);    
        if ($request->has('image')) {
            $extension= $request->image->getClientOriginalName();
            $name= $request->image->getClientOriginalName();
            $imageName = time().''.$name;  

            //check type of file
            if ($extension=='jpeg' || $extension=='png') {
                $destination = 'storage/app/images';
                $request->image->move($destination, $imageName);

            }
            else{
                $destination = 'storage/app/files';
                $request->image->move($destination, $imageName);

            }
            $data->doc=$imageName;
            $data->save();
        }

        if ($request->has('titre')) {
            $data->update(['titre'=>$request->titre]);  
        }

        if ($request->has('message')) {
            $data->update(['message'=>$request->message]);  
        }
    
        return redirect()->route('admin')->with('message','Data save Succesfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data=Data::find($id);
        $data->delete();
        return redirect()->route('admin')->with('message','Data Deleted Succesfully');


    } 

    public function changestatus(Request $request,$id)
    {
        $data=Data::find($id);
        if ($request->status==1) {
            $data->update(['status'=>'approuve']);  
        }else{
            $data->update(['status'=>'rejeter']);  
        }
      
        return redirect()->back()->with('message','Status change Successfully');
    } 

    //Download file
    public function upload($id)
    {
        $data=Data::find($id);
        $filepath = public_path($data->doc);
        return Response::download($filepath);
    } 
}
