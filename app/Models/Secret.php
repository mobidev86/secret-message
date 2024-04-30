<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'passphrase',
        'expires_at',
        'url',
        'is_read',
        'email',
    ];

    protected $dates = [
        'expires_at',
    ];
    /**
     * Create a new secret with the provided data.
     *
     * @param array $validatedData The validated data for creating the secret
     * @param string $randomUrl The randomly generated URL for the secret
     * @return \App\Models\Secret The created secret instance
     */
    public static function createSecret($validatedData, $randomUrl)
    {
        return self::create([
            'content' => $validatedData['content'],
            'passphrase' => $validatedData['passphrase'],
            'email' => $validatedData['email'],
            'expires_at' => now()->addSeconds($validatedData['lifetime']),
            'url' => $randomUrl,
        ]);
    }
    /**
     * Find a secret by its URL or fail if not found.
     *
     * @param string $url The URL of the secret to find
     * @return \App\Models\Secret The found secret instance
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findByUrlOrFail($url)
    {
        return self::where('url', $url)->firstOrFail();
    }

    /**
     * Update the "read" status of the secret with the given URL.
     *
     * @param  \Illuminate\Http\Request  $request The request containing the passphrase
     * @param  string  $url The URL of the secret
     * @return array
     */

     public static function updateReadStatus($url, $passphrase): array
    {
        $secret = self::where('url', $url)->where('passphrase', $passphrase)->first();

        if ($secret) {
            $secret->is_read = true;
            $secret->save();
            return ['status' => true, 'data' => $secret];
        }

        return ['status' => false, 'message' => 'invalid'];
    }
}
