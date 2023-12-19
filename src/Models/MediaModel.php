<?php

namespace Models;

class MediaModel {
    public ?MediaElementModel $thumbnail = null;
    public ?MediaElementModel $mainImage = null;
    public ?MediaElementModel $video = null;
    public array $secondaryImages = array();

    public static function convertToModel(?string $media): ?MediaModel {
        if(is_null($media)) return null;

        $deserializedJson = json_decode($media);

        $model = new MediaModel();

        if(!is_null($deserializedJson->thumbnail)) {
            $model->thumbnail = new MediaElementModel($deserializedJson->thumbnail->title, $deserializedJson->thumbnail->url);
        }

        if(!is_null($deserializedJson->mainImage)) {
            $model->mainImage = new MediaElementModel($deserializedJson->mainImage->title, $deserializedJson->mainImage->url);
        }

        if(!is_null($deserializedJson->video)) {
            $model->video = new MediaElementModel($deserializedJson->video->title, $deserializedJson->video->url);
        }

        $model->secondaryImages[] = $model->mainImage;

        foreach($deserializedJson->secondaryImages as $secondaryImage) {
            $model->secondaryImages[] = new MediaElementModel($secondaryImage->title, $secondaryImage->url);
        }

        return $model;
    }
}