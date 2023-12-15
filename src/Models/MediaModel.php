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
        $model->thumbnail = new MediaElementModel($deserializedJson->thumbnail->title, $deserializedJson->thumbnail->url);
        $model->mainImage = new MediaElementModel($deserializedJson->mainImage->title, $deserializedJson->mainImage->url);
        $model->video = new MediaElementModel($deserializedJson->video->title, $deserializedJson->video->url);

        foreach($deserializedJson->secondaryImages as $secondaryImage) {
            array_push($model->secondaryImages, new MediaElementModel($secondaryImage->title, $secondaryImage->url));
        }

        return $model;
    }
}