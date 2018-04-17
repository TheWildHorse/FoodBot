<?php


namespace App\Services;


/**
 * Class GiphyService
 * @package App\Services
 */
class GiphyService
{

    /**
     * @param $tag
     * @return string
     */
    public function getRandomGifForTag($tag) {
        $metadata = file_get_contents('http://api.giphy.com/v1/gifs/random?tag='.$tag.'&api_key=h4ncpmawlTfcIIsp3cZrJbNyvRl8NZLC');
        $metadata = json_decode($metadata);

        return $metadata->data->image_url;
    }

}