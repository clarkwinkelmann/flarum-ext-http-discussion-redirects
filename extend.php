<?php

namespace ClarkWinkelmann\HttpDiscussionRedirects;

use Flarum\Extend;

return [
    (new Extend\Middleware('forum'))
        ->add(RedirectDiscussions::class),
];
