<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqService
{
    private $apiKey;
    private $baseUrl = 'https://api.groq.com/openai/v1';

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key', env('GROQ_API_KEY'));
    }

    /**
     * Generate summary using Groq's Llama model
     */
    public function generateSummary(string $prompt, string $model = 'llama-3.1-70b-versatile'): array
    {
        $startTime = microtime(true);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($this->baseUrl . '/chat/completions', [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an AI assistant for restaurant analytics. Provide concise, actionable insights in Indonesian. Focus on specific recommendations and action items.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'max_tokens' => 1024,
                'temperature' => 0.7,
            ]);

            $processingTime = (microtime(true) - $startTime) * 1000;

            if ($response->successful()) {
                $data = $response->json();
                
                $content = $data['choices'][0]['message']['content'] ?? '';
                $tokensUsed = $data['usage']['total_tokens'] ?? 0;

                // Parse action items from content (look for bullet points)
                $actionItems = $this->extractActionItems($content);

                return [
                    'success' => true,
                    'response' => $content,
                    'action_items' => $actionItems,
                    'tokens_used' => $tokensUsed,
                    'processing_time_ms' => round($processingTime, 2),
                    'model_used' => $model,
                ];
            }

            Log::error('Groq API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return [
                'success' => false,
                'error' => 'API request failed: ' . $response->status(),
                'processing_time_ms' => round($processingTime, 2),
            ];

        } catch (\Exception $e) {
            $processingTime = (microtime(true) - $startTime) * 1000;
            
            Log::error('Groq Service Exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return [
                'success' => false,
                'error' => 'Service error: ' . $e->getMessage(),
                'processing_time_ms' => round($processingTime, 2),
            ];
        }
    }

    /**
     * Extract action items from the response content
     */
    private function extractActionItems(string $content): array
    {
        $actionItems = [];
        
        // Look for lines that start with bullet points or numbers
        $lines = explode("\n", $content);
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (preg_match('/^[\-\*\+•]\s*(.+)$/', $line, $matches)) {
                $actionItems[] = trim($matches[1]);
            } elseif (preg_match('/^\d+\.\s*(.+)$/', $line, $matches)) {
                $actionItems[] = trim($matches[1]);
            }
        }

        return $actionItems;
    }

    /**
     * Generate prompt for dashboard overview
     */
    public function generateOverviewPrompt(array $kpiData, ?int $restaurantId = null): string
    {
        $restaurantContext = $restaurantId ? "Restaurant ID: {$restaurantId}" : "All restaurants";
        
        return "Berdasarkan data KPI berikut untuk {$restaurantContext}:
        
Visitors: {$kpiData['visitors']} ({$kpiData['visitors_change']}%)
Transactions: {$kpiData['transactions']} ({$kpiData['transactions_change']}%)
GMV: \${$kpiData['gmv']} ({$kpiData['gmv_change']}%)
Conversion Rate: {$kpiData['conversion_rate']}% ({$kpiData['conversion_change']}%)
AOV: \${$kpiData['aov']} ({$kpiData['aov_change']}%)
MAPE: {$kpiData['mape']}% ({$kpiData['mape_change']}%)

Analisa performa restoran dan berikan:
1. Executive summary singkat (2-3 kalimat)
2. 3-4 action items yang spesifik dan actionable
3. Fokus pada area yang perlu improvement

Format response dalam bahasa Indonesia yang mudah dipahami oleh pemilik restoran.";
    }
}