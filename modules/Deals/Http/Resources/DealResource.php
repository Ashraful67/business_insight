<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Deals\Http\Resources;

use App\Http\Resources\ProvidesCommonData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Activities\Http\Resources\ActivityResource;
use Modules\Calls\Http\Resources\CallResource;
use Modules\Core\Http\Resources\ChangelogResource;
use Modules\Core\Http\Resources\MediaResource;
use Modules\Core\Resource\Http\JsonResource;
use Modules\Deals\Enums\DealStatus;
use Modules\MailClient\Http\Resources\EmailAccountMessageResource;
use Modules\Notes\Http\Resources\NoteResource;
use Modules\Comments\Models\Comment;

 
/** @mixin \Modules\Deals\Models\Deal */
class DealResource extends JsonResource
{
    use ProvidesCommonData;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Modules\Core\Resource\Http\ResourceRequest  $request
     */
    public function toArray(Request $request): array
    {
        ChangelogResource::topLevelResource($this->resource);

        $activity_id = DB::table('activityables')
        ->where('activityable_id', $this->resource->id)
        ->get()
        ->pluck('activity_id');

        $commnd_activity = Comment::whereIn('commentable_id',$activity_id)->where('commentable_type','Modules\Activities\Models\Activity')->get();

        $positive=$commnd_activity->where('sentiment','positive')->count();
        $nagative=$commnd_activity->where('sentiment','negative')->count();

        // $positive_v=($positive/($positive+$nagative))*100;
        // $nagative_v=($nagative/($positive+$nagative))*100;
        
        $positive_v = 0;
        $negative_v = 0;
        $sum = $positive + $nagative;
        

        if ($sum != 0) {
            $positive_v = ($positive / $sum) * 100;
            $negative_v = ($nagative / $sum) * 100;
        }
       
        $sentiment=array(
            'positive' => number_format($positive_v,2),
            'nagative' => number_format($negative_v,2) 
        );
        
    //[number_format($positive_v,2),number_format($nagative_v,2)]
        return $this->withCommonData([

            'sentiment' => $sentiment,
            'notes_count' => $this->whenCounted('notes', fn () => (int) $this->notes_count),
            'calls_count' => $this->whenCounted('calls', fn () => (int) $this->calls_count),

            $this->mergeWhen($this->status === DealStatus::lost, [
                'lost_reason' => $this->lost_reason,
                'lost_date' => $this->lost_date,
            ]),

            $this->mergeWhen($this->status === DealStatus::won, [
                'won_date' => $this->won_date,
            ]),

            'stage_changed_date' => $this->stage_changed_date,

            $this->mergeWhen(! is_null($this->expected_close_date) && ! $request->isZapier(), [
                'falls_behind_expected_close_date' => $this->fallsBehindExpectedCloseDate,
            ]),

            $this->mergeWhen(! $request->isZapier() && $this->userCanViewCurrentResource(), [
                'board_order' => $this->board_order,
                'time_in_stages' => $this->whenLoaded('stagesHistory', function () {
                    return $this->timeInStages();
                }),
                'changelog' => ChangelogResource::collection($this->whenLoaded('changelog')),
                'notes' => NoteResource::collection($this->whenLoaded('notes')),
                'calls' => CallResource::collection($this->whenLoaded('calls')),
                'activities' => ActivityResource::collection($this->whenLoaded('activities')),
                'media' => MediaResource::collection($this->whenLoaded('media')),
                'emails' => EmailAccountMessageResource::collection($this->whenLoaded('emails')),
            ]),
        ], $request);
    }
}
?>