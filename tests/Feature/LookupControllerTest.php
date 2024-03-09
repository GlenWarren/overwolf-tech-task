<?php declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LookupControllerTest extends TestCase
{
    const LOOKUP_URL = 'lookup';

    public function test_lookup(): void
    {
        $response = $this->getJson(self::LOOKUP_URL);

        $response->assertStatus(200);
    }

    public function test_lookup_minecraft_username(): void
    {
        $response = $this->getJson(self::LOOKUP_URL . '?type=minecraft&username=notch');

        $response->assertStatus(200);

        $expected_response = [
            'username' => "Notch",
            'id' => "069a79f444e94726a5befca90e38aaf5",
            'avatar' => "https://crafatar.com/avatars069a79f444e94726a5befca90e38aaf5"
        ];

        foreach(['username', 'id', 'avatar'] as $key) {
            $this->assertEquals($expected_response[$key], $response[$key], "Unexpected $key returned");
        }
    }

    public function test_lookup_minecraft_id(): void
    {
        $response = $this->getJson(self::LOOKUP_URL . '?type=minecraft&id=d8d5a9237b2043d8883b1150148d6955');

        $response->assertStatus(200);

        $expected_response = [
            'username' => "Test",
            'id' => "d8d5a9237b2043d8883b1150148d6955",
            'avatar' => "https://crafatar.com/avatarsd8d5a9237b2043d8883b1150148d6955"
        ];

        foreach(['username', 'id', 'avatar'] as $key) {
            $this->assertEquals($expected_response[$key], $response[$key], "Unexpected $key returned");
        }
    }

    // public function test_lookup_steam_username(): void
    // {
    //     $response = $this->getJson(self::LOOKUP_URL . '?type=steam&username=test');

    //     $response->assertStatus(200);

    //     $expected_response = 'Steam only supports IDs';

    //     // Should return an error "Steam only supports IDs"

    //     // foreach(['username', 'id', 'avatar'] as $key) {
    //     //     $this->assertEquals($expected_response[$key], $response[$key], "Unexpected $key returned");
    //     // }
    // }

    public function test_lookup_steam_id(): void
    {
        $response = $this->getJson(self::LOOKUP_URL . '?type=steam&id=76561198806141009');

        $response->assertStatus(200);

        $expected_response = [
            'username' => "Tebex",
            'id' => "76561198806141009",
            'avatar' => "https://avatars.steamstatic.com/c86f94b0515600e8f6ff869d13394e05cfa0cd6a.jpg"
        ];

        foreach(['username', 'id', 'avatar'] as $key) {
            $this->assertEquals($expected_response[$key], $response[$key], "Unexpected $key returned");
        }
    }

    public function test_lookup_xbl_username(): void
    {
        $response = $this->getJson(self::LOOKUP_URL . '?type=xbl&username=tebex');

        $response->assertStatus(200);

        $expected_response = [
            'username' => "Tebex",
            'id' => "2533274844413377",
            'avatar' => "https://avatar-ssl.xboxlive.com/avatar/2533274844413377/avatarpic-l.png"
        ];

        foreach(['username', 'id', 'avatar'] as $key) {
            $this->assertEquals($expected_response[$key], $response[$key], "Unexpected $key returned");
        }
    }

    public function test_lookup_xbl_id(): void
    {
        $response = $this->getJson(self::LOOKUP_URL . '?type=xbl&id=2533274884045330');

        $response->assertStatus(200);

        $expected_response = [
            'username' => "d34dmanwalkin",
            'id' => "2533274884045330",
            'avatar' => "https://avatar-ssl.xboxlive.com/avatar/2533274884045330/avatarpic-l.png"
        ];

        foreach(['username', 'id', 'avatar'] as $key) {
            $this->assertEquals($expected_response[$key], $response[$key], "Unexpected $key returned");
        }
    }
}
