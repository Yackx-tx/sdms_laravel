<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::with('students')->get();
        return view('sections.index', compact('sections'));
    }

    public function create()
    {
        return view('sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'SectionName' => 'required|string|max:255'
        ]);

        Section::create($validated);

        return redirect()->route('sections.index')
            ->with('success', 'Section created successfully');
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'SectionName' => 'required|string|max:255'
        ]);

        $section->update($validated);

        return redirect()->route('sections.index')
            ->with('success', 'Section updated successfully');
    }

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->route('sections.index')
            ->with('success', 'Section deleted successfully');
    }
}
