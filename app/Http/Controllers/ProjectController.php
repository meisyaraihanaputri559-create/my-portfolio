<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    // Menampilkan daftar proyek di halaman portfolio
    public function index()
    {
        $projects = Project::all(); // Mengambil semua data dari database
        return view('frontend.index', compact('projects'));
    }

    // Menyimpan data proyek baru dari Admin Dashboard
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'technology' => 'required',
        ]);

        Project::create($request->all());

        return redirect()->back()->with('success', 'Proyek berhasil ditambahkan!');
    }
}