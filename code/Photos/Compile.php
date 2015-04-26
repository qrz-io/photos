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

        $collectionsRenderer->setCollections($this->getCollectionsModel()->getCollections());

        $collectionsRenderer->render();
    }

    /**
     * @return void
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function renderCollections()
    {
        $collectionsRenderer = new Renderer\Collection($this->getTemplatesDir() . 'collection.phtml', null);
        $collections = $this->getCollectionsModel()->getCollections();

        foreach ($collections as $pathToCollection => $collectionData) {
            $collectionsRenderer->setRenderDestination(
                $this->getRootDir() . $this->prepareName($collectionData['title']) . '.html'
            );
            $collectionsRenderer->setCollectionData($collectionData);
            $collectionsRenderer->render();
        }
    }

    public function prepareName($name)
    {
        $name = preg_replace("/[^A-Za-z0-9]/", "-", $name);
        $name = strtolower($name);

        return $name;
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
