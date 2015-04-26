<?php
namespace Photos\Renderer;


class RendererAbstract
{
    /** @var string */
    protected $pathToTemplate;
    /** @var string */
    protected $pathToDestination;

    /**
     * @param $pathToTemplate
     * @throws \Exception
     */
    public function __construct($pathToTemplate, $pathToDestination)
    {
        $this->setTemplate($pathToTemplate);
        $this->setRenderDestination($pathToDestination);
    }

    /**
     * @param string $pathToTemplate
     * @return RendererAbstract
     * @throws \Exception
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function setTemplate($pathToTemplate)
    {
        $this->pathToTemplate = $pathToTemplate;

        return $this;
    }

    /**
     * @param string $pathToDestination
     * @return RendererAbstract
     * @throws \Exception
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function setRenderDestination($pathToDestination)
    {
        $this->pathToDestination = $pathToDestination;

        return $this;
    }

    /**
     * @return string
     * @author Cristian Quiroz <cris@qrz.io>
     */
    public function render()
    {
        ob_start();
        include $this->pathToTemplate;
        $renderedTemplate = ob_get_contents();
        ob_end_clean();

        $destinationHandle = fopen($this->pathToDestination, 'w');
        fwrite($destinationHandle, $renderedTemplate);
        fclose($destinationHandle);
    }
}
