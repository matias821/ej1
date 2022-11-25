<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Services\Api\CommentService;
use App\http\Resources\CommentResource;
use Illuminate\Http\Request;
//use App\Models\Comentarios;
//use App\Models\Cotizacion;
//use DB;
use Exception;
class CommentController extends Controller
{
    private $commentService;

    public function __construct()
    {
        $this->commentService=new CommentService;
    }

    public function index(CommentRequest $request)
    {
        return new CommentResource($this->commentService->index($request));
    }

    public function store(CommentRequest $request)
    {
        return new CommentResource($this->commentService->store($request));
    }

    public function show(CommentRequest $request, $id)
    {
        return new CommentResource($this->commentService->show($id));
    }

    public function update(CommentRequest $request, $id)
    {
        return new CommentResource($this->commentService->update($request,$id));
    }

    public function destroy(CommentRequest $request, $id)
    {
        return new CommentResource($this->commentService->Destroy($request));
    }
}
