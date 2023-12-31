<?php
/**
 * Deals Analysis
 *
 * @version   1.2.0
 
 * @copyright Copyright (c) 2022-2023
 */

namespace Modules\Comments\Tests\Unit;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Comments\Models\Comment;
use Tests\TestCase;

class CommentModelTest extends TestCase
{
    public function test_comment_has_commentables()
    {
        $comment = new Comment;

        $this->assertInstanceOf(MorphTo::class, $comment->commentable());
    }
}
