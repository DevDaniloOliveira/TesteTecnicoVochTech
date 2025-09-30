<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Flag;
use App\Models\EconomicGroup;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class FlagTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $economicGroup;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->economicGroup = EconomicGroup::factory()->create();
    }

    #[Test]
    public function can_create_flag()
    {
        $this->actingAs($this->user);

        Livewire::test('flag-form')
            ->set('name', 'Bandeira Teste')
            ->set('economic_group_id', $this->economicGroup->id) // ← Nome correto da propriedade
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('flags', [
            'name' => 'Bandeira Teste',
            'economic_group_id' => $this->economicGroup->id
        ]);
    }

    #[Test]
    public function can_update_flag()
    {
        $this->actingAs($this->user);
        $flag = Flag::factory()->create(['economic_group_id' => $this->economicGroup->id]);

        // Use o componente correto e propriedades reais
        Livewire::test('flag-form', ['flagId' => $flag->id])
            ->set('name', 'Bandeira Atualizada')
            ->set('economic_group_id', $this->economicGroup->id) // ← Nome correto
            ->call('save')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('flags', [
            'id' => $flag->id,
            'name' => 'Bandeira Atualizada'
        ]);
    }

    #[Test]
    public function can_list_flags()
    {
        $this->actingAs($this->user);
        Flag::factory()->create(['name' => 'Bandeira A']);
        Flag::factory()->create(['name' => 'Bandeira B']);

        Livewire::test('flags')
            ->assertSee('Bandeira A')
            ->assertSee('Bandeira B');
    }

    #[Test]
    public function can_delete_flag()
    {
        $this->actingAs($this->user);
        $flag = Flag::factory()->create();

        // Use o método real do seu componente
        Livewire::test('flag-delete')
            ->set('flagToDelete', $flag) // ← Nome correto
            ->call('confirmDelete') // ← Nome correto do método
            ->assertDispatched('refresh-table'); // Ou a ação que seu componente faz

        $this->assertDatabaseMissing('flags', [
            'id' => $flag->id
        ]);
    }
}