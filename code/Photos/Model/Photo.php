<?php
namespace Photos\Model;

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
    public function readData($pathToPhoto)
    {
        if (!is_file($pathToPhoto)) {
            return array();
        }

        return exif_read_data($pathToPhoto);
    }
}
