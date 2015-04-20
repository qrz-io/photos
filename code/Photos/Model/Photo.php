<?php
namespace Photos\Model;

use \Eventviva\ImageResize;

class Photo
{

    /**
     * Returns metadata. Parameters available are:
     * FileName
     * FileDateTime
     * FileSize
     * FileType
     * MimeType
     * SectionsFound
     * Make
     * Model
     * Orientation
     * XResolution
     * YResolution
     * ResolutionUnit
     * Software
     * DateTime
     * YCbCrPositioning
     * Exif_IFD_Pointer
     * GPS_IFD_Pointer
     * ExposureTime
     * FNumber
     * ExposureProgram
     * ISOSpeedRatings
     * ExifVersion
     * DateTimeOriginal
     * DateTimeDigitized
     * ComponentsConfiguration
     * CompressedBitsPerPixel
     * ExposureBiasValue
     * MaxApertureValue
     * MeteringMode
     * LightSource
     * Flash
     * FocalLength
     * MakerNote
     * UserComment
     * SubSecTime
     * SubSecTimeOriginal
     * SubSecTimeDigitized
     * FlashPixVersion
     * ColorSpace
     * ExifImageWidth
     * ExifImageLength
     * InteroperabilityOffset
     * SensingMethod
     * FileSource
     * SceneType
     * CFAPattern
     * CustomRendered
     * ExposureMode
     * WhiteBalance
     * DigitalZoomRatio
     * FocalLengthIn35mmFilm
     * SceneCaptureType
     * GainControl
     * Contrast
     * Saturation
     * Sharpness
     * SubjectDistanceRange
     * GPSVersion
     * InterOperabilityIndex
     * InterOperabilityVersion
     *
     * @param string $pathToPhoto
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getData($pathToPhoto)
    {
        if (!is_file($pathToPhoto)) {
            return array();
        }

        $photoData = exif_read_data($pathToPhoto);
        $photoData['Thumbnail'] = $this->getPathToThumbnail($pathToPhoto);

        return $photoData;
    }

    /**
     * @param string $pathToPhoto
     * @return string
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getPathToThumbnail($pathToPhoto)
    {
        $thumbDirectory = pathinfo($pathToPhoto, PATHINFO_DIRNAME) . '/.thumb/';
        $pathToThumb =  $thumbDirectory . pathinfo($pathToPhoto, PATHINFO_BASENAME);

        if (!file_exists($pathToThumb)) {
            if (!is_dir($thumbDirectory)) {
                mkdir($thumbDirectory, 0777, true);
            }

            $this->resizeImage($pathToPhoto, $pathToThumb);
        }

        return $pathToThumb;
    }

    /**
     * @param $pathToImage
     * @param $pathToSave
     * @return Photo
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function resizeImage($pathToImage, $pathToSave)
    {
        $image = new ImageResize($pathToImage);
        $image->resizeToWidth(300);
        $image->save($pathToSave);

        return $this;
    }
}
