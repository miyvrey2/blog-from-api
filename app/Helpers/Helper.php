<?php

if(!function_exists('get_snippet'))
{
    function get_snippet( $str, $wordCount = 10 ): string
    {
        $snippet = implode(
            '',
            array_slice(
                preg_split(
                    '/([\s,\.;\?\!]+)/',
                    $str,
                    $wordCount*2+1,
                    PREG_SPLIT_DELIM_CAPTURE
                ),
                0,
                $wordCount*2-1
            )
        );

        return $snippet . (($str !== $snippet) ? '...' : '');
    }
}

if (! function_exists('css_version'))
{
    function css_version(string $path): string
    {
        $fullPath = public_path($path);

        if (! file_exists($fullPath)) {
            return asset($path);
        }

        return asset($path) . '?v=' . filemtime($fullPath);
    }
}
