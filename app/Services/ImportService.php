<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImportService
{
    public function import($updateAttributes, $insertAttributes = []): void
    {
        // retrieve the JSON from the URL
        $jsonData = json_decode(file_get_contents($this->url), false);

        // count the amount of imported items
        $imported = 0;

        // Loop through the authors
        foreach($jsonData as $key => $jsonItem) {

            $item = null;

            // Only import the given amount
            if($key === $this->amount) {
                break;
            }

            // Map the items to the attribute values
            $mappedUpdateAttributes = $this->mapAttributeItems($updateAttributes, $jsonItem);
            $mappedInsertAttributes = $this->mapAttributeItems($insertAttributes, $jsonItem);

            if($this->model === 'Author') {
                $item = Author::updateOrCreate($mappedUpdateAttributes, $mappedInsertAttributes);
            } elseif($this->model === 'Post') {
                $mappedInsertAttributes['slug'] = Str::slug($mappedInsertAttributes['slug']);
                $item = Post::updateOrCreate($mappedUpdateAttributes, $mappedInsertAttributes);
            } elseif($this->model === 'Comment') {
                $item = Comment::updateOrCreate($mappedUpdateAttributes, $mappedInsertAttributes);
            }

            // Count the inserted amount of authors
            $imported += $item->wasRecentlyCreated === true ? 1 : 0;
        }

        $updated = min($this->amount, $jsonData) - $imported;

        Log::info("Imported {$imported} {$this->model}, updated {$updated} {$this->model}");
    }

    private function mapAttributeItems($array, $jsonItem): array
    {
        $return = [];

        if($array !== []) {
            foreach($array as $attributeName => $attributeValue) {
                if(strpos($attributeValue, '.') !== false) {
                    $nestedAttributeValue = explode('.', $attributeValue);
                    $nav1 = $nestedAttributeValue[0];
                    $nav2 = $nestedAttributeValue[1];
                    $return[$attributeName] = $jsonItem->$nav1->$nav2;
                } else {
                    $return[$attributeName] = $jsonItem->$attributeValue ?? $jsonItem->$attributeName;
                }
            }
        }

        return $return;
    }

    private function yourThing($string)
    {
        $pieces = explode('.', $string);
        $value = array_pop($pieces);
        $array = [];
        array_set($array, implode('.', $pieces), $value);
        return $array;
    }
}
