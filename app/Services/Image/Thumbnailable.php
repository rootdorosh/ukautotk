<?php

namespace App\Services\Image;

use App;

trait Thumbnailable
{
    /**
     * Get image thumb
     *
     * @param  string $attribute
     * @param  int $width
     * @param  int $height
     * @param  string $mode
     * @return string|null
     */
    public function getThumb(string $attribute = 'image', int $width = 0, $height = 0, string $mode = 'resize'): ? string
    {
        $uploadPath = '/uploads';
        //$siteUrl = config('app.url');
        $siteUrl = '';
        
        if (!empty($this->$attribute)) {
            $image = $this->$attribute;
            $width = $width === 0 ? $height : $width;
            $height = $height === 0 ? $width : $height;
            
            $expl = explode('.', $image);

            if (end($expl) == 'svg' || (!$width && !$height)) {
                return $siteUrl . $uploadPath . $image;
            }

            $basePath = public_path() . $uploadPath;
            if (!is_file($basePath . $image)) {
                return null;
            }
                
            $pathInfo = pathinfo($basePath . $image);
            
            $pos = strrpos($image, "/");
            $fileMode = $mode == 'resize' ? 'r' : 'c';

            $thumbName = substr($image, 0, $pos) . '/' . $pathInfo['filename'] . '-' .
                $fileMode . '_' . $width . 'x' . $height . '.' . $pathInfo['extension'];
            
            if (!is_file($basePath . $thumbName)) {
                $imageManager = App::make('Intervention\Image\ImageManager');
                
                $thumb = $imageManager->make($basePath . $image);
                
                if ($mode == 'resize') {
                    $thumb->resize($width, $height);
                } else {
                    $thumb->crop($width, $height);
                }
                
                $thumb->save($basePath . $thumbName);
            }
            
            return $siteUrl . $uploadPath . $thumbName;
        }

        return null;
    }
}
