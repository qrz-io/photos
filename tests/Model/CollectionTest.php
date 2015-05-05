<?php

class CollectionTest extends PHPUnit_Framework_TestCase
{
    /** @var \Photos\Model\Photo */
    protected $photoModel;
    /** @var \Photos\Model\Collection */
    protected $collection;

    public function setUp()
    {
        $this->photoModel = $this->getMockBuilder('\Photos\Model\Photo')
            ->setMethods(array('getPathToThumbnail'))
            ->getMock();

        $this->photoModel->expects($this->any())
            ->method('getPathToThumbnail')
            ->willReturnCallback(function($pathToImage) {
                return $pathToImage . '-thumb';
            });

        $this->collection = $this->getMockBuilder('\Photos\Model\Collection')
            ->setMethods(array('parseConfig', 'getPhotoModel'))
            ->getMock();

        $this->collection->expects($this->any())
            ->method('parseConfig')
            ->willReturn(array(
                'title'       => 'Super Awesome Collection Name!',
                'description' => 'This is one awesome collection',
                'img-test1'   => 'test1.jpg',
                'img-test2'   => 'test2.jpg',
                'test3'       => 'test3.jpg',
            ));

        $this->collection->expects($this->any())
            ->method('getPhotoModel')
            ->willReturn($this->photoModel);
    }

    public function testGetData()
    {
        $expectedData = array(
            'title'       => 'Super Awesome Collection Name!',
            'description' => 'This is one awesome collection',
            'img-test1'   => '/path/to/collection/test1.jpg-thumb',
            'img-test2'   => '/path/to/collection/test2.jpg-thumb',
            'test3'       => 'test3.jpg',
        );

        $actualData = $this->collection->getData('/path/to/collection');

        $this->assertEquals($expectedData, $actualData);
    }

    public function testGetCollectionData()
    {
        $expectedData = array(
            'title'       => 'Super Awesome Collection Name!',
            'description' => 'This is one awesome collection',
            'img-test1'   => '/path/to/collection/test1.jpg-thumb',
            'img-test2'   => '/path/to/collection/test2.jpg-thumb',
            'test3'       => 'test3.jpg',
        );

        $actualData = $this->collection->getCollectionData('/path/to/collection/');

        $this->assertEquals($expectedData, $actualData);
    }

    public function testGetPhotoModel()
    {
        $collection = new \Photos\Model\Collection();
        $this->assertInstanceOf('\Photos\Model\Photo', $collection->getPhotoModel());
    }
}
