<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class GalleryImageController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Gallery/Index', [
            'images' => GalleryImage::orderBy('order')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:12288'],
        ]);

        $path = $request->file('image')->store('gallery', 'public');
        $nextOrder = (int) (GalleryImage::max('order') ?? 0) + 1;

        $image = GalleryImage::create([
            'image' => $path,
            'active' => true,
            'order' => $nextOrder,
        ]);

        return response()->json($image);
    }

    public function update(Request $request, GalleryImage $galleryImage): JsonResponse
    {
        $data = $request->validate([
            'active' => ['required', 'boolean'],
        ]);

        $galleryImage->update($data);

        return response()->json($galleryImage);
    }

    public function reorder(Request $request): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        foreach ($ids as $index => $id) {
            GalleryImage::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(GalleryImage $galleryImage): JsonResponse
    {
        Storage::disk('public')->delete($galleryImage->image);
        $galleryImage->delete();

        return response()->json(['success' => true]);
    }
}
