<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SlideController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Slides/Index', [
            'slides' => Slide::orderBy('order')->orderBy('id')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Slides/Form', [
            'slide' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = $request->file('image')->store('slides', 'public');

        Slide::create($data);

        return redirect()->route('admin.slides.index')->with('success', 'Slide creado.');
    }

    public function edit(Slide $slide): Response
    {
        return Inertia::render('Admin/Slides/Form', [
            'slide' => $slide,
        ]);
    }

    public function update(Request $request, Slide $slide): RedirectResponse
    {
        $data = $this->validated($request, imageRequired: false);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slide->image);
            $data['image'] = $request->file('image')->store('slides', 'public');
        } else {
            unset($data['image']);
        }

        $slide->update($data);

        return redirect()->route('admin.slides.index')->with('success', 'Slide actualizado.');
    }

    public function destroy(Slide $slide): RedirectResponse
    {
        Storage::disk('public')->delete($slide->image);
        $slide->delete();

        return redirect()->route('admin.slides.index')->with('success', 'Slide eliminado.');
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'text_position' => ['required', 'in:left,center,right'],
            'text_align' => ['required', 'in:left,center,right'],
            'active' => ['boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:12288'],
        ]);
    }
}
