<?php

namespace App\Http\Controllers\Staff;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index()
    {
        $result = Service::all();
        return view('staff.service.index', compact('result'));
    }

    public function add(Request $request)
    {
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'type' => 'required|max:191',
                'price' => 'required|numeric',
                'order' => 'integer',
                'price_type' => 'required|in:Estimate,Net',
//                'minutes_needed' => 'required|numeric',
                'description' => 'max:60',
            ]);

            Service::create($inputs);

            flash('Record added')->success();
            return redirect()->route('staff.service');
        } else {
            return view('staff.service.add');
        }

    }

    public function edit($id, Request $request)
    {
        $record = Service::findOrFail($id);
        if ($request->method() == 'POST') {
            $inputs = $request->validate([
                'name' => 'required|max:191',
                'type' => 'required|max:191',
                'price' => 'required|numeric',
                'order' => 'integer',
                'price_type' => 'required|in:Estimate,Net',
//                'minutes_needed' => 'required|numeric',
                'description' => 'max:60',
            ]);

            $record->update($inputs);

            flash('Record updated')->success();
            return redirect()->route('staff.service');
        } else {

            return view('staff.service.edit', compact('record'));
        }
    }

    public function delete($id)
    {
        $record = Service::findOrFail($id);
        $record->delete();

        flash('Record deleted')->warning()->important();
        return redirect()->back();
    }
}
