<?php

namespace App\Http\Controllers;

use App\Http\Requests\Site\AddSiteRequest;
use App\Http\Requests\Site\UpdateSiteRequest;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Site::all();
    }

    /**
     * @param AddSiteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(AddSiteRequest $request)
    {
        $site = Site::create([
            'name' => $request->get('name'),
            'domain' => $request->get('domain'),
            'notes' => $request->get('notes'),
        ]);

        return response()->json($site, 201, ['location' => route('site', $site)]);
    }

    /**
     * @param Site $site
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show(Site $site)
    {
        $site->loadMissing('sections', 'sections.data');
        if (request()->wantsJson()) {
            return response()->json($site);
        }
        return view('site', compact('site'));
    }

    /**
     * @param Site              $site
     * @param UpdateSiteRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Site $site, UpdateSiteRequest $request)
    {
        $site->update($request->only(['name', 'domain', 'notes']));

        return response()->json($site);
    }

    /**
     * @param Site $site
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Site $site)
    {
        $site->delete();

        return response()->json(['success' => true]);
    }
}
