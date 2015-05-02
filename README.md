# Photos
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/qrz-io/photos.svg?style=flat-square)](https://scrutinizer-ci.com/g/qrz-io/photos/)
[![Travis Build Status](https://img.shields.io/travis/qrz-io/photos.svg?style=flat-square)](https://travis-ci.org/qrz-io/photos)
[![Coverage Status](https://img.shields.io/coveralls/qrz-io/photos.svg?style=flat-square)](https://coveralls.io/r/qrz-io/photos?branch=master)

Photos is just a simple CLI application I use for automatically generating an HTML photo collection from photo files and little configuration.

# Sample Output

Check out the results of a compilation at [http://qrz.io/photos/](http://qrz.io/photos/). The source is available at the [`gh-pages`](https://github.com/qrz-io/photos/tree/gh-pages) branch of this repo. Template used is Parallelism, by [HTML5Up](http://html5up.net/)

#How to use
## Define collections and images
Inside the collections directory, each directory will represent a collection of photos and will be defined by a `.colleciton.yml` file. The structure should look like so:
```
 - collections
   - collection1
     - .collection.yml
   - collection2
     - .collection.yml
   - collection3
     - .collection.yml  
```

You can put any data you want in the yml config file, and it will be made available in the templates. For instance:

``` 
## Define data to be passed to template.
## Prefix images with 'img-' for auto thumbnail creation.
## 'title' is used for url key.
## Anything defined here will be passed down to template, so go nuts.
title: "B&W world"
subtitle: "The world has no colour somtimes."
img-thumb: "flower.jpg"
```

## Create templates
Two templates are used for the generation, both are inside the templates directory. 

 - `collections.phtml` is used for generating an index of collections; the compiled output will be `index.html`, in the root directory. All the data defined for all of the collections is made available to it.
 - `collection.phtml` is used for generating the collection itself; the compiled output will be one html file in the root directory for each collection. The data made available to it is each of the collections defined data, alongside photo data.

## Compile
Finally, to compile, from the command line execute:
```
$ bin/photos
```
That will generate all thumbnails and images inside the collection folders, and the html file in the root directory.
