<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function edit(): Response
    {
        return Inertia::render('Admin/Settings/Edit', [
            'settings' => [
                'site_name' => Setting::get('site_name', 'Nanki'),
                'site_logo' => Setting::get('site_logo'),
                'whatsapp_number' => Setting::get('whatsapp_number'),
            ],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'remove_logo' => ['boolean'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
        ]);

        Setting::set('site_name', $data['site_name']);
        Setting::set('whatsapp_number', $data['whatsapp_number'] ?? null);

        if ($request->hasFile('logo')) {
            $current = Setting::get('site_logo');
            if ($current) {
                Storage::disk('public')->delete($current);
            }
            $path = $request->file('logo')->store('brand', 'public');
            Setting::set('site_logo', $path);
        } elseif ($request->boolean('remove_logo')) {
            $current = Setting::get('site_logo');
            if ($current) {
                Storage::disk('public')->delete($current);
            }
            Setting::set('site_logo', null);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Marca actualizada.');
    }
}
