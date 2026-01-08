<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\RedirectResponse;

class LinkResolverController extends Controller
{
    public function __construct(
        protected LinkService $linkService
    ) {}

    /**
     * Resolve a link and redirect to its target URL
     */
    public function resolve(Link $link): RedirectResponse
    {
        $targetUrl = $this->linkService->resolve($link);

        return redirect()->to($targetUrl);
    }
}
