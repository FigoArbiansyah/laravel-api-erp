<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $validated['password'] = Hash::make($validated['password']);
            $validated['role_id'] = Role::ADMIN;

            $user = User::create($validated);

            // Create company
            $validatedCompany = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_email' => 'required|email|unique:companies,email',
                'phone' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:500',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimal 2MB
                'website' => 'nullable|url',
                'tax_id' => 'nullable|string|max:50',
                'industry' => 'nullable|string|max:100',
                'status' => 'nullable|in:active,inactive,suspended',
                'subscription_plan' => 'nullable|string|max:100',
                'subscription_expiry' => 'nullable|date',
                'owner_id' => 'nullable|exists:users,id',
                'notes' => 'nullable|string',
            ], [
                'company_name.required' => 'Nama perusahaan wajib diisi.',
                'company_email.required' => 'Email perusahaan wajib diisi.',
                'company_email.email' => 'Format email tidak valid.',
                'company_email.unique' => 'Email sudah terdaftar.',
                'phone.max' => 'Nomor telepon maksimal 15 karakter.',
                'address.max' => 'Alamat maksimal 500 karakter.',
                'logo.image' => 'Logo harus berupa file gambar.',
                'logo.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
                'logo.max' => 'Ukuran logo maksimal 2MB.',
                'website.url' => 'URL website tidak valid.',
                'status.in' => 'Status hanya dapat berupa active, inactive, atau suspended.',
                'subscription_expiry.date' => 'Tanggal kedaluwarsa harus berupa format tanggal.',
                'owner_id.exists' => 'Owner tidak valid.',
            ]);

            $validatedCompany['name'] = $request->company_name;
            $validatedCompany['email'] = $request->company_email;
            $validatedCompany['owner_id'] = $user->id;
            unset($validatedCompany['company_name']);
            unset($validatedCompany['company_email']);

            $company = $this->companyService->createCompany($validatedCompany);

            // Update user company
            User::where('id', $user->id)->update([
                "company_id" => $company->id,
            ]);

            $token = $user->createToken('API Token')->plainTextToken;

            DB::commit();
            return response()->json([
                'message' => 'Berhasil mendaftarkan akun',
                'token' => $token,
            ], 201);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function me()
    {
        $reqUser = request()->user();
        $user = User::with('company', 'role')->find($reqUser->id);

        return response()->json([
            'data' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

}
