<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secret;
use Illuminate\Support\Facades\Mail;
use App\Mail\SecretCreated;
use Illuminate\Http\JsonResponse;


class SecretController extends Controller
{
    /**
     * Store a new secret.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'content' => 'required|string',
            'passphrase' => 'required|string',
            'lifetime' => 'required|integer|min:300|max:604800',
            'email' => 'nullable|email',
        ]);

        $randomUrl = $this->generateUniqueUrl();

        $secret = Secret::createSecret($validatedData, $randomUrl);

        $this->sendEmailIfProvided($validatedData, $secret);
        

        return response()->json(['url' => $randomUrl], 201);
    }
    /**
     * Display the secret associated with the given URL.
     *
     * @param string $url The URL of the secret to display
     * @return \Illuminate\Contracts\View\View The view displaying the secret
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If the secret with the given URL is not found
     */
    public function show($url)
    {
        $secret = Secret::findByUrlOrFail($url);

        return view('show', compact('secret'));
    }

    /**
     * Update the "read" status of the secret with the given URL.
     *
     * @param  \Illuminate\Http\Request  $request The request containing the passphrase
     * @param  string  $url The URL of the secret
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $url): JsonResponse
    {
        $passphrase = $request->input('passphrase');
        $result = Secret::updateReadStatus($url, $passphrase);

        return response()->json($result, 200);
    }

    /**
     * Generate a unique URL.
     *
     * @param int $length The length of the generated URL
     * @return string The unique URL
     */
    protected function generateUniqueUrl(int $length = 20): string
    {
        return substr(sha1(uniqid((string)random_int(1, PHP_INT_MAX), true)), 0, $length);
    }

    /**
     * Send email if email is provided.
     *
     * @param  array  $validatedData
     * @param  Secret  $secret
     * @return void
     */
    protected function sendEmailIfProvided(array $validatedData, Secret $secret)
    {
        if ($validatedData['email']) {
            Mail::to($validatedData['email'])->send(new SecretCreated($secret));
        }
    }
}

