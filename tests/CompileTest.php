<?php

use \org\bovigo\vfs\vfsStream;

class CompileTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \org\bovigo\vfs\vfsStreamDirectory */
    protected $dir;

    public function setUp()
    {
        $structure = [
            'collections' => [
                'sample' => [
                    '.collection.yml'    => '##
title: "sample collection"
img-thumb: "photo.jpg"',
                    'photo.jpg'   => '...',
                    'photo2.jpg'   => '...',
                    'photo3.jpg'   => '...',
                ]
            ],
            'templates' => [
                'collections.phtml' => '<?php $cs = $this->getCollections(); foreach ($cs as $c) echo $c["title"]; ?>',
                'collection.phtml' => '<?php $c = $this->getCollectionData(); echo $c["title"]; ?>',
            ],
        ];
        $this->dir = vfsStream::setup('root', null, $structure);
    }

    public function testRun()
    {
        return;
        $compile = new \Photos\Compile($this->dir->url());
        $compile->run();

        $this->assertTrue(file_exists($this->dir->url() . '/index.html'));
        $this->assertTrue(file_exists($this->dir->url() . '/collections/sample/index.html'));
        $this->assertEquals('sample collection', file_get_contents($this->dir->url() . '/index.html'));
        $this->assertEquals('sample collection', file_get_contents($this->dir->url() . '/collections/sample/index.html'));
    }
}
