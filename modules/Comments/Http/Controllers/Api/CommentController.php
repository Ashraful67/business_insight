<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Comments\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Comments\Contracts\HasComments;
use Modules\Comments\Contracts\PipesComments;
use Modules\Comments\Http\Resources\CommentResource;
use Modules\Comments\Models\Comment;
use Modules\Core\Facades\Innoclapps;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Resource\Http\ResourceRequest;
use Modules\Users\Mention\PendingMention;

class CommentController extends ApiController
{
    /**
     * Display the resource comments.
     */
    public function index(ResourceRequest $request): JsonResponse
    {
        \Log::info($request);
        $request->validate([
            'via_resource' => [
                'sometimes',
                'required_with:via_resource_id',
                'string',
                Rule::in(Innoclapps::registeredResources()
                    ->whereInstanceOf(PipesComments::class)
                    ->map(fn ($resource) => $resource->name())->all()),
            ],
            'via_resource_id' => [
                'sometimes',
                'numeric',
                'required_with:via_resource',
                Rule::requiredIf(in_array($request->resource()->name(), ['notes', 'calls'])),
            ],
        ]);

        // When the via_resource is not provided, we will validate the actual resource
        // record, otherwise, we will validate the via_resource record e.q. user can see contact
        // and it's calls and a comment is added to the call
        if (! $request->viaResource()) {
            $this->authorize('view', $request->record());
        } else {
            $this->authorize(
                'view',
                $request->findResource($request->via_resource)->newModel()->find($request->via_resource_id)
            );
        }

        return $this->response(
            CommentResource::collection(
                $request->record()->comments()
                    ->with('creator')
                    ->orderBy('created_at')
                    ->get()
            )
            
        );
    }

    /**
     * Add new resource comment.
     */
    public function store(ResourceRequest $request): JsonResponse
    {
        abort_unless(
            $request->resource() instanceof HasComments,
            404,
            'Comments cannot be added to the provided resource.'
        );

        $input = $request->validate([
            'body' => 'required|string',
            'via_resource' => [
                'sometimes',
                'required_with:via_resource_id',
                'string',
                Rule::in(Innoclapps::registeredResources()
                    ->whereInstanceOf(PipesComments::class)
                    ->map(fn ($resource) => $resource->name())->all()),
            ],
            'via_resource_id' => [
                'sometimes',
                'numeric',
                'required_with:via_resource',
                Rule::requiredIf(in_array($request->resource()->name(), ['notes', 'calls'])),
            ],
        ]);
        // \Log::info($request->via_resource);
        // \Log::info($input);
        // When the via_resource is not provided, we will validate the actual resource
        // record, otherwise, we will validate the via_resource record e.q. user can see contact
        // and it's calls and a comment is added to the call
        if (! $request->viaResource()) {
            $this->authorize('view', $request->record());
        } else {
            $this->authorize(
                'view',
                $request->findResource($request->via_resource)->newModel()->find($request->via_resource_id)
            );
        }
        //Sentiment Analysis API
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.apilayer.com/sentiment/analysis",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: Os8tzjI22lr77LHlgPn9LhkeC1pqEbmF"
          ),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$request->body
        ));
        
        $response = json_decode(curl_exec($curl));
        
        curl_close($curl);
        if ($response->sentiment){
            $input['sentiment']=$response->sentiment;
        }
        else{
            $input['sentiment']='neutral';
        }
        //echo $response;

        \Log::info($input);

        $comment = $request->record()->addComment($input);

        return $this->response(
            new CommentResource($comment),
            201
        );
    }

    /**
     * Display the given comment.
     */
    public function show(string $id): JsonResponse
    {
        $comment = Comment::with('creator')->findOrFail($id);

        $this->authorize('view', $comment);

        return $this->response(new CommentResource($comment));
    }

    /**
     * Update the given comment.
     */
    public function update(string $id, Request $request): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('update', $comment);

        $input = $request->validate([
            'body' => 'required|string',
            'via_resource' => [
                'sometimes',
                'required_with:via_resource_id',
                'string',
                Rule::in(Innoclapps::registeredResources()
                    ->whereInstanceOf(PipesComments::class)
                    ->map(fn ($resource) => $resource->name())->all()),
            ],
            'via_resource_id' => [
                'sometimes',
                'numeric',
                'required_with:via_resource',
                Rule::requiredIf(in_array($comment->commentable->resource()->name(), ['notes', 'calls'])),
            ],
        ]);

        //Sentiment Analysis API
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.apilayer.com/sentiment/analysis",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: Os8tzjI22lr77LHlgPn9LhkeC1pqEbmF"
          ),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$request->body
        ));
        
        $response = json_decode(curl_exec($curl));
        // \Log::info($response);
        \Log::info($request->body);
        curl_close($curl);
        if ($response->sentiment){
            $input['sentiment']=$response->sentiment;
        }
        else{
            $input['sentiment']='neutral';
        }


        $mention = new PendingMention($input['body']);
        $input['body'] = $mention->getUpdatedText();

        $comment->fill($input)->save();

        $comment->notifyMentionedUsers(
            $mention,
            $input['via_resource'] ?? null,
            $input['via_resource_id'] ?? null
        );

        $comment->loadMissing('creator');

        return $this->response(new CommentResource(
            $comment
        ));
    }

    /**
     * Remove the given comment from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('delete', $comment);

        $comment->delete();

        return $this->response('', 204);
    }
}
