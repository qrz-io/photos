<?php
namespace Photos\Model;

class Photos
{

    /** @var array */
    protected $imageExtensions = array(
        'jpg',
        'jpeg',
        'png',
    );

    /**
     * @param string $pathToCollection
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getCollectionPhotos($pathToCollection)
    {
        $files = scandir($pathToCollection);
        $data = array();
        $photoModel = $this->getPhotoModel();

        foreach ($files as $file) {
            if (!$this->isPhoto($file)) {
                continue;
            }

            $data[] = $photoModel->getData($pathToCollection . '/' . $file);
        }

        return $data;
    }

    /**
     * @param string $pathToFile
     * @return bool
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function isPhoto($pathToFile)
    {
        return in_array(pathinfo($pathToFile, PATHINFO_EXTENSION), $this->imageExtensions);
    }

    /**
     * @return \Photos\Model\Photo
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getPhotoModel()
    {
        return new Photo;
    }
}
