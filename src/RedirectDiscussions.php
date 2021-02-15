<?php

namespace ClarkWinkelmann\HttpDiscussionRedirects;

use Flarum\Discussion\Discussion;
use Flarum\Foundation\Config;
use Flarum\Http\SlugManager;
use Flarum\Http\UrlGenerator;
use Illuminate\Support\Arr;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RedirectDiscussions implements MiddlewareInterface
{
    protected $slugManager;
    protected $config;
    protected $url;

    public function __construct(SlugManager $slugManager, Config $config, UrlGenerator $url)
    {
        $this->slugManager = $slugManager;
        $this->config = $config;
        $this->url = $url;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->getAttribute('routeName') === 'discussion') {
            $parameters = $request->getAttribute('routeParameters');
            $slug = Arr::get($parameters, 'id');

            $slugger = $this->slugManager->forResource(Discussion::class);

            $discussion = $slugger->fromSlug($slug, $request->getAttribute('actor'));

            $canonicalSlug = $slugger->toSlug($discussion);

            if ($slug !== $canonicalSlug) {
                return new RedirectResponse($this->url->to('forum')->route('discussion', [
                        'id' => $canonicalSlug,
                    ] + $parameters), $this->config->inDebugMode() ? 302 : 301);
            }
        }

        return $handler->handle($request);
    }
}
