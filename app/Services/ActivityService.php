<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $poster = $data['poster'] ?? null;
        unset($data['poster']);

        if ($poster instanceof UploadedFile) {
            $data['poster_path'] = $poster->store('posters', 'public');
        }

        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $poster = $data['poster'] ?? null;
        unset($data['poster']);

        $oldPosterPath = $activity->poster_path;

        if ($poster instanceof UploadedFile) {
            $data['poster_path'] = $poster->store('posters', 'public');
        }

        $activity->update($data);

        if ($poster instanceof UploadedFile && $oldPosterPath) {
            Storage::disk('public')->delete($oldPosterPath);
        }

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
