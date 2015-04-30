<?php

use \org\bovigo\vfs\vfsStream;

class PhotoTest extends PHPUnit_Framework_TestCase
{

    /** @var  \org\bovigo\vfs\vfsStreamDirectory */
    protected $dir;

    public function setUp()
    {
        $this->dir = vfsStream::setup();

        vfsStream::newFile('photo.jpg', 0777)
            ->withContent('...')
            ->at($this->dir);
    }

    public function testGetData()
    {
        $photoModel = $this->getMockBuilder('\Photos\Model\Photo')
            ->setMethods(array('resizeImage'))
            ->getMock();
        $photoModel->expects($this->any())
            ->method('resizeImage')
            ->willReturn($photoModel);

        $data = $photoModel->getData($this->dir->url() . '/photo.jpg');

        $this->assertEquals('vfs://root/.thumb/photo.jpg', $data['Thumbnail']);
        $this->assertEquals('vfs://root/.img/photo.jpg', $data['BigImage']);
        $this->assertEquals('vfs://root/photo.jpg', $data['RealImage']);

        $data = $photoModel->getData($this->dir->url() . '/photo2.jpg');
        $this->assertEmpty($data);
    }
}
