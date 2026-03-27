<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AggregatorController extends Controller
{
    public function index()
    {
        $articles = Cache::remember('wired_articles', 3600, function () {
            return $this->scrapeWired();
        });

        return view('aggregator', compact('articles'));
    }

    public function refresh()
    {
        Cache::forget('wired_articles');
        return redirect()->route('home')->with('message', 'Feed refreshed!');
    }

    private function scrapeWired(): array
    {
        $articles = [];
        $cutoffDate = Carbon::create(2022, 1, 1);

        try {
            $response = Http::timeout(15)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (compatible; TitleAggregator/1.0)'])
                ->get('https://www.wired.com/feed/rss');

            if ($response->failed()) {
                return [];
            }

            $xml = simplexml_load_string($response->body());
            if (!$xml) {
                return [];
            }

            foreach ($xml->channel->item as $item) {
                $pubDate = Carbon::parse((string) $item->pubDate);

                if ($pubDate->lt($cutoffDate)) {
                    continue;
                }

                $articles[] = [
                    'title'     => (string) $item->title,
                    'url'       => (string) $item->link,
                    'date'      => $pubDate,
                    'date_str'  => $pubDate->format('M d, Y'),
                    'timestamp' => $pubDate->timestamp,
                ];
            }

            usort($articles, fn($a, $b) => $b['timestamp'] - $a['timestamp']);

        } catch (\Exception $e) {
            \Log::error('Wired scrape failed: ' . $e->getMessage());
            return [];
        }

        return $articles;
    }
}