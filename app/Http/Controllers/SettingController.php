<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit(Request $request)
    {
        $settings = $request->user()->getOrCreateSetting();

        return view('settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_email' => ['nullable', 'email', 'max:255'],
            'company_phone' => ['nullable', 'string', 'max:50'],
            'company_address' => ['nullable', 'string', 'max:1000'],
            'company_logo' => ['nullable', 'image', 'max:2048'],
            'default_currency' => ['nullable', 'string', 'size:3'],
            'default_tax_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'default_terms' => ['nullable', 'string', 'max:2000'],
            'invoice_prefix' => ['nullable', 'string', 'max:20'],
        ]);

        $settings = $request->user()->getOrCreateSetting();

        if ($request->hasFile('company_logo')) {
            if ($settings->company_logo_path) {
                Storage::delete($settings->company_logo_path);
            }
            $validated['company_logo_path'] = $request->file('company_logo')->store('logos');
        }
        unset($validated['company_logo']);

        $settings->update($validated);

        return redirect()->route('settings.edit')
            ->with('success', 'Settings updated successfully.');
    }
}
