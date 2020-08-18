<?php

namespace ClarkWinkelmann\HttpDiscussionRedirects;

use Flarum\Http\UrlGenerator;
use Illuminate\Support\Str;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RedirectDiscussions implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        /**
         * @var $url UrlGenerator
         */
        $url = app(UrlGenerator::class);

        if (Str::startsWith($request->getUri()->getPath(), (new Uri($url->to('forum')->route('discussion', ['id' => ''])))->getPath())) {
            $body = $response->getBody()->getContents();

            // An ideal solution would be to use a content extender,
            // but unfortunately because of https://github.com/flarum/core/issues/2239
            // the content extender can't access $document->canonicalUrl
            if (preg_match('~<link rel="canonical" href="([^"]+)">~', $body, $matches) === 1) {
                $canonicalPath = (new Uri($matches[1]))->getPath();

                if ($request->getUri()->getPath() !== $canonicalPath) {
                    return new RedirectResponse($canonicalPath, app()->inDebugMode() ? 302 : 301);
                }
            }

            $response->getBody()->rewind();
        }

        return $response;
    }
}
