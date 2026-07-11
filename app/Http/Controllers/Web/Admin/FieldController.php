<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Venue;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::with('venue')->get();
        return view('admin.fields.index', compact('fields'));
    }

    public function create()
    {
        $venues = Venue::all();
        return view('admin.fields.create', compact('venues'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'name' => 'required|string|max:255',
            'sport_type' => 'required|string|max:100',
            'price_per_hour' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('fields', 'public');
        }

        Field::create($data);
        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $field = Field::findOrFail($id);
        $venues = Venue::all();
        return view('admin.fields.edit', compact('field', 'venues'));
    }

    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'sport_type' => 'required|string|max:100',
            'price_per_hour' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('fields', 'public');
        }
        $data['is_active'] = $request->has('is_active');

        $field->update($data);
        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $field = Field::findOrFail($id);
        $field->delete();
        return redirect()->route('admin.fields.index')->with('success', 'Lapangan berhasil dihapus!');
    }
}
