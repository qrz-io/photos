<?php
namespace Photos\Model;

use \Symfony\Component\Yaml\Yaml;

class Collection
{

    /**
     * @param string $pathToCollection
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getData($pathToCollection)
    {
        $pathToCollection = rtrim($pathToCollection, '/') . '/';
        $data = array();
        $data = array_merge($data, $this->getCollectionData($pathToCollection));

        return $data;
    }

    /**
     * @param string $pathToCollection
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getCollectionData($pathToCollection)
    {
        $data = $this->parseConfig($pathToCollection);

        // no array, fail gracefully
        if (!is_array($data)) {
            return array();
        }

        $photoModel = $this->getPhotoModel();

        foreach ($data as $key => $value) {
            if (strrpos($key, 'img-', -strlen($key)) !== false) {
                $data[$key] = $photoModel->getPathToThumbnail($pathToCollection . $data[$key]);
            }
        }

        return $data;
    }

    /**
     * @param string $pathToCollection
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function parseConfig($pathToCollection)
    {
        $pathToConfig = $pathToCollection . '.collection.yml';
        if (!is_file($pathToConfig)) {
            return array();
        }
        $data = Yaml::parse($pathToConfig);

        return $data;
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
