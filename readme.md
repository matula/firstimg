# First Image
-------
Simple library that returns the first image on a web page.  Though, only if it's in an `<img>` tag.

### Installation
Add to your composer.json file

```
"matula/firstimg": "dev-master"
```

### Usage

```
$url = 'http://google.com';
$image = new Matula\Firstimg\Firstimg($url);
echo $image->downloadImage();
```

This will find the first image on the page and download it. Currently, it also resizes the image to 100px.

### TODO

* better documentation
* customize the image's filename/extension
* customize image resizing, or disable
* better formatting, etc