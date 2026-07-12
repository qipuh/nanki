<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fair;
use App\Models\FairImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FairImageController extends Controller
{
    public function store(Request $request, Fair $fair): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:12288'],
        ]);

        $path = $request->file('image')->store('fairs/gallery', 'public');
        $nextOrder = (int) ($fair->images()->max('order') ?? 0) + 1;

        $image = $fair->images()->create([
            'image' => $path,
            'order' => $nextOrder,
        ]);

        return response()->json($image);
    }

    public function reorder(Request $request, Fair $fair): JsonResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ])['ids'];

        foreach ($ids as $index => $id) {
            FairImage::where('id', $id)->where('fair_id', $fair->id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Fair $fair, FairImage $fairImage): JsonResponse
    {
        abort_unless($fairImage->fair_id === $fair->id, 404);

        Storage::disk('public')->delete($fairImage->image);
        $fairImage->delete();

        return response()->json(['success' => true]);
    }
}
