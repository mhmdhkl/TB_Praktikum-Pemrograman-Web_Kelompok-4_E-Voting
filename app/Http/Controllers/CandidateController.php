<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidates = Candidate::get();

        return view("candidate.index", [
            'title' => 'E-Voting | Candidate List',
            'candidates' => $candidates
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|unique:candidates,name',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'resume' => 'mimes:pdf|max:5120',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'election_number' => 'required|unique:candidates,election_number',
        ]);

        $pictureName = null;
        $resumeName = null;

        if ($request->file('picture')) {
            $pictureFile = $request->file('picture');
            $pictureName = uniqid('picture_') . '.' . $pictureFile->getClientOriginalExtension();
            $pictureFile->storePubliclyAs('candidate-pictures', $pictureName);
        }

        if ($request->file('resume')) {
            $resumeFile = $request->file('resume');
            $resumeName = uniqid('resume_') . '.' . $resumeFile->getClientOriginalExtension();
            $resumeFile->storePubliclyAs('candidate-resumes', $resumeName);
        }
        $validatedData['picture'] = $pictureName;
        $validatedData['resume'] = $resumeName;
        $validatedData['visi'] = $request->visi;
        $validatedData['misi'] = $request->misi;

        Candidate::create($validatedData);

        return redirect()->route('candidate.index')->with('message', 'Data Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $candidates = Candidate::findOrFail($id);
        $pdfPath = public_path('storage/candidate-resumes/' . $candidates->resume);

        if (!File::exists($pdfPath)) {
            abort(404);
        }

        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $candidates->resume . '"',
        ];

        return response()->file($pdfPath, $headers);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $candidate = Candidate::findOrFail($id); // Mengambil data kandidat berdasarkan ID
        return view('candidate.components.modal', compact('candidate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $candidates = Candidate::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:candidates,name,' . $candidates->id,
            'picture' => $request->hasFile('picture') ? 'required|image|mimes:jpeg,png,jpg' : 'nullable',
            'resume' => $request->hasFile('resume') ? 'required|mimes:pdf' : 'nullable',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'election_number' => 'required|unique:candidates,election_number,' . $candidates->id,
        ]);

        $newPictureName = $candidates->picture;
        $newResumeName = $candidates->resume;

        if ($request->hasFile('picture')) {
            $pictureFile = $request->file('picture');
            $newPictureName = uniqid('picture_') . '.' . $pictureFile->getClientOriginalExtension();
            $pictureFile->storePubliclyAs('candidate-pictures', $newPictureName);

            if ($candidates->picture) {
                Storage::delete('candidate-pictures/' . $candidates->picture);
            }
        }

        if ($request->hasFile('resume')) {
            $cvFile = $request->file('resume');
            $newResumeName = uniqid('resume_') . '.' . $cvFile->getClientOriginalExtension();
            $cvFile->storePubliclyAs('candidate-resumes', $newResumeName);

            if ($candidates->resume) {
                Storage::delete('candidate-resumes/' . $candidates->resume);
            }
        }

        $validatedData['picture'] = $newPictureName;
        $validatedData['resume'] = $newResumeName;
        $validatedData['visi'] = $request->visi;
        $validatedData['misi'] = $request->misi;
        $candidates->update($validatedData);

        return redirect()->route('candidate.index')->with('message', 'Data Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $candidates = Candidate::findOrFail($id);

        if ($candidates->picture) {
            Storage::delete('candidate-pictures/' . $candidates->picture);
        }

        if ($candidates->resume) {
            Storage::delete('candidate-resumes/' . $candidates->resume);
        }

        $candidates->delete();

        return redirect()->route('candidate.index')->with('message', 'Data Berhasil Dihapus!');
    }
}
