<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Follower;
use App\Models\Like;
use App\Models\SaveOffer;
use App\Models\Comment;

class DashboardController extends Controller
{
    /**
     * Display the user's dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $userId = auth()->user()->id;
        $followedStores = Follower::where('user_id', $userId)->get();
        $savedOffers = SaveOffer::where('user_id', $userId)->get();

        return view('user.dashboard', [
            'followedStores' => $followedStores,
            'savedOffers' => $savedOffers
        ]);
    }

    /**
     * Add a user to follow a store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function followStore(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:dn_stores,id',
        ]);

        $userId = auth()->user()->id;
        $existingFollower = Follower::where('store_id', $request->store_id)
            ->where('user_id', $userId)
            ->exists();

        if ($existingFollower) {
            Follower::where('store_id', $request->store_id)
                ->where('user_id', $userId)
                ->delete();

            return response()->json(['unsubscribed' => true]);
        } else {
            Follower::create([
                'store_id' => $request->store_id,
                'user_id' => $userId
            ]);

            return response()->json(['subscribed' => true]);
        }
    }


    /**
     * Like or unlike content.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function likeContent(Request $request)
    {
        $request->validate([
            'content_id' => 'required',
            'content_type' => 'required'
        ]);

        $userId = auth()->user()->id;
        $existingLike = Like::where('content_type', $request->content_type)
            ->where('content_id', $request->content_id)
            ->where('user_id', $userId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['unlike' => true]);
        } else {
            Like::create([
                'content_type' => $request->content_type,
                'content_id' => $request->content_id,
                'user_id' => $userId
            ]);

            return response()->json(['like' => true]);
        }
    }

    /**
     * Save or unsave an offer for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveOffer(Request $request)
    {
        $userId = auth()->user()->id;
        $offerId = $request->offer_id;
        $contentType = $request->content_type;
        $isFeatured = false;

        if ($contentType == 'featured_offer') {
            $isFeatured = true;
        }


        $existingSave = SaveOffer::where('offer_id', $offerId)
            ->where('user_id', $userId)
            ->where('is_featured', $isFeatured)
            ->first();

        if ($existingSave) {
            $existingSave->delete();
            return response()->json(['unsave' => true]);
        } else {
            SaveOffer::create([
                'offer_id' => $offerId,
                'user_id' => $userId,
                'is_featured' => $isFeatured
            ]);

            return response()->json(['save' => true]);
        }
    }


    /**
     * Submit a new comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitComment(Request $request)
    {
        // Validate request data
        $request->validate([
            'comment' => 'required',
            'content_type' => 'required',
            'content_id' => 'required'
        ]);

        // Create new comment
        $comment = new Comment();
        $comment->comment = $request->comment;
        $comment->content_type = $request->content_type;
        $comment->content_id = $request->content_id;
        $comment->user_id = auth()->user()->id;

        $comment->save();

        // Return success response with comment ID
        return response()->json(['success' => true, 'message' => 'Comment posted successfully', 'comment_id' => $comment->id]);
    }

    /**
     * Edit a comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editComment(Request $request)
    {
        // Validate request data
        $request->validate([
            'comment_id' => 'required',
            'comment' => 'required',
        ]);

        $commentId = $request->comment_id;
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
        }

        // Update the comment
        $comment->comment = $request->input('comment');
        $comment->save();

        return response()->json(['success' => true, 'message' => 'Comment updated successfully']);
    }


    /**
     * Delete a comment.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteComment(Request $request)
    {
        $commentId = $request->comment_id;
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Comment not found'], 404);
        }
        $comment->delete();

        return response()->json(['success' => true, 'message' => 'Comment deleted successfully']);
    }
}
