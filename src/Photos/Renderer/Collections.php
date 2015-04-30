<?php
namespace Photos\Renderer;

class Collections extends RendererAbstract
{

    protected $collections;


    /**
     * @param array $collections
     * @return Collections
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function setCollections($collections)
    {
        $this->collections = $collections;

        return $this;
    }

    /**
     * @return array
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function getCollections()
    {
        return $this->collections;
    }
}
