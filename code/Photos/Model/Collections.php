<?php
namespace Photos\Model;



class Collections
{

    /**
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getCollections()
    {
        $path = 'collections';
        $results = scandir($path);
        $collectionModel = $this->getCollectionModel();
        $collectionsData = array();

        foreach ($results as $result) {
            if ($result === '.' || $result === '..' || !is_dir($path . '/' . $result)) {
                continue;
            }

            $collectionsData[$result] = $collectionModel->getData($path . '/' . $result);
        }

        return $collectionsData;
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
