<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;                

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // ===============================================
        // <<< DEFINISI GATES (GERBANG IZIN) >>>
        // ===============================================

        /**
         * Gate 1: 'kelola-sistem'
         * Siapa yang boleh mengelola modul inti (Petugas, Layanan, Warga)?
         * HANYA Super Admin.
         */
        Gate::define('kelola-sistem', function(User $user) {
            return $user->role === 'super_admin';
        });

        /**
         * Gate 2: 'kelola-berkas'
         * Siapa yang boleh mengelola modul operasional (Booking, Pengajuan Berkas)?
         * Super Admin DAN Petugas Layanan.
         */
        Gate::define('kelola-berkas', function(User $user) {
            return in_array($user->role, ['super_admin', 'petugas_layanan']);
        });

        /**
         * Gate 3: 'kelola-konten'
         * Siapa yang boleh mengelola modul konten (Pengumuman)?
         * Super Admin DAN Petugas Layanan.
         */
        Gate::define('kelola-konten', function(User $user) {
            return in_array($user->role, ['super_admin', 'petugas_layanan']);
        });

        /**
         * Gate 4: 'lihat-laporan'
         * Siapa yang boleh melihat dashboard dan laporan (Pimpinan)?
         * Super Admin DAN Pimpinan. (Petugas Layanan tidak perlu lihat ini)
         */
        Gate::define('lihat-laporan', function(User $user) {
            return in_array($user->role, ['super_admin', 'pimpinan']);
        });
        
        // Catatan: 'CheckRoleMiddleware' Anda sudah melindungi 
        // akses umum ke /admin, jadi kita tidak perlu Gate 'isAdmin'.
    }
}
