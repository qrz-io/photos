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

        $collectionsRenderer->setCollections($this->getCollectionsModel()->getCollections($this->getRootDir() . 'collections'));

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
            $collectionsRenderer->setRenderDestination($this->getRootDir() . $collectionData['url-key'] . '.html');
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
        return rtrim($this->rootDir . '/') . '/';
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
