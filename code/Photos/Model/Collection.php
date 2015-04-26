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
        $pathToCollection = trim($pathToCollection, '/');
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
        $photoModel = $this->getPhotoModel();

        foreach ($data as $key => $value) {
            if (strrpos($key, 'img-', -strlen($key)) !== false) {
                $data[$key] = $photoModel->getPathToThumbnail($pathToCollection . '/' . $data[$key]);
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
        $pathToConfig = $pathToCollection . '/collection.yaml';
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
