PHP PathPattern was created as a helper method to move the folder structure management code to a separate abstract library.
You might find this helpful, especially if you 're using a date folder structure for your assets like me.

You can set up a folder structure pattern or a base path and call the function that returns the path. If the requested path doesn't exist it will create it.

### Installation

Just require the library in your file:

``` require 'PathPattern.php'; ```

### Usage

First we need to create an instance of PathPattern

``` $uploadFolder = new PathPattern\Folder; ```

and the call the ```getPath();``` method to get your 

``` echo $uploadFolder->getPath(); ```


This will return a ```./2015/10/02/``` folder.

If we wanted to upload a file to a ```./year/day/month/images/``` folder we would use:

```php

move_uploaded_file ("file.jpg", $uploadFolder->getPath(":Y/:d/:m/images") . "file.jpg");

```

### Available methods:

```php

 // Set The pattern of your folder
 // default pattern is ':Y/:m/:d' for Year month and day
 // All date parameters are declared with a ':' character in front of them

 // This pattern will result to  `./2015/02/10/images`

 $uploadFolder->setPattern(':Y/:d/:m/images');


 // Set the base path of your pattern
 // default path is './' for current directory

 $uploadFolder->setBasePath('your base path');

 
 // This returns the path. If the requested path doesn't exist will be created.  

 echo $uploadFolder->getPath();

 // You can set your base path and pattern here too.

 echo $uploadFolder->getPath('basepath','pattern');

````


### Changelog

## 0.0.1

Initial Commit