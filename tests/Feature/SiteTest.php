<?php

namespace Tests\Feature;

use App\Models\Site;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    public function test_pulling_list_of_sites()
    {
        $sites = factory(Site::class, 3)->create();

        $response = $this->json('GET', '/site');
        $response->assertStatus(200);
        $response->assertJsonCount(3);
        $response->assertJson([
            [
                'id'   => $sites[0]->id,
                'name' => $sites[0]->name,
            ],
            [
                'id'   => $sites[1]->id,
                'name' => $sites[1]->name,
            ],
            [
                'id'   => $sites[2]->id,
                'name' => $sites[2]->name,
            ],
        ]);
    }

    public function test_adding_site()
    {
        $site = factory(Site::class)->make();

        $response = $this->json('POST', '/site', [
            'name'   => $site->name,
            'domain' => $site->domain,
            'notes'  => $site->notes,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('sites', [
            'name'   => $site->name,
            'domain' => $site->domain,
            'notes'  => $site->notes,
        ]);
    }

    public function test_adding_site_requires_name()
    {
        $site = factory(Site::class)->make();

        $response = $this->json('POST', '/site', [
            'name'   => '',
            'domain' => $site->domain,
            'notes'  => $site->notes,
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('sites', [
            'domain' => $site->domain,
        ]);
    }

    public function test_pulling_site_details()
    {
        $site = factory(Site::class)->create();

        $response = $this->json('GET', '/site/' . $site->id);
        $response->assertStatus(200);
        $response->assertJson([
            'id'     => $site->id,
            'name'   => $site->name,
            'domain' => $site->domain,
            'notes'  => $site->notes,
        ]);
    }

    public function test_updating_site_data()
    {
        $site = factory(Site::class)->create();

        $response = $this->json('PATCH', '/site/' . $site->id, [
            'name' => 'new name',
            'domain' => 'newdomain.com',
            'notes' => 'new notes',
        ]);
        $response->assertStatus(200);
        $response->assertJson([
            'id'     => $site->id,
            'name' => 'new name',
            'domain' => 'newdomain.com',
            'notes' => 'new notes',
        ]);
        $this->assertDatabaseHas('sites', [
            'id'     => $site->id,
            'name' => 'new name',
            'domain' => 'newdomain.com',
            'notes' => 'new notes',
        ]);
    }

    public function test_updating_site_requires_name()
    {
        $site = factory(Site::class)->create();

        $response = $this->json('PATCH', '/site/' . $site->id, [
            'name' => '',
            'domain' => 'newdomain.com',
            'notes' => 'new notes',
        ]);
        $response->assertStatus(422);
        $this->assertDatabaseHas('sites', [
            'id'     => $site->id,
            'name' => $site->name,
        ]);
    }

    public function test_delete_site()
    {
        $site = factory(Site::class)->create();

        $response = $this->json('DELETE', '/site/' . $site->id);
        $this->assertDatabaseMissing('sites', [
            'id'     => $site->id,
        ]);
    }
}
