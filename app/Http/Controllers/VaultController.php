<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class VaultController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function store(Request $request): Response
    {
        $max = config('vault.max_size');
        $minutes = implode(',', array_keys(config('vault.minutes')));

        $validated = $request->validate([
            'text' => "required|max:{$max}",
            'expire' => "required|in:{$minutes}",
        ], [
            'text.required' => 'Enter some text to encrypt',
            'expire.required' => 'Select an expiry time',
        ]);

        // We're going to encrypt again as a second line of defence should
        // there be a vulnerability with the JS encryption lib.
        $text = Crypt::encrypt($validated['text']);

        // Create a key for the text.
        $key = md5($text);

        // Save the text using Laravel's cache. The TTL is in seconds since
        // Laravel 5.8, so convert the selected minutes explicitly.
        Cache::put($key, $text, now()->addMinutes((int) $validated['expire']));

        // Return the generated URL
        return response(url("view/{$key}"), 200);
    }

    public function show(string $key): View|RedirectResponse
    {
        if (Cache::has($key)) {
            // Get text and decrypt our encryption
            $text = Crypt::decrypt(Cache::get($key));

            return view('view')->with('encrypted_text', $text);
        }

        return redirect('/expired');
    }
}
