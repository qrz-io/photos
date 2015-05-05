<?php

use \org\bovigo\vfs\vfsStream;

class PhotosTest extends PHPUnit_Framework_TestCase
{

    /** @var  \org\bovigo\vfs\vfsStreamDirectory */
    protected $dir;

    public function setUp()
    {
        $this->dir = vfsStream::setup();

        vfsStream::newFile('photo.jpg', 0777)
            ->withContent('...')
            ->at($this->dir);

        vfsStream::newFile('file.txt', 0777)
            ->withContent('...')
            ->at($this->dir);

        vfsStream::newFile('photo2.jpg', 0777)
            ->withContent('...')
            ->at($this->dir);
    }

    public function testGetCollectionPhotos()
    {
        $photoModel = $this->getMockBuilder('\Photos\Model\Photo')
            ->setMethods(array('resizeImage'))
            ->getMock();
        $photoModel->expects($this->any())
            ->method('resizeImage')
            ->willReturn($photoModel);

        $photos = $this->getMockBuilder('\Photos\Model\Photos')
            ->setMethods(array('getPhotoModel'))
            ->getMock();

        $photos->expects($this->any())
            ->method('getPhotoModel')
            ->willReturn($photoModel);

        $data = $photos->getCollectionPhotos($this->dir->url());

        $expectedData = array(
            array (
                "Thumbnail" => ".thumb/photo.jpg",
                "BigImage" => ".img/photo.jpg",
                "RealImage" => "photo.jpg",
            ),array (
                "Thumbnail" => ".thumb/photo2.jpg",
                "BigImage" => ".img/photo2.jpg",
                "RealImage" => "photo2.jpg",
            ),
        );

        $this->assertEquals($expectedData, $data);
    }

    public function testGetPhotoModel()
    {
        $photos = new \Photos\Model\Photos();
        $this->assertInstanceOf('\Photos\Model\Photo', $photos->getPhotoModel());
    }
}
