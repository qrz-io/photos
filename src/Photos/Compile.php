<?php
namespace Photos;

class Compile
{

    /** @var string */
    protected $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function run()
    {
        $this->renderIndex();
        $this->renderCollections();
    }

    /**
     * @return void
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function renderIndex()
    {
        $collectionsRenderer = new Renderer\Collections(
            $this->getTemplatesDir() . 'collections.phtml',
            $this->getRootDir() . 'index.html'
        );

        $collections = $this->getCollectionsModel()->getCollections($this->getRootDir() . 'collections');
        usort($collections, function ($col1, $col2) {
            if ($col1['sort-order'] == $col2['sort-order']) {
                return 0;
            } else if ($col1['sort-order'] > $col2['sort-order']) {
                return 1;
            } else {
                return -1;
            }
        });

        $collectionsRenderer->setCollections($collections);
        $collectionsRenderer->render();
    }

    /**
     * @return void
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function renderCollections()
    {
        $collectionsRenderer = new Renderer\Collection($this->getTemplatesDir() . 'collection.phtml', null);
        $collections = $this->getCollectionsModel()->getCollections($this->getRootDir() . 'collections');

        foreach ($collections as $pathToCollection => $collectionData) {
            $collectionsRenderer->setRenderDestination($this->getRootDir() . $collectionData['path'] . '/index.html');
            $collectionsRenderer->setCollectionData($collectionData);
            $collectionsRenderer->render();
        }
    }

    /**
     * @return \Photos\Model\Collections
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getCollectionsModel()
    {
        return new \Photos\Model\Collections();
    }

    /**
     * @return string
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getRootDir()
    {
        return rtrim($this->rootDir . '/') . '../photos-output/';
    }

    /**
     * @return string
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getTemplatesDir()
    {
        return $this->getRootDir() . 'templates/';
    }
}
