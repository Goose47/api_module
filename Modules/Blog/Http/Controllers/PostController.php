<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use Modules\Blog\Entities\Post;
use Modules\Blog\Http\Requests\PostCreateRequest;
use Modules\Blog\Http\Requests\PostUpdateRequest;
use Modules\Blog\Repositories\PostRepository;
use Modules\Blog\Transformers\PostTransformer;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->postRepository->all();

        return response($data, Response::HTTP_OK);
    }

    /**
     * @param PostCreateRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {
        $data = $this->postRepository->create($request);

        return response($data, Response::HTTP_CREATED);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->postRepository->find($id);

        return response($data, Response::HTTP_OK);
    }

    /**
     * @param PostUpdateRequest $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $request, $id)
    {
        $data = $this->postRepository->update($request, $id);

        return response($data, Response::HTTP_ACCEPTED);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->postRepository->delete($id);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
