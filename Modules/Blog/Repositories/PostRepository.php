<?php


namespace Modules\Blog\Repositories;


use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use Modules\Blog\Entities\Post;
use Modules\Blog\Http\Requests\PostCreateRequest;
use Modules\Blog\Http\Requests\PostUpdateRequest;
use Modules\Blog\Transformers\PostTransformer;

class PostRepository
{
    /**
     * @var Manager
     */
    private $fractal;

    /**
     * @var PostTransformer
     */
    private $postTransformer;

    public function __construct()
    {
        $this->fractal = new Manager();
        $this->postTransformer = new PostTransformer();
    }

    /**
     * Returns all posts from database and cuts the content to 200 characters length
     * @return string
     */
    public function all()
    {
        $postsPaginator = Post::orderBy('created_at', 'DESC')->paginate();

        foreach($postsPaginator->items() as $item) {
            $item['content'] = substr($item['content'],0, 200);
        };

        $posts = new Collection($postsPaginator->items(), $this->postTransformer);
        $posts->setPaginator(new IlluminatePaginatorAdapter($postsPaginator));

        return $this->fractal->createData($posts)->toJson();
    }

    /**
     * Stores a post in a database
     * @param PostCreateRequest $request
     * @return string
     */
    public function create(PostCreateRequest $request)
    {
        $post = Post::create($request->only('title', 'content') + [
//            'user_id' => $request->user()->id
                'user_id' => 1
            ]);

        $resource = new Collection(array($post), $this->postTransformer);
        return $this->fractal->createData($resource)->toJson();
    }

    /**
     * Finds a post in database and returns it
     * @param $id
     * @return string
     */
    public function find($id)
    {
        $post = Post::find($id);

        $resource = new Collection(array($post), $this->postTransformer);
        return $this->fractal->createData($resource)->toJson();
    }

    /**
     * Findt a post in database and updates it
     * @param PostUpdateRequest $request
     * @param $id
     * @return string
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::find($id);

        $post->update($request->only('title', 'content') + [
//                'user_id' => $request->user()->id
                'user_id' => 1
            ]);

        $resource = new Collection(array($post), $this->postTransformer);
        return $this->fractal->createData($resource)->toJson();
    }

    /**
     * Deletes a post from database
     * @param $id
     */
    public function delete($id)
    {
        Post::destroy($id);
    }
}
