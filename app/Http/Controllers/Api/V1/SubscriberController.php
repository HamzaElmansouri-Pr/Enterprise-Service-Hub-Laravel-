<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Http\Requests\StoreSubscriberRequest;

class SubscriberController extends Controller
{
    public function subscribe(StoreSubscriberRequest $request)
    {
        // Honeypot check
        if (!empty($request->input('website_url'))) {
            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for subscribing to our newsletter.'
            ], 201);
        }

        $validated = $request->validated();

        $subscriber = Subscriber::where('email', $validated['email'])->first();

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
            'email' => $validated['email'],
            'is_active' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Thank you for subscribing to our newsletter.'
        ], 201);
    }
}
