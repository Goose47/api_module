<?php

namespace Modules\Blog\Transformers;

use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;
use Modules\Blog\Entities\Post;

class PostTransformer extends TransformerAbstract
{
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'user_id' => $post->user_id,
        ];
    }
}
