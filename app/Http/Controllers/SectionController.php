<?php

namespace App\Http\Controllers;

use App\Http\Requests\Section\AddSectionRequest;
use App\Http\Requests\Section\UpdateSectionRequest;
use App\Models\Section;
use App\Models\Site;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * @param Site              $site
     * @param AddSectionRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Site $site, AddSectionRequest $request)
    {
        $section = new Section($request->only(['name']));
        $site->sections()->save($section);

        return response()->json(['success' => true, 'section' => $section], 201);
    }

    /**
     * @param Site                 $site
     * @param Section              $section
     * @param UpdateSectionRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Site $site, Section $section, UpdateSectionRequest $request)
    {
        if ($section->site_id != $site->id) {
            return response()->json(['success' => false], 403);
        }
        $section->update($request->only('name'));

        return response()->json(['success' => true, 'section' => $section], 203);
    }

    /**
     * @param Site    $site
     * @param Section $section
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Site $site, Section $section)
    {
        if ($section->site_id != $site->id) {
            return response()->json(['success' => false], 403);
        }
        $section->delete();

        return response()->json(['success' => true], 203);
    }
}
