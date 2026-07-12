<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fair;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class FairController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Fairs/Index', [
            'fairs' => Fair::withCount('images')->orderBy('order')->orderBy('id')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Fairs/Form', [
            'fair' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('fairs', 'public');
        }

        $fair = Fair::create($data);

        return redirect()->route('admin.fairs.edit', $fair)->with('success', 'Feria creada.');
    }

    public function edit(Fair $fair): Response
    {
        return Inertia::render('Admin/Fairs/Form', [
            'fair' => $fair->load('images'),
        ]);
    }

    public function update(Request $request, Fair $fair): RedirectResponse
    {
        $data = $this->validated($request, imageRequired: false);

        if ($request->hasFile('image')) {
            if ($fair->image) {
                Storage::disk('public')->delete($fair->image);
            }
            $data['image'] = $request->file('image')->store('fairs', 'public');
        } else {
            unset($data['image']);
        }

        $fair->update($data);

        return redirect()->route('admin.fairs.index')->with('success', 'Feria actualizada.');
    }

    public function destroy(Fair $fair): RedirectResponse
    {
        if ($fair->image) {
            Storage::disk('public')->delete($fair->image);
        }

        foreach ($fair->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $fair->delete();

        return redirect()->route('admin.fairs.index')->with('success', 'Feria eliminada.');
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:12288'],
        ]);
    }
}
