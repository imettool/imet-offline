<?php

namespace App\Http\Controllers;

use App\Helpers\SoftwareUpdater;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{
    public function index(Request $request)
    {
        $forceApi = $request->input('force_api', false);
        $includeBeta = $request->input('beta', false);

        $release = SoftwareUpdater::getLatestReleases($forceApi, $includeBeta)[0];
        $release_notes = nl2br($release['body']);
        $release_date = Carbon::parse($release['published_at'])->format('Y-m-d');

        $require_installation = $release['require_installation'] ?? false;
        $installer_url = $release['installer_url'] ?? null;

        return view('offline.update.index', [
            'latest_version' => $release['tag_name'],
            'current_version' => SoftwareUpdater::getCurrentVersion(),
            'release_notes' => $release_notes,
            'release_date' => $release_date,
            'download_url' => $release['zipball_url'],
            'require_installation' => $require_installation,
            'installer_url' => $installer_url
        ]);
    }

    public function update(Request $request)
    {
        $download_url = $request->input('download_url');
        $version = $request->input('version');

        $zip_path = storage_path('releases/IMET-' . $version . '.zip');

        // Download the zip file
        try{
            (new Client())->get($download_url, [RequestOptions::SINK => $zip_path]);
            Log::info('Download version ' . $version . ' completed. ('. $download_url. ')');
            return response()->json([
                'status' => 'success',
                'message' => 'Download successful',
                'path' => $zip_path
            ]);
        } catch (GuzzleException $e) {
            Log::error('Download version ' . $version . ' failed. ('. $download_url. ')');
            return response()->json([
                'status' => 'error',
                'message' => 'Download failed',
            ]);
        }

    }


}
