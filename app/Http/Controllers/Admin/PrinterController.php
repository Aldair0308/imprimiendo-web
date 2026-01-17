<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Printer;
use Illuminate\Http\Request;

class PrinterController extends Controller
{
    public function index()
    {
        $printers = Printer::orderBy('priority')->get();
        return view('admin.printers.index', compact('printers'));
    }

    public function create()
    {
        return view('admin.printers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ip' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:online,offline,maintenance'],
            'is_available' => ['required', 'boolean'],
            'color_support' => ['required', 'boolean'],
            'duplex_support' => ['required', 'boolean'],
            'priority' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $data['queue_length'] = 0;

        Printer::create($data);

        return redirect()->route('admin.printers.index');
    }

    public function edit(Printer $printer)
    {
        return view('admin.printers.edit', compact('printer'));
    }

    public function update(Request $request, Printer $printer)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ip' => ['nullable', 'string', 'max:255'],
            'model' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:online,offline,maintenance'],
            'is_available' => ['required', 'boolean'],
            'color_support' => ['required', 'boolean'],
            'duplex_support' => ['required', 'boolean'],
            'priority' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $printer->update($data);
        return redirect()->route('admin.printers.index');
    }

    public function destroy(Printer $printer)
    {
        $printer->delete();
        return redirect()->route('admin.printers.index');
    }
}

