<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Services\LinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controller for handling links
 */
class LinkController extends Controller
{
    public function __construct(
        protected LinkService $linkService
    ) {}

    /**
     * Resolve a link and redirect to its target URL
     */
    public function resolve(Link $link): RedirectResponse|View
    {
        $targetUrl = $this->linkService->resolve($link);

        return view('public.links.forward', compact('targetUrl'));

        //return redirect()->to($targetUrl);
    }
}
