<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use App\Models\Chirp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class ChirpController extends Controller
{

    public function index(): View
    {
        return view('chirps.index', [

            'chirps' => Chirp::with('user')->latest()->get(),

        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request) :RedirectResponse
    {
        $validated = $request->validate([

            'message' => 'required|string|max:255',

        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));
    }

    public function show(Chirp $chirp)
    {
        //
    }

    public function edit(Chirp $chirp): View
    {
        $this->authorize('update', $chirp);

 

        return view('chirps.edit', [

            'chirp' => $chirp,

        ]);
    }

    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);

 

        $validated = $request->validate([

            'message' => 'required|string|max:255',

        ]);

 

        $chirp->update($validated);

 

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
