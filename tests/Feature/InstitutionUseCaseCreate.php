<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstitutionUseCaseCreate extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create(): void
    {
        $data = [
                "id" => 0,
                "name" => "MUNI CARUMAS",
                "address" => "CARUMAS S/N",
                "phone" => "09090909",
                "email" => "muni@gmail.com",
                "ruc" => "12345678912",
                "mission" => "Misión",
                "vision" => "Visión",
                "offices" => []
        ];
        $response = $this->post('/api/institution', $data);
        $response->assertStatus(200);
    }

    public function test_fail_create(): void
    {
        $data = [
            "id" => 0,
            "name" => "MUNI CARUMAS",
            "address" => "CARUMAS S/N",
            "phone" => "09090909"
        ];
        $response = $this->post('/api/institution', $data);
        $response->assertStatus(500);
    }
}
