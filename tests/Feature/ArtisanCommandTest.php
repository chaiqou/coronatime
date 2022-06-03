<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;

class FetchCountriesTest extends TestCase
{
	public function test_if_artisan_command_can_return_data_from_api()
	{
		Http::fake(['https://devtest.ge/countries' => json_decode(file_get_contents('tests/country.json'), true)]);
		Http::fake(['https://devtest.ge/get-country-statistics' => json_decode(file_get_contents('tests/country-statistics.json'))]);
		$this->artisan('synchronize:database')
			->assertSuccessful()
			->assertExitCode(0);
	}
}
