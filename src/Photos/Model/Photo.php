<?php
namespace Photos\Model;

use \Gumlet\ImageResize;

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

        $photoData = $this->getExifHeaders($pathToPhoto);
        $photoData['Thumbnail'] = $this->getPathToThumbnail($pathToPhoto);
        $photoData['BigImage'] = $this->getPathToBigImage($pathToPhoto);
        $photoData['RealImage'] = pathinfo($pathToPhoto, PATHINFO_BASENAME);

        return $photoData;
    }

    /**
     * @param string $pathToPhoto
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getExifHeaders($pathToPhoto)
    {
        return exif_read_data($pathToPhoto);
    }

    /**
     * @param string $pathToPhoto
     * @return string
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getPathToThumbnail($pathToPhoto)
    {
        return $this->getPathToResizedImage($pathToPhoto, 'thumb/', 360*2, 90);
    }

    /**
     * @param string $pathToPhoto
     * @return string
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getPathToBigImage($pathToPhoto)
    {
        return $this->getPathToResizedImage($pathToPhoto, 'img/', 1024*2, 90);
    }

    /**
     * @param string $pathToPhoto
     * @param string $temporaryFolderName
     * @param int $width
     * @return string
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getPathToResizedImage($pathToPhoto, $temporaryFolderName, $width, $quality = null)
    {
        $thumbDirectory = pathinfo($pathToPhoto, PATHINFO_DIRNAME) . '/' . trim("../" . $temporaryFolderName, '/') . '/';
        $imageName = pathinfo($pathToPhoto, PATHINFO_BASENAME);
        $pathToImg = $thumbDirectory . $imageName;

        if (!file_exists($pathToImg)) {
            $this->resizeImage($pathToPhoto, $pathToImg, $width, $quality);
        }

        return $temporaryFolderName . $imageName;
    }

    /**
     * @param string $pathToImage
     * @param string $pathToSave
     * @param int $width
     * @return Photo
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function resizeImage($pathToImage, $pathToSave, $width, $quality = null)
    {
        try {
            $image = new ImageResize($pathToImage);
            $image->resizeToWidth($width);
            $image->save($pathToSave, null, $quality);
        } catch (\Exception $exception) {
            // Log something here, perhaps?
        }

        return $this;
    }
}
