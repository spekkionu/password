<?php

namespace Tests\Feature;

use App\Models\Section;
use App\Models\Site;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_pulling_sections()
    {
        $site     = factory(Site::class)->create();
        $sections = factory(Section::class, 2)->create(['site_id' => $site->id]);

        $response = $this->json('GET', '/site/' . $site->id);
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'sections');
        $response->assertJson([
            'sections' => [
                [
                    'id'   => $sections[0]->id,
                    'name' => $sections[0]->name,
                ],
                [
                    'id'   => $sections[1]->id,
                    'name' => $sections[1]->name,
                ],
            ],
        ]);
    }

    public function test_only_sections_belonging_to_site_are_included()
    {
        $site     = factory(Site::class)->create();
        $site2    = factory(Site::class)->create();
        $section1 = factory(Section::class)->create(['site_id' => $site->id]);
        $section2 = factory(Section::class)->create(['site_id' => $site2->id]);

        $response = $this->json('GET', '/site/' . $site->id);
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'sections');
        $response->assertJson([
            'sections' => [
                [
                    'id'   => $section1->id,
                    'name' => $section1->name,
                ],
            ],
        ]);
    }

    public function test_updating_section_name()
    {
        $section  = factory(Section::class)->create();
        $response = $this->json('PATCH', '/site/' . $section->site_id . '/section/' . $section->id, [
            'name' => 'new name',
        ]);
        $this->assertDatabaseHas('sections', [
            'id'   => $section->id,
            'name' => 'new name',
        ]);
    }

    public function test_section_name_is_required()
    {
        $section  = factory(Section::class)->create();
        $response = $this->json('PATCH', '/site/' . $section->site_id . '/section/' . $section->id, [
            'name' => '',
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseHas('sections', [
            'id'   => $section->id,
            'name' => $section->name,
        ]);
    }

    public function test_adding_new_section()
    {
        $site     = factory(Site::class)->create();
        $response = $this->json('POST', '/site/' . $site->id . '/section', [
            'name' => 'section name',
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('sections', [
            'site_id' => $site->id,
            'name'    => 'section name',
        ]);
    }

    public function test_cannot_add_section_without_site()
    {
        $response = $this->json('POST', '/site/4/section', [
            'name' => 'section name',
        ]);
        $response->assertStatus(404);
        $this->assertDatabaseMissing('sections', [
            'site_id' => 4,
            'name'    => 'section name',
        ]);
    }

    public function test_delete_section()
    {
        $section  = factory(Section::class)->create();
        $response = $this->json('DELETE', '/site/' . $section->site_id . '/section/' . $section->id);
        $this->assertDatabaseMissing('sections', [
            'id' => $section->id,
        ]);
    }
}
