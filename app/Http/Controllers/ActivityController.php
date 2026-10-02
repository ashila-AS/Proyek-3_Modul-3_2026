<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use App\Models\Category;
use App\Services\ActivityService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $activities = Activity::query()
            ->with('category')
            ->search($request->query('search'))
            ->ofCategory($request->query('category_id'))
            ->ofStatus($request->query('status'))
            ->sortByDate($request->query('sort'))
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();

        return view('activities.create', compact('categories'));
    }

    public function store(StoreActivityRequest $request, ActivityService $service): RedirectResponse
    {
        $activity = $service->create($request->validated());

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dibuat.');
    }

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity): View
    {
        $categories = Category::all();

        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity, ActivityService $service): RedirectResponse
    {
        $service->update($activity, $request->validated());

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function publish(Activity $activity, ActivityService $service): RedirectResponse
    {
        try {
            $service->publish($activity);
        } catch (DomainException $exception) {
            return back()->withErrors(['status' => $exception->getMessage()]);
        }

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil dipublikasikan.');
    }

    public function complete(Activity $activity, ActivityService $service): RedirectResponse
    {
        try {
            $service->complete($activity);
        } catch (DomainException $exception) {
            return back()->withErrors(['status' => $exception->getMessage()]);
        }

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diselesaikan.');
    }

        public function trash(): View
    {
        $activities = Activity::onlyTrashed()
            ->with('category')
            ->latest('deleted_at')
            ->paginate(10);

        return view('activities.trash', compact('activities'));
    }

    public function restore(Activity $activity): RedirectResponse
    {
        $activity->restore();

        return to_route('activities.index')
            ->with('success', 'Kegiatan berhasil dipulihkan.');
    }
    public function destroy(Activity $activity): RedirectResponse
    {
        $activity->delete();

        return to_route('activities.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }
}