<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Tests\TestCase;

class VaultTest extends TestCase
{
    public function test_home_page_renders_form_with_expiry_options(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('name="csrf-token"', false)
            ->assertSee('<option value="30">30 Minutes</option>', false);
    }

    public function test_store_validates_input(): void
    {
        $this->withoutMiddleware(ValidateCsrfToken::class)
            ->postJson('/', ['text' => '', 'expire' => '999'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['text', 'expire']);
    }

    public function test_stored_text_can_be_viewed_until_it_expires(): void
    {
        $url = $this->withoutMiddleware(ValidateCsrfToken::class)
            ->post('/', ['text' => 'client-side-ciphertext', 'expire' => '30'])
            ->assertOk()
            ->getContent();

        $path = parse_url($url, PHP_URL_PATH);
        $this->assertMatchesRegularExpression('#^/view/[a-f0-9]{32}$#', $path);

        $this->get($path)->assertOk()->assertSee('client-side-ciphertext');

        // TTL is in minutes, not seconds.
        $this->travel(29)->minutes();
        $this->get($path)->assertOk();

        $this->travel(2)->minutes();
        $this->get($path)->assertRedirect('/expired');
    }

    public function test_unknown_key_redirects_to_expired_page(): void
    {
        $this->get('/view/doesnotexist')->assertRedirect('/expired');
        $this->get('/expired')->assertOk();
    }
}
