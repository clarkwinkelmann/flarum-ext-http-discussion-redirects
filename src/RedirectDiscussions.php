<?php

namespace ClarkWinkelmann\HttpDiscussionRedirects;

use Flarum\Discussion\DiscussionRepository;
use Illuminate\Support\Str;
use Laminas\Diactoros\Response\RedirectResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RedirectDiscussions implements MiddlewareInterface
{
    protected $repository;

    public function __construct(DiscussionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();

        if (Str::startsWith($path, '/d/') && preg_match('~/d/(\d+)(?:-[^/]*)?(?:/([^/]*))?~', $path, $matches) === 1) {
            $discussion = $this->repository->findOrFail($matches[1], $request->getAttribute('actor'));

            $canonicalPath = '/d/' . $discussion->id . ($discussion->slug ? '-' . $discussion->slug : '') . (isset($matches[2]) ? '/' . $matches[2] : '');

            if ($request->getUri()->getPath() !== $canonicalPath) {
                return new RedirectResponse($canonicalPath, app()->inDebugMode() ? 302 : 301);
            }
        }

        return $handler->handle($request);
    }
}
