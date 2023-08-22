<?php

namespace Tests\Feature\Models;

use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPerson(): void
    {
        $person = new Person();
        $person->first_name = 'Daud';
        $person->last_name = 'Ramadhan';
        $person->save();

        self::assertEquals('DAUD Ramadhan', $person->full_name);

        $person->full_name = 'zahwa amira';
        $person->save();
        self::assertEquals('ZAHWA', $person->first_name);
        self::assertEquals('amira', $person->last_name);
        self::assertEquals('ZAHWA amira', $person->full_name);

    }
    public function testAttributeCasting(): void
    {
        $person = new Person();
        $person->first_name = 'Daud';
        $person->last_name = 'Ramadhan';
        $person->save();
        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);

    }
}
