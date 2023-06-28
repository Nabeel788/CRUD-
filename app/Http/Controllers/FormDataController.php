<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormData;
class FormDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $formData = FormData::all();

        return view('form.index', compact('formData'));
    }
    
    public function form(){
        return view('form.create');

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|max:2048',
        ]);

        $formData = FormData::create($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $formData->image = $imagePath;
            $formData->save();
        }

        return redirect()->route('form.show', $formData->id);
    }

    public function show($id)
    {
        $formData = FormData::findOrFail($id);

        return view('form.show', compact('formData'));
    }

    public function edit($id)
    {
        $formData = FormData::findOrFail($id);

        return view('form.edit', compact('formData'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|max:2048',
        ]);

        $formData = FormData::findOrFail($id);
        $formData->update($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $formData->image = $imagePath;
            $formData->save();
        }

        return redirect()->route('form.show', $formData->id);
    }

    public function destroy($id)
    {
        $formData = FormData::findOrFail($id);
        $formData->delete();

        return redirect()->route('form.index');
    }
}
