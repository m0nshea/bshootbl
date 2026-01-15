<?php

namespace App\Http\Controllers;

use App\Services\WebhookPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    protected $webhookService;

    public function __construct(WebhookPaymentService $webhookService)
    {
        $this->webhookService = $webhookService;
    }

    /**
     * Handle Midtrans payment notification webhook
     */
    public function midtransNotification(Request $request)
    {
        try {
            Log::info('Midtrans Webhook Received', [
                'payload' => $request->all()
            ]);

            $result = $this->webhookService->handleNotification($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Notification processed successfully'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Midtrans Webhook Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process notification'
            ], 500);
        }
    }
}
