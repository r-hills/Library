# The Chubbs Peterson Memorial Private Library

##### Dynamic Library Catalog using MySQL, 08/27/15

#### By Ashlin Aronin, Alexandra Brown, Rick Hills and Deron Johnson

## Description

The CPMPL is a web app that allows librarians to view the collection, add books to the collection, update book titles and search by either book title or author. Coming soon: a portal for patrons of the CPMPL.

## Setup
* Clone this repository

* Run the following command in the project directory
```console
$ composer install
```

* Import sql.zip files to PHPMyAdmin

* Start Apache server with the following command:
```console
$ apachectl start
```

* Start a PHP server in the web directory
```console
$ php -S localhost:8000
```

* Navigate your browser to localhost:8000

* Enjoy!

## Technologies Used

PHP, PHPUnit, MySQL, Silex, Twig, HTML, CSS, Bootstrap

### Legal

Copyright (c) 2015 Ashlin Aronin, Alexandra Brown, Rick Hills and Deron Johnson

This software is licensed under the MIT license.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
