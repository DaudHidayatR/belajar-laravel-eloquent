<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testFactory(): void
    {
        $employee1 = Employee::factory()->programmer()->make();
        $employee1->id = '1';
        $employee1->name = 'Daud';
        $employee1->save();
        self::assertEquals('1', $employee1->id);
        self::assertEquals('Daud', $employee1->name);

        $employee2 = Employee::factory()->seniorProgrammer()->create([
            'id' => '2',
            'name' => 'hidayat',
        ]);
        self::assertEquals('2', $employee2->id);
        self::assertEquals('hidayat', $employee2->name);
    }
}
