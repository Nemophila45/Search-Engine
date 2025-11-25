<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $staff = User::query()
            ->whereIn('role', [UserRole::DOCTOR, UserRole::KOAS])
            ->orderBy('name')
            ->get();

        return view('admin.users.index', [
            'staff' => $staff,
            'roles' => [
                UserRole::DOCTOR,
                UserRole::KOAS,
            ],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in([UserRole::DOCTOR->value, UserRole::KOAS->value])],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => UserRole::from($data['role']),
        ]);

        $user->forceFill(['email_verified_at' => now()])->save();

        $this->logActivity(
            'user_created',
            "Buat akun {$user->name} ({$user->email})",
            [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role?->value ?? $user->role,
            ],
            User::class,
            $user->id
        );

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun berhasil dibuat.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if (!$user->hasAnyRole(UserRole::DOCTOR, UserRole::KOAS)) {
            abort(403, 'Hanya akun dokter atau koas yang bisa dihapus.');
        }

        if ($request->user()->is($user)) {
            abort(403, 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $metadata = [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role?->value ?? $user->role,
        ];

        $user->delete();

        $this->logActivity(
            'user_deleted',
            "Hapus akun {$user->name} ({$user->email})",
            $metadata,
            User::class,
            $user->id
        );

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'Akun berhasil dihapus.');
    }

    private function logActivity(
        string $action,
        string $description,
        array $metadata = [],
        ?string $subjectType = null,
        ?int $subjectId = null
    ): void {
        $actor = Auth::user();

        ActivityLog::create([
            'user_id' => $actor?->id,
            'user_role' => $actor?->role?->label(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'metadata' => empty($metadata) ? null : $metadata,
        ]);
    }
}
