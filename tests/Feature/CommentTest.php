<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateComment(): void
    {
        $comment = new Comment();
        $comment->email = 'daud28ramadhan@gmail.com';
        $comment->title = 'Test Comment';
        $comment->comment = 'This is a test comment';
        $comment->save();
        self::assertNotNull($comment->id, 'Comment id should not be null');
    }
    public function testCommentDefaultAttribute()
    {
        $comment = new Comment();
        $comment->email = 'daud28ramadhan@gmail.com';
        $comment->save();
        self::assertEquals('sample comment', $comment->comment );
        self::assertEquals('sample title', $comment->title );
    }

}
