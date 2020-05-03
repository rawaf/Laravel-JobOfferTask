<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::paginate(10);
        return view('companies.index')->with(compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'website'=>'nullable|url',
            'email' => 'required|email|unique:companies,email',
            'logo'=>'nullable|file|image|mimes:jpeg,png|max:2048|dimensions:min_width=100,min_height=100',
        ]);

        $path = null;
        if (!is_null($request->logo)){
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $path = 'images/'.auth()->id().'/companies/logo.'.$extension;

            $file->storeAs('images/'.auth()->id(), 'companies/logo.'.$extension,'public');
        }

        $company = new Company([
            'name' => $request->get('name'),
            'website' => $request->get('website'),
            'email' => $request->get('email'),
            'logo' => $path,
            'user_id' => auth()->id()
        ]);
        $company->save();

        Mail::raw('A new Company has been created successfully', function ($message){
            $message->to(auth()->user()->email)
                ->subject('New Company');
        });

        return redirect('/companies')->with('message', 'Company has been created successfully and Email has been sent, Check your inbox.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find($id);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'website'=>'nullable|url',
            'email' => 'required|email|unique:companies,email,'.$id,
            'logo'=>'nullable|file|image|mimes:jpeg,png|max:2048|dimensions:min_width=100,min_height=100',
        ]);

        $company = Company::find($id);

        $path = null;
        if (!is_null($request->logo)){
            if (Storage::disk('public')->exists($company->logo))
                Storage::disk('public')->delete($company->logo);
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $path = 'images/'.auth()->id().'/companies/logo.'.$extension;

            $file->storeAs('images/'.auth()->id(), 'companies/logo.'.$extension,'public');
            $company->logo = $path;
        }


        $company->name =  $request->get('name');
        $company->website =  $request->get('website');
        $company->email = $request->get('email');

        $company->update();

        return redirect('/companies')->with('message', 'Company has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        $company->delete();

        return redirect('/companies')->with('message', 'Company has been deleted successfully');
    }

    public function uploadAvatar(Request $request)
    {

        $this->validate($request, [
            'image'=>'required|file|image|mimes:jpeg,png|max:2048',
        ]);

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $path = 'images/'.auth()->id().'/companies/avatar'.$extension;

        $file->storeAs('images/'.auth()->id(), 'companies/avatar.'.$extension,'public');

    }

}
