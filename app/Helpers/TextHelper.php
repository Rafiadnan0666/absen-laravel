<?php

namespace App\Helpers;

class TextHelper
{
    const MEDIA_EXTENSIONS = [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp', 'ico'],
        'audio' => ['mp3', 'wav', 'ogg', 'aac', 'flac', 'wma', 'm4a'],
        'video' => ['mp4', 'webm', 'avi', 'mov', 'mkv', 'flv', 'wmv'],
        'document' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv'],
        'archive' => ['zip', 'rar', 'tar', 'gz', '7z'],
    ];

    public static function detectLinkType(string $url): ?string
    {
        $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));

        foreach (self::MEDIA_EXTENSIONS as $type => $extensions) {
            if (in_array($ext, $extensions)) {
                return $type;
            }
        }

        return null;
    }

    public static function getLinkIcon(string $type): string
    {
        return match ($type) {
            'image' => 'fa-file-image',
            'audio' => 'fa-file-audio',
            'video' => 'fa-file-video',
            'document' => 'fa-file-alt',
            'archive' => 'fa-file-archive',
            default => 'fa-link',
        };
    }

    public static function getLinkColor(string $type): string
    {
        return match ($type) {
            'image' => 'text-purple-500',
            'audio' => 'text-green-500',
            'video' => 'text-blue-500',
            'document' => 'text-orange-500',
            'archive' => 'text-red-500',
            default => 'text-slate-500',
        };
    }

    public static function renderLinks(string $content): string
    {
        $pattern = '/https?:\/\/[^\s<>"]+/i';

        $parts = preg_split($pattern, $content);
        preg_match_all($pattern, $content, $matches);
        $urls = $matches[0] ?? [];

        $result = '';
        foreach ($parts as $i => $part) {
            $result .= e($part);
            if (isset($urls[$i])) {
                $result .= self::wrapLink($urls[$i]);
            }
        }

        return $result;
    }

    private static function wrapLink(string $url): string
    {
        $type = self::detectLinkType($url);
        $icon = self::getLinkIcon($type ?? 'link');
        $color = self::getLinkColor($type ?? 'link');
        $typeLabel = $type ? ucfirst($type) : 'Link';

        $displayUrl = e($url);

        if ($type === 'image') {
            return <<<HTML
            <div class="mt-3 mb-2">
                <a href="{$url}" target="_blank" rel="noopener noreferrer" class="block rounded-lg overflow-hidden border border-slate-200 hover:shadow-md transition-shadow">
                    <img src="{$url}" alt="Image" class="max-h-80 w-auto object-contain mx-auto" loading="lazy" onerror="this.style.display='none'">
                </a>
            </div>
            HTML;
        }

        return <<<HTML
        <div class="mt-2 mb-2">
            <a href="{$url}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors text-sm {$color}">
                <i class="fas {$icon}"></i>
                <span class="font-medium">{$typeLabel}</span>
                <span class="text-slate-400 truncate max-w-xs">{$displayUrl}</span>
                <i class="fas fa-external-link-alt text-xs text-slate-400"></i>
            </a>
        </div>
        HTML;
    }
}
