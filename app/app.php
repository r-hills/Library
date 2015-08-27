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

    //delete an individual book and return to the librarian route
    $app->delete("/book/{id}/delete", function($id) use ($app) {
        $book = Book::find($id);
        $book->delete();
        return $app['twig']->render('librarian.html.twig', array('books' => Book::getAll()));
    });

    //displays results of user search by book title
    $app->post("/book_title_search_results", function() use ($app) {
        $user_query = $_POST['title'];
        $all_books = Book::getAll();
        $matching_books = array();
        foreach ($all_books as $book) {
            if (strpos(strtolower($book->getTitle()), strtolower($user_query)) !== false)  {
                array_push($matching_books, $book);
            }
        }
        return $app['twig']->render("book_search_results.html.twig", array('results' => $matching_books));
    });

    $app->post("/book_author_search_results", function() use ($app) {
        $user_query = $_POST['author'];
        $all_authors = Author::getAll();
        $matching_authors = array();
        foreach ($all_authors as $author) {
            if (strpos(strtolower($author->getName()), strtolower($user_query)) !== false)  {
                array_push($matching_authors, $author);
            }
        }

        $author_book_search_results = array();
        foreach ($matching_authors as $author) {
            $matching_author_books = $author->getBooks();
            foreach ($matching_author_books as $book) {
                array_push($author_book_search_results, $book);
            }
        }

        return $app['twig']->render("author_search_results.html.twig", array('results' => $author_book_search_results));
    });

    return $app;
?>
