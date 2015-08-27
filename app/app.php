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

    //librarian landing page that displays all books, a form
    //to add books, search, update, and delete books.
    $app->get("/librarian", function() use ($app) {
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
    });

    //adds book to inventory on same page
    $app->post("/add_book", function() use ($app) {
        $book = new Book(preg_quote($_POST['title'], "'"));
        $book->save();
        $author = new Author(preg_quote($_POST['author'], "'"));
        $author->save();
        $book->addAuthor($author);
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
    });

    //deletes all books and returns to librarian page
    $app->post("/delete_all_books", function() use ($app) {
        Book::deleteAll();
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
    });

    //goes to an update page for a book
    $app->get("/book/{id}/edit", function($id) use ($app) {
        $book = Book::find($id);
        return $app['twig']->render('book_edit.html.twig', array('book' => $book));
    });

    //update a book name and return to the librarian route
    $app->patch("/book/{id}", function($id) use ($app) {
        $book = Book::find($id);
        $book->updateTitle($_POST['title']);
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
    });

    return $app;
?>
