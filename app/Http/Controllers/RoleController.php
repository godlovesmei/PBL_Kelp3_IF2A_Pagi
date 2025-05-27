<?php

namespace App\Http\Controllers;

use App\Services\RoleService;
use Illuminate\Support\Facades\Auth;
use App\Constants\RoleConstant; // Pastikan RoleConstant sudah ada
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    protected $roleService;

    /**
     * Constructor untuk injeksi RoleService
     * 
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Menampilkan semua role
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Validasi apakah pengguna adalah DEALER
            if (Auth::user()->role_id !== RoleConstant::DEALER) {
                return response()->json(['message' => 'Anda tidak memiliki akses ke halaman ini.'], 403);
            }

            // Ambil semua role
            $roles = $this->roleService->getAllRoles();
            return response()->json($roles, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data roles', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan role berdasarkan ID
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            // Validasi apakah pengguna adalah DEALER
            if (Auth::user()->role_id !== RoleConstant::DEALER) {
                return response()->json(['message' => 'Anda tidak memiliki akses ke halaman ini.'], 403);
            }

            // Dapatkan role berdasarkan ID
            $role = $this->roleService->getRoleById($id);

            // Jika role ditemukan
            if ($role) {
                return response()->json($role, 200);
            }

            // Jika role tidak ditemukan
            return response()->json(['message' => 'Role tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data role', 'message' => $e->getMessage()], 500);
        }
    }
}