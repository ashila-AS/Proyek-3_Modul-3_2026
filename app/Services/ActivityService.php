<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Validation\ValidationException;

class ActivityService
{
    private const TRANSITIONS = [
        'draft' => ['published'],
        'published' => ['completed'],
        'completed' => [],
    ];

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $activity->update($data);

        return $activity->refresh();
    }

    public function publish(Activity $activity): Activity
    {
        $this->ensureValidTransition($activity->status, 'published');

        $requiredFields = [
            'category_id',
            'code',
            'title',
            'location',
            'activity_date',
            'capacity',
        ];

        foreach ($requiredFields as $field) {
            if (empty($activity->{$field})) {
                throw ValidationException::withMessages([
                    'status' => "Kegiatan belum lengkap. Field {$field} wajib diisi sebelum dipublikasikan.",
                ]);
            }
        }

        $activity->update([
            'status' => 'published',
        ]);

        return $activity->refresh();
    }

    public function complete(Activity $activity): Activity
    {
        $this->ensureValidTransition($activity->status, 'completed');

        $activity->update([
            'status' => 'completed',
        ]);

        return $activity->refresh();
    }

    private function ensureValidTransition(string $current, string $next): void
    {
        $allowed = self::TRANSITIONS[$current] ?? [];

        if (! in_array($next, $allowed, true)) {
            throw ValidationException::withMessages([
                'status' => "Transisi status {$current} ke {$next} tidak diizinkan.",
            ]);
        }
    }
}