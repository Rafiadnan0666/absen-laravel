<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => config('app.name'),
            'app_url' => config('app.url'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'app_locale' => config('app.locale'),
            'timezone' => config('app.timezone'),
            'db_connection' => config('database.default'),
            'db_database' => config('database.connections.mysql.database'),
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'storage_used' => $this->getStorageUsage(),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function general(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'app_timezone' => 'required|string',
        ]);

        $envContent = File::get(base_path('.env'));
        $envContent = preg_replace('/APP_NAME=.*/', 'APP_NAME=' . $request->app_name, $envContent);
        $envContent = preg_replace('/APP_ENV=.*/', 'APP_ENV=' . ($request->app_mode === 'production' ? 'production' : 'local'), $envContent);
        $envContent = preg_replace('/APP_DEBUG=.*/', 'APP_DEBUG=' . ($request->app_mode === 'production' ? 'false' : 'true'), $envContent);
        
        File::put(base_path('.env'), $envContent);

        return redirect()->route('admin.settings.index')->with('success', 'General settings updated successfully.');
    }

    public function clearCache()
    {
        try {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            
            return redirect()->route('admin.settings.index')->with('success', 'System cache cleared successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }

    private function getStorageUsage()
    {
        $bytes = 0;
        $path = storage_path('app');
        
        if (is_dir($path)) {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS)
            );
            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $bytes += $file->getSize();
                }
            }
        }

        return round($bytes / 1048576, 2);
    }
}
