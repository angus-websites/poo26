<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;

class LinkResolverController extends Controller
{
    public function resolve(Link $link): RedirectResponse
    {
        if (!$link->is_active) {
            abort(404);
        }

        if ($link->expires_at && $link->expires_at->isPast()) {
            abort(410); // Gone
        }

        // Track analytics
        $link->increment('clicks');
        $link->update(['last_accessed' => Carbon::now()]);

        return redirect()->to($link->original_url);
    }
}
