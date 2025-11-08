<?php

namespace App\Http\Controllers;

use App\Models\Shipper;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    public function index()
    {
        $shippers = Shipper::all();
        return view('pages.shippers.index', compact('shippers'));
    }

    public function create()
    {
        return view('pages.shippers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:45',
            'contact_person' => 'required|max:45',
            'contact_no' => 'nullable|max:45',
        ]);

        Shipper::create($request->all());

        return redirect()->route('shippers.index')->with('success', 'Shipper created successfully.');
    }

    public function show(Shipper $shipper)
    {
        return view('pages.shippers.show', compact('shipper'));
    }

    public function edit(Shipper $shipper)
    {
        return view('pages.shippers.edit', compact('shipper'));
    }

    public function update(Request $request, Shipper $shipper)
    {
        $request->validate([
            'name' => 'required|max:45',
            'contact_person' => 'required|max:45',
            'contact_no' => 'nullable|max:45',
        ]);

        $shipper->update($request->all());

        return redirect()->route('shippers.index')->with('success', 'Shipper updated successfully.');
    }

    public function destroy(Shipper $shipper)
    {
        $shipper->delete();
        return redirect()->route('shippers.index')->with('success', 'Shipper deleted successfully.');
    }
}
