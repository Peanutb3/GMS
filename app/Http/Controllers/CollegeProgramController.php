<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Models\Program;
use Illuminate\Http\Request;

class CollegeProgramController extends Controller
{
    /**
     * Display a listing of colleges and programs.
     */
    public function index()
    {
        $colleges = College::with('programs')->orderBy('name')->get();
        return view('admin.colleges-programs', compact('colleges'));
    }

    /**
     * Store a newly created college.
     */
    public function storeCollege(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colleges,name',
            'code' => 'nullable|string|max:50',
        ]);

        College::create($validated);

        return redirect()->route('admin.colleges-programs')
            ->with('success', 'College added successfully.');
    }

    /**
     * Update the specified college.
     */
    public function updateCollege(Request $request, College $college)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colleges,name,' . $college->id,
            'code' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $college->update($validated);

        return redirect()->route('admin.colleges-programs')
            ->with('success', 'College updated successfully.');
    }

    /**
     * Remove the specified college.
     */
    public function destroyCollege(College $college)
    {
        // Check if college has programs
        if ($college->programs()->count() > 0) {
            return redirect()->route('admin.colleges-programs')
                ->with('error', 'Cannot delete college with existing programs. Please delete or reassign programs first.');
        }

        $college->delete();

        return redirect()->route('admin.colleges-programs')
            ->with('success', 'College deleted successfully.');
    }

    /**
     * Store a newly created program.
     */
    public function storeProgram(Request $request)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
        ]);

        Program::create($validated);

        return redirect()->route('admin.colleges-programs')
            ->with('success', 'Program added successfully.');
    }

    /**
     * Update the specified program.
     */
    public function updateProgram(Request $request, Program $program)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $program->update($validated);

        return redirect()->route('admin.colleges-programs')
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified program.
     */
    public function destroyProgram(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.colleges-programs')
            ->with('success', 'Program deleted successfully.');
    }

    /**
     * Get programs for a specific college (AJAX endpoint).
     */
    public function getPrograms(College $college)
    {
        $programs = $college->programs()->active()->get();
        return response()->json($programs);
    }

    /**
     * Get all active colleges for API/forms
     */
    public function getColleges()
    {
        $colleges = College::active()->orderBy('name')->get(['id', 'name', 'code']);
        return response()->json($colleges);
    }

    /**
     * Get all active programs for a specific college by college ID
     */
    public function getProgramsByCollege($collegeId)
    {
        $programs = Program::where('college_id', $collegeId)
            ->active()
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return response()->json($programs);
    }
}
