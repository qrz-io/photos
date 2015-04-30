<?php
namespace Photos\Renderer;

class Collection extends RendererAbstract
{

    /** @var array */
    protected $collectionData;

    /**
     * @param array $collectionData
     * @return Collection
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function setCollectionData($collectionData)
    {
        $this->collectionData = $collectionData;

        return $this;
    }

    /**
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getCollectionData()
    {
        return $this->collectionData;
    }
}
