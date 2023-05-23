<?php

namespace App\Seagon\Middleware;

use App\Seagon\Random;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

class Secret
{
    public function __invoke(Request $request, Closure $next)
    {
        $text = trim($request->input('events.0.message.text'));

        if ($this->keyword($text) && Random::threshold(80)) {
            Log::debug('Secret handled');

            return [
                new TextMessageBuilder('秘密')
            ];
        }

        return $next($request);
    }

    /**
     * @param string $text
     * @return bool
     */
    private function keyword(string $text): bool
    {
        return str_contains($text, '師公') && str_contains($text, '投資');
    }
}
