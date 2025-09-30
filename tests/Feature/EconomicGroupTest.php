<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\EconomicGroup;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class EconomicGroupTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    #[Test]
    public function can_create_economic_group()
    {
        $this->actingAs($this->user);

        Livewire::test('economic-group-form') // Seu componente de formulário
            ->set('name', 'Grupo Teste')
            ->set('cnpj', '12345678000195')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('economic_groups', [
            'name' => 'Grupo Teste'
        ]);
    }

    #[Test]
    public function can_list_economic_groups()
    {
        $this->actingAs($this->user);
        
        // Cria alguns grupos
        EconomicGroup::factory()->create(['name' => 'Grupo A']);
        EconomicGroup::factory()->create(['name' => 'Grupo B']);

        // Testa o componente de listagem
        Livewire::test('economic-groups')
            ->assertSee('Grupo A')
            ->assertSee('Grupo B');
    }
}