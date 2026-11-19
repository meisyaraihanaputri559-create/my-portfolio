<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Message;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortfolioController extends Controller
{
    private const PROFILE_DEFAULTS = [
        'name' => 'Atar Pratama',
        'classInfo' => 'XII PPLG (Pengembangan Perangkat Lunak dan Gim)',
        'bio' => 'Seorang Software Engineering Student yang bersemangat dalam membangun web aplikasi interaktif, sistem backend yang andal, serta eksplorasi teknologi modern.',
        'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=600',
    ];

    public function index()
    {
        return view('frontend.index', [
            'data' => [
                'profile' => $this->profile(),
                'projects' => Project::orderByDesc('id')->get()->map(fn ($p) => $this->projectOut($p))->values(),
                'certificates' => Certificate::orderByDesc('id')->get(),
                'messages' => [],
                'isAdmin' => (bool) session('is_admin'),
            ],
        ]);
    }

    // ---- Admin session ----
    public function login(Request $request)
    {
        $ok = hash_equals((string) env('ADMIN_USERNAME', 'admin'), (string) $request->input('username'))
            && hash_equals((string) env('ADMIN_PASSWORD', 'admin123'), (string) $request->input('password'));

        if (! $ok) {
            return response()->json(['message' => 'Username atau Password salah!'], 422);
        }
        $request->session()->regenerate();
        session(['is_admin' => true]);

        return response()->json(['messages' => $this->messagesOut()]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');

        return response()->json(['ok' => true]);
    }

    public function messages()
    {
        return response()->json($this->messagesOut());
    }

    // ---- Projects ----
    public function storeProject(Request $request)
    {
        return response()->json($this->projectOut(Project::create($this->projectIn($request))));
    }

    public function updateProject(Request $request, Project $project)
    {
        $project->update($this->projectIn($request));

        return response()->json($this->projectOut($project->fresh()));
    }

    public function destroyProject(Project $project)
    {
        $project->delete();

        return response()->json(['ok' => true]);
    }

    // ---- Certificates ----
    public function storeCertificate(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'image' => 'nullable|string|max:2000',
        ]);

        return response()->json(Certificate::create($data));
    }

    public function destroyCertificate(Certificate $certificate)
    {
        $certificate->delete();

        return response()->json(['ok' => true]);
    }

    // ---- Profile ----
    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'classInfo' => 'required|string|max:255',
            'bio' => 'required|string',
            'avatar' => 'nullable|string|max:2000',
        ]);
        foreach ($data as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => 'profile.'.$key],
                ['value' => (string) $value, 'updated_at' => now(), 'created_at' => now()]
            );
        }

        return response()->json($this->profile());
    }

    // ---- Public contact form ----
    public function storeMessage(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'text' => 'required|string|max:5000',
        ]);
        Message::create(['name' => $data['name'], 'email' => $data['email'], 'message' => $data['text']]);

        return response()->json(['ok' => true]);
    }

    // ---- helpers ----
    private function profile(): array
    {
        $saved = DB::table('settings')->where('key', 'like', 'profile.%')->pluck('value', 'key');
        $out = [];
        foreach (self::PROFILE_DEFAULTS as $k => $default) {
            $out[$k] = $saved['profile.'.$k] ?? $default;
        }

        return $out;
    }

    private function projectIn(Request $request): array
    {
        $d = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string|max:2000',
            'problem' => 'nullable|string',
            'goal' => 'nullable|string',
            'role' => 'nullable|string|max:255',
            'features' => 'nullable|string',
            'feedback' => 'nullable|string',
            'demo' => 'nullable|string|max:2000',
            'github' => 'nullable|string|max:2000',
        ]);

        return [
            'title' => $d['name'], 'technology' => $d['category'], 'description' => $d['description'],
            'image' => $d['image'] ?? null, 'problem' => $d['problem'] ?? null, 'goal' => $d['goal'] ?? null,
            'role' => $d['role'] ?? null, 'features' => $d['features'] ?? null, 'feedback' => $d['feedback'] ?? null,
            'demo_link' => $d['demo'] ?? null, 'github_link' => $d['github'] ?? null,
        ];
    }

    private function projectOut(Project $p): array
    {
        return [
            'id' => $p->id, 'name' => $p->title, 'category' => $p->technology, 'image' => $p->image ?? '',
            'description' => $p->description, 'problem' => $p->problem ?? '', 'goal' => $p->goal ?? '',
            'role' => $p->role ?? '', 'features' => $p->features ?? '', 'feedback' => $p->feedback ?? '',
            'demo' => $p->demo_link ?? '', 'github' => $p->github_link ?? '',
        ];
    }

    private function messagesOut()
    {
        return Message::orderByDesc('id')->get()->map(fn ($m) => [
            'name' => $m->name, 'email' => $m->email, 'text' => $m->message,
            'date' => $m->created_at?->format('j M Y'),
        ])->values();
    }
}
