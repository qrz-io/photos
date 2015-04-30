<?php
namespace Photos\Model;



class Collections
{

    /**
     * @param string $path
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getCollections($path)
    {
        $results = scandir($path);
        $collectionModel = $this->getCollectionModel();
        $photosModel = $this->getPhotosModel();
        $collectionsData = array();

        foreach ($results as $result) {
            if ($result === '.' || $result === '..' || !is_dir($path . '/' . $result)) {
                continue;
            }

            $collectionsData[$path . '/' . $result] = $collectionModel->getData($path . '/' . $result);
            $collectionsData[$path . '/' . $result]['photos'] = $photosModel->getCollectionPhotos($path . '/' . $result);
        }

        return $collectionsData;
    }

    /**
     * @return \Photos\Model\Photos
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getPhotosModel()
    {
        return new Photos();
    }
    /**
     * @return \Photos\Model\Collection
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getCollectionModel()
    {
        return new Collection();
    }
}
