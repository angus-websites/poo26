<?php

namespace App\Http\Controllers;

use App\Models\Destination;
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
    public function resolve(Destination $link): RedirectResponse
    {
        $targetUrl = $this->linkService->resolve($link);

        return redirect()->to($targetUrl);
    }
}
