<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Checkout.php";
    require_once __DIR__."/../src/Patron.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__."/../views"
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //Root routes
    //homepage with option to go to a librarian or a patron page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');

    });

    //route to librarian landing page that displays all books, a form
    //to add books, search, update, and delete books.
    $app->get("/librarian", function() use ($app) {

        //might not need to do all dis bizness if we can call
        // book.getAuthors in twig
        // $all_books = Book::getAll();
        // $list_of_books = array();
        // foreach ($all_books as $book) {
        //     $book_with_author = $book->getAuthors();
        //     array_push($list_of_books, $book_with_author);
        // }
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
    });

    //route adds book to inventory on same page
    $app->post("/add_book", function() use ($app) {
        $book = new Book(preg_quote($_POST['title'], "'"));
        $book->save();
        $author = new Author(preg_quote($_POST['author'], "'"));
        $author->save();
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
    });

    //deletes all books and returns to librarian page
    $app->post("/delete_all_books", function() use ($app) {
        Book::deleteAll();
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
    });

    return $app;
?>
