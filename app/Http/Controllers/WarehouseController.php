<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::all();
        return view('pages.warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('pages.warehouses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:45',
            'city' => 'required|max:45',
            'contact' => 'required|max:45',
        ]);

        Warehouse::create($request->all());
        return redirect()->route('warehouses.index')->with('success', 'Warehouse created successfully.');
    }

    public function show(Warehouse $warehouse)
    {
        return view('pages.warehouses.show', compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('pages.warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $request->validate([
            'name' => 'required|max:45',
            'city' => 'required|max:45',
            'contact' => 'required|max:45',
        ]);

        $warehouse->update($request->all());
        return redirect()->route('warehouses.index')->with('success', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted successfully.');
    }
}

