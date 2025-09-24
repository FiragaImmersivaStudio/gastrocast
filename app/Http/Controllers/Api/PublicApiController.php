<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PublicApiController extends Controller
{
    /**
     * Send demo request email
     */
    public function sendDemoRequest(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'company' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'restaurant_type' => 'nullable|string|max:100',
                'locations' => 'nullable|string|max:10',
                'message' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Log the demo request
            Log::info('Demo request received', $data);

            // Send email to admin/sales team
            try {
                Mail::send('emails.demo-request', ['data' => $data], function ($message) use ($data) {
                    $message->to(config('mail.admin_email', 'sales@custicast.com'))
                           ->subject('New Demo Request from ' . $data['company'])
                           ->replyTo($data['email'], $data['full_name']);
                });

                // Send confirmation email to requester
                Mail::send('emails.demo-request-confirmation', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'], $data['full_name'])
                           ->subject('Demo Request Received - CustiCast');
                });

            } catch (\Exception $e) {
                Log::error('Failed to send demo request email: ' . $e->getMessage());
                // Continue execution - don't fail the API call just because email failed
            }

            return response()->json([
                'success' => true,
                'message' => 'Demo request sent successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Demo request error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request'
            ], 500);
        }
    }

    /**
     * Send contact message email
     */
    public function sendContactMessage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'company' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'inquiry_type' => 'nullable|string|max:100',
                'message' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();

            // Log the contact message
            Log::info('Contact message received', $data);

            // Send email to admin/sales team
            try {
                Mail::send('emails.contact-message', ['data' => $data], function ($message) use ($data) {
                    $message->to(config('mail.admin_email', 'sales@custicast.com'))
                           ->subject('New Contact Message from ' . $data['company'])
                           ->replyTo($data['email'], $data['full_name']);
                });

                // Send confirmation email to sender
                Mail::send('emails.contact-confirmation', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'], $data['full_name'])
                           ->subject('Message Received - CustiCast Sales Team');
                });

            } catch (\Exception $e) {
                Log::error('Failed to send contact message email: ' . $e->getMessage());
                // Continue execution - don't fail the API call just because email failed
            }

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Contact message error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your message'
            ], 500);
        }
    }
}