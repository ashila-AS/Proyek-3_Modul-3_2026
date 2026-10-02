<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationService
{
    public function register(Activity $activity, array $data): Registration
    {
        // IC-01: Kegiatan harus berstatus published
        if ($activity->status !== 'published') {
            throw ValidationException::withMessages([
                'status' => 'Pendaftaran hanya dapat dilakukan untuk kegiatan yang sudah dipublikasikan.',
            ]);
        }

        // IC-02: Kegiatan yang tanggalnya sudah lewat tidak dapat didaftarkan
        // Tanggal hari ini masih diperbolehkan.
        if ($activity->activity_date->isBefore(now()->startOfDay())) {
            throw ValidationException::withMessages([
                'activity_date' => 'Pendaftaran tidak dapat dilakukan karena tanggal kegiatan sudah lewat.',
            ]);
        }

        // IC-04: Kapasitas tidak boleh sudah penuh
        if ($activity->registered_count >= $activity->capacity) {
            throw ValidationException::withMessages([
                'capacity' => 'Pendaftaran tidak dapat dilakukan karena kapasitas kegiatan sudah penuh.',
            ]);
        }

        // IC-03: Email yang sama tidak boleh terdaftar dua kali
        $alreadyRegistered = $activity->registrations()
            ->where('email', $data['email'])
            ->exists();

        if ($alreadyRegistered) {
            throw ValidationException::withMessages([
                'email' => 'Email tersebut sudah terdaftar pada kegiatan ini.',
            ]);
        }

        // Semua pemeriksaan lolos
        return DB::transaction(function () use ($activity, $data) {
            $registration = $activity->registrations()->create([
                'participant_name' => $data['participant_name'],
                'email' => $data['email'],
                'registered_at' => now(),
            ]);

            $activity->increment('registered_count');

            return $registration;
        });
    }
}