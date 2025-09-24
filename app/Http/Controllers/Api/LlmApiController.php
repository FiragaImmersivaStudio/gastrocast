<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LlmSummary;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LlmApiController extends Controller
{
    protected $groqService;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    /**
     * Generate or refresh LLM summary for dashboard
     */
    public function generateSummary(Request $request)
    {
        $request->validate([
            'context' => 'required|in:overview,forecast,inventory,staffing,promo,whatif,menu',
            'restaurant_id' => 'nullable|exists:restaurants,id',
            'force_refresh' => 'boolean',
        ]);

        $restaurantId = $request->restaurant_id ?: session('selected_restaurant_id');
        $context = $request->context;
        $forceRefresh = $request->boolean('force_refresh', false);

        // Check if we need to use cached summary
        if (!$forceRefresh) {
            $cachedSummary = LlmSummary::getLatestForContext($restaurantId, $context);
            
            // Use cached if less than 1 hour old
            if ($cachedSummary && $cachedSummary->created_at->diffInHours(now()) < 1) {
                return response()->json([
                    'data' => [
                        'response' => $cachedSummary->response,
                        'action_items' => $cachedSummary->action_items,
                        'cached' => true,
                        'generated_at' => $cachedSummary->created_at,
                    ],
                    'message' => 'Summary retrieved from cache'
                ]);
            }
        }

        // Generate new summary
        $kpiData = $this->getKpiData($restaurantId);
        $prompt = $this->groqService->generateOverviewPrompt($kpiData, $restaurantId);
        
        $result = $this->groqService->generateSummary($prompt);

        if (!$result['success']) {
            return response()->json([
                'message' => 'Failed to generate summary: ' . $result['error']
            ], 500);
        }

        // Save to database
        $summary = LlmSummary::create([
            'restaurant_id' => $restaurantId,
            'context' => $context,
            'prompt' => $prompt,
            'response' => $result['response'],
            'action_items' => $result['action_items'],
            'model_used' => $result['model_used'],
            'tokens_used' => $result['tokens_used'],
            'processing_time_ms' => $result['processing_time_ms'],
        ]);

        return response()->json([
            'data' => [
                'response' => $summary->response,
                'action_items' => $summary->action_items,
                'cached' => false,
                'generated_at' => $summary->created_at,
                'tokens_used' => $summary->tokens_used,
                'processing_time_ms' => $summary->processing_time_ms,
            ],
            'message' => 'Summary generated successfully'
        ]);
    }

    /**
     * Get the latest summary for a context
     */
    public function getLatestSummary(Request $request)
    {
        $request->validate([
            'context' => 'required|in:overview,forecast,inventory,staffing,promo,whatif,menu',
            'restaurant_id' => 'nullable|exists:restaurants,id',
        ]);

        $restaurantId = $request->restaurant_id ?: session('selected_restaurant_id');
        $context = $request->context;

        $summary = LlmSummary::getLatestForContext($restaurantId, $context);

        if (!$summary) {
            return response()->json([
                'message' => 'No summary found for this context'
            ], 404);
        }

        return response()->json([
            'data' => [
                'response' => $summary->response,
                'action_items' => $summary->action_items,
                'generated_at' => $summary->created_at,
                'tokens_used' => $summary->tokens_used,
                'processing_time_ms' => $summary->processing_time_ms,
            ],
            'message' => 'Summary retrieved successfully'
        ]);
    }

    /**
     * Get mock KPI data for generating summaries
     */
    private function getKpiData(?int $restaurantId): array
    {
        // In a real application, this would fetch actual KPI data from the database
        // For now, return mock data based on what's in the dashboard
        return [
            'visitors' => 1247,
            'visitors_change' => 12.5,
            'transactions' => 892,
            'transactions_change' => 8.3,
            'gmv' => 18542,
            'gmv_change' => 15.7,
            'conversion_rate' => 71.5,
            'conversion_change' => -2.1,
            'aov' => 20.79,
            'aov_change' => 6.8,
            'mape' => 8.2,
            'mape_change' => -1.3,
        ];
    }
}
