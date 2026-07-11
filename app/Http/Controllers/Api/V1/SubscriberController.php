<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $subscriber = Subscriber::where('email', $request->email)->first();

        if ($subscriber) {
            if (!$subscriber->is_active) {
                $subscriber->update(['is_active' => true, 'unsubscribed_at' => null]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'You have been successfully resubscribed.'
                ], 200);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'You are already subscribed.'
            ], 200);
        }

        Subscriber::create([
            'email' => $request->email,
            'is_active' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for subscribing to our newsletter.'
        ], 201);
    }
}
