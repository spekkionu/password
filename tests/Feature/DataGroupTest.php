<?php

namespace Tests\Feature;

use App\Models\Data;
use App\Models\Section;
use App\Models\Site;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DataGroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_pulling_list_of_data_groups()
    {
        $site    = factory(Site::class)->create();
        $section = factory(Section::class)->create(['site_id' => $site->id]);
        $data    = factory(Data::class, 2)->create([
            'section_id' => $section->id,
        ]);

        $response = $this->json('GET', '/site/' . $site->id);
        $response->assertStatus(200);
        $this->assertCount(2, $response->json()['sections'][0]['data']);
        $response->assertJson([
            'sections' => [
                [
                    'id'   => $section->id,
                    'data' => [
                        [
                            'name' => $data[0]->name,
                            'data' => $data[0]->data,
                        ],
                        [
                            'name' => $data[1]->name,
                            'data' => $data[1]->data,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function test_only_groups_from_given_section_and_site_are_included()
    {
        $site    = factory(Site::class)->create();
        $section = factory(Section::class)->create(['site_id' => $site->id]);
        $section2 = factory(Section::class)->create(['site_id' => $site->id]);
        $data = factory(Data::class)->create(['section_id' => $section->id]);
        $data2 = factory(Data::class)->create(['section_id' => $section2->id]);

        $response = $this->json('GET', '/site/' . $site->id);
        $response->assertStatus(200);
        $this->assertCount(1, $response->json()['sections'][0]['data']);
        $response->assertJson([
            'sections' => [
                [
                    'id'   => $section->id,
                    'data' => [
                        [
                            'name' => $data->name,
                            'data' => $data->data,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function test_adding_group_to_site_section()
    {
        $section = factory(Section::class)->create();
        $data = factory(Data::class)->make(['section_id' => $section->id]);
        $response = $this->json('POST', '/site/' . $section->site_id . '/section/' . $section->id . '/data', [
            'name' => $data->name,
            'data' => $data->data,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('data', [
            'section_id' => $section->id,
            'name' => $data->name
        ]);
    }

    public function test_adding_requires_valid_section()
    {
        $section = factory(Section::class)->create();
        $data = factory(Data::class)->make(['section_id' => $section->id]);
        $response = $this->json('POST', '/site/' . $section->site_id . '/section/4/data', [
            'name' => $data->name,
            'data' => $data->data,
        ]);
        $response->assertStatus(404);
        $this->assertDatabaseMissing('data', [
            'name' => $data->name
        ]);
    }

    public function test_adding_requires_name()
    {
        $section = factory(Section::class)->create();
        $data = factory(Data::class)->make(['section_id' => $section->id]);
        $response = $this->json('POST', '/site/' . $section->site_id . '/section/' . $section->id . '/data', [
            'name' => '',
            'data' => $data->data,
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('data', [
            'section_id' => $section->id,
        ]);
    }

    public function test_adding_requires_at_least_one_row()
    {
        $section = factory(Section::class)->create();
        $data = factory(Data::class)->make(['section_id' => $section->id]);
        $response = $this->json('POST', '/site/' . $section->site_id . '/section/' . $section->id . '/data', [
            'name' => $data->name,
            'data' => [],
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('data', [
            'section_id' => $section->id,
        ]);
    }

    public function test_update_data_group()
    {
        $section = factory(Section::class)->create();
        $data = factory(Data::class)->create(['section_id' => $section->id]);
        $response = $this->json('PATCH', '/site/' . $section->site_id . '/section/' . $section->id . '/data/' . $data->id, [
            'name' => 'new name',
            'data' => $data->data,
        ]);
        $response->assertStatus(203);
        $this->assertDatabaseHas('data', [
            'id' => $data->id,
            'section_id' => $section->id,
            'name' => 'new name',
        ]);
    }

    public function test_updating_requires_name()
    {
        $section = factory(Section::class)->create();
        $data = factory(Data::class)->create(['section_id' => $section->id]);
        $response = $this->json('PATCH', '/site/' . $section->site_id . '/section/' . $section->id . '/data/' . $data->id, [
            'name' => '',
            'data' => $data->data,
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseHas('data', [
            'id' => $data->id,
            'section_id' => $section->id,
            'name' => $data->name,
        ]);
    }

    public function test_updating_requires_at_least_one_row()
    {
        $section = factory(Section::class)->create();
        $data = factory(Data::class)->create(['section_id' => $section->id]);
        $response = $this->json('PATCH', '/site/' . $section->site_id . '/section/' . $section->id . '/data/' . $data->id, [
            'name' => 'new name',
            'data' => [],
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseHas('data', [
            'id' => $data->id,
            'section_id' => $section->id,
            'name' => $data->name,
        ]);
    }

    public function test_delete_data_group()
    {
        $section = factory(Section::class)->create();
        $data = factory(Data::class)->create(['section_id' => $section->id]);
        $response = $this->json('DELETE', '/site/' . $section->site_id . '/section/' . $section->id . '/data/' . $data->id);
        $response->assertStatus(203);
        $this->assertDatabaseMissing('data', [
            'id' => $data->id,
        ]);
    }
}
