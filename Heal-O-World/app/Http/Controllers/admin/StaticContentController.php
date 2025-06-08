<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticContent;
use Illuminate\Support\Facades\Auth;
use App\Models\Specialty;

class StaticContentController extends Controller

{
    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            abort(403, 'Доступ заборонено');
        }

        $staticContent = StaticContent::first();

        if (!$staticContent) {
            $staticContent = StaticContent::create([
                'mission_title' => '',
                'mission_text' => '',
                'why_us_title' => '',
                'why_us_list' => '',
                'reviews_title' => '',
                'reviews_text' => '',
            ]);
        }
        $specialties = Specialty::all();

        return view('admin.static-content.edit', compact('staticContent', 'specialties'));
    }


    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            abort(403, 'Доступ заборонено');
        }

        $staticContent = StaticContent::firstOrFail();

        $validated = $request->validate([
            'mission_title' => 'required|string',
            'mission_text' => 'required|string',
            'why_us_title' => 'required|string',
            'why_us_list' => 'required|string',
            'reviews_title' => 'required|string',
            'reviews_text' => 'required|string',
        ]);

        \Log::info('[StaticContentController] Отримано валідовані дані:', $validated);
        \Log::info('[StaticContentController] Дані до оновлення:', $staticContent->toArray());

        $staticContent->update($validated);

        $freshData = $staticContent->fresh();
        \Log::info('[StaticContentController] Дані після оновлення:', $freshData->toArray());

        return redirect()->route('admin.static-contents.edit')->with('success', 'Зміни збережено!');

    }


}


