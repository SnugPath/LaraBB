<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\AssetHandler;

class AssetController extends Controller
{
    private AssetHandler $asset_handler;

    public function __construct(AssetHandler $asset_handler)
    {
        $this->asset_handler = $asset_handler;
    }

    public function getAsset(string $asset_url)
    {
        $asset = $this->asset_handler->getAssetByUrl($asset_url);
        if ($asset) {
            if ($asset['content_type']) {
                return response()->file($asset['path'], ['Content-Type' => $asset['content_type']]);
            } else {
                return response()->file($asset['path']);
            }
        } else {
            return response()->json(['error' => 'Asset not found'], 404);
        }
    }
}
