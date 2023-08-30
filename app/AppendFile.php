<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Vimeo\Vimeo;

class AppendFile extends Model
{
    const VIMEO_URL = 'https://player.vimeo.com/video/';
    protected $fillable = ['file_name', 'file_path', 'file_size', 'file_mimetype', 'vimeo_id'];

    public static function getVimeoThumbnailUrl($vimeo_id, $type = 'large')
    {
        //$xml = simplexml_load_file("http://vimeo.com/api/v2/video/{$vimeo_id}.xml");

        $thumbnail_large = array('link'=>null);

        $vimeo = new Vimeo(env('VIMEO_CLIENT_ID'), env('VIMEO_CLIENT_SECRET'), env('VIMEO_ACCESS_TOKEN'));
        $video = $vimeo->request('/videos/' . $vimeo_id);

        if ($video['status'] == '200') {
            $pictures = $video['body']['pictures'];

            if( !empty($pictures['sizes']) ) {
                $thumbnail_large = $pictures['sizes'][3];
            }
        }

        return $thumbnail_large['link'];
    }

    public static function getVimeoUrl($vimeo_id)
    {
        return $vimeo_id;
    }
}
