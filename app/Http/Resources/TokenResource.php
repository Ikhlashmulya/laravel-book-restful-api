<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class TokenResource extends JsonResource
{
    public function __construct(private string $token)
    {
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "access_token" => $this->token,
            "token_type" => "Bearer",
            "user" => Auth::user()
        ];
    }
}
