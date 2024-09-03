<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivitylogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('query') ? $request->get('query') : '';
        if ($request->ajax()) {
            if ($search != '') {
                $activityLogs = Activity::where(function ($query) use ($search) {
                    return $query
                        ->whereHas('subject', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%')->orWhere('name', 'like', '%' . $search . '%');
                        })
                        ->orwhereHas('causer', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%')->orWhere('name', 'like', '%' . $search . '%');
                        })
                        ->orWhere('description', 'like', '%' . $search . '%');
                })->orderByDesc('created_at')->paginate(10);
            } else {
                $activityLogs = Activity::orderByDesc('created_at')->paginate(10);
            }
            return view('filterActivitylog', compact('activityLogs'));
        } else {
            $activityLogs = Activity::orderByDesc('created_at')->paginate(10);
            return view('activityLog', compact('activityLogs'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete()
    {
        $activityLogs = Activity::truncate();
        $url = "/activity";
        return response()->json([
            'activityLogs' => $activityLogs,
            'status' => 200,
        ]);
    }
}
