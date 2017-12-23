<?php

namespace App\Http\Controllers;

use App\Http\Requests\Data\AddDataRequest;
use App\Http\Requests\Data\UpdateDataRequest;
use App\Models\Data;
use App\Models\Section;
use App\Models\Site;
use Illuminate\Http\Request;

class DataController extends Controller
{

    /**
     * @param Site           $site
     * @param Section        $section
     * @param AddDataRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Site $site, Section $section, AddDataRequest $request)
    {
        if ($section->site_id != $site->id) {
            return response()->json(['success' => false], 403);
        }

        $record       = new Data($request->only(['name']));
        $record->data = array_map(function ($row) {
            return [
                'label' => $row['label'] ?? '',
                'value' => $row['value'] ?? '',
            ];
        }, $request->get('data', []));
        $section->data()->save($record);

        return response()->json(['success' => true, 'data' => $record], 201);
    }

    /**
     * @param Site              $site
     * @param Section           $section
     * @param Data              $data
     * @param UpdateDataRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Site $site, Section $section, Data $data, UpdateDataRequest $request)
    {
        if ($section->site_id != $site->id) {
            return response()->json(['success' => false], 403);
        }
        if ($data->section_id != $section->id) {
            return response()->json(['success' => false], 403);
        }
        $data->name = $request->get('name');
        $data->data = array_map(function ($row) {
            return [
                'label' => $row['label'] ?? '',
                'value' => $row['value'] ?? '',
            ];
        }, $request->get('data', []));
        $data->save();

        return response()->json(['success' => true, 'section' => $section], 203);
    }

    /**
     * @param Site    $site
     * @param Section $section
     *
     * @param Data    $data
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Site $site, Section $section, Data $data)
    {
        if ($section->site_id != $site->id) {
            return response()->json(['success' => false], 403);
        }
        if ($data->section_id != $section->id) {
            return response()->json(['success' => false], 403);
        }
        $data->delete();

        return response()->json(['success' => true], 203);
    }
}
