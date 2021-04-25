<?php
/**
 * @link: https://singlephpfile.com/
 * @github: https://github.com/melvoio/single-php-file-html5up-story
 */

//<editor-fold desc="boot & config">
// Optional: break out to separate ../config.php & ../boot.php files)
$_start = hrtime(true); // start performance timer

const SITE_NAME = "Untitled";
const TIMESTAMP = 1618928145; // suffix to static resources, CSS/JS etc.
const STRIPE_SECRET_KEY = ""; // gear up for profitable websites!
const STRIPE_PUBLIC_KEY = "";
// const DB_URL = "scheme://user:pass@host:port/db_name"
// const DB_URL = "mysql://user:password@host:3306/db_name";
const DB_URL = "sqlite://null:null@null:0/../db/sqlite.db";
//</editor-fold desc="boot & config">

//<editor-fold desc="functions">
// Optional: break out to a separate ../functions.php file)
function request($key = null)
{
    if ($key === null) {
        return $_REQUEST;
    }
    if (isset($_REQUEST[$key])) {
        return $_REQUEST[$key];
    }
    return null;
}

function response($html)
{
    $response = str_replace(array("\r", "\n"), '', trim($html));
    return preg_replace('/\>\s+\</m', '><', $response);
}

function redirect($url, $statusCode = 302)
{
    header('Location: ' . $url, true, $statusCode);
    die();
}

function isPostRequest()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        return true;
    } else {
        return false;
    }
}

function openDbConn()
{
    static $conn = null;
    if ($conn === null) {
        $config = parse_url(DB_URL);
        switch ($config['scheme']) {
            case "mysql":
                $config['path'] = str_replace("/", "", $config['path']);
                $conn = new PDO("mysql:host=" . $config['host'] . ";dbname=" . $config['path'], $config['user'], $config['pass']);
                break;
            case "sqlite":
                $conn = new PDO('sqlite:' . __DIR__ . $config['path']); // store the db file a level below public!
        }
    }
    return $conn;
}

function closeDbConn(&$conn)
{
    $conn = null;
}

//</editor-fold desc="functions">

//<editor-fold desc="models/queries/services">
// This can evolve into standalone sections
// Optional: break out to a separate php files per model or service)

// insertMessage will insert the message, you can add all sorts of try catch and whatnot here
// function insertMessage(&$conn, $name, $email, $message) // alternative, pass in db conn and remove open/close in function
function insertMessage($name, $email, $message)
{
    $conn = openDbConn();
    $now = new \DateTime('now');
    $now = $now->format('Y-m-d H:i:s');
    $query = 'INSERT INTO messages (name, email, message, created_at) VALUES (:name, :email, :message, :created_at)';
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->bindParam(':created_at', $now, PDO::PARAM_STR);
    $stmt->execute();
    closeDbConn($conn);
    return true; // you could amend this with lastInsertId
}

//</editor-fold desc="queries">

//<editor-fold desc="actions">
// Optional: break out to a separate ../actions.php file)
$_action = request('action');
switch ($_action) {
    case "": // homepage, amend to suit your needs with pass through from nginx
        // there goes your action / logic for homepage
        $_title = "Home sweet home"; // set page title in head
        // $posts = getBlogPosts(...); // this function is not implemented, I might create a Single PHP File Blog Starter Kit, let me know @melvoio on twitter
        // there goes your view
        ob_start(); // buffer for injection in the layout
        ?>
        <section
                class="banner style1 orient-left content-align-left image-position-right fullscreen onload-image-fade-in onload-content-fade-right">
            <div class="content">
                <h2>⚡ <a href="/">Single PHP File Template Starter Kit</a></h2>
                <p class="major">Be empowered by performance, low costs and simplicity.<br/>Build something
                    amazing.</p>
                <p>Edit <?php echo __FILE__ ?> to make changes. CTRL+F "Build something amazing."</p>
            </div>
            <div class="image">
                <img src="/assets/images/banner.jpg" alt="Lightning by @noaa from unsplash"/>
            </div>
        </section>
        <!-- Two -->
        <section
                class="spotlight style1 orient-right content-align-left image-position-center onscroll-image-fade-in onscroll-content-fade-left"
                id="first">
            <div class="content">
                <h2>Because ...</h2>
                <p>Photo by <a
                            href="https://unsplash.com/@brucemars?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">bruce
                        mars</a> on <a
                            href="https://unsplash.com/s/photos/thinking-pose?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a><br/>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id ante sed ex pharetra lacinia sit
                    amet vel massa. Donec facilisis laoreet nulla eu bibendum. Donec ut ex risus. Fusce lorem lectus,
                    pharetra pretium massa et, hendrerit vestibulum odio lorem ipsum dolor sit amet.</p>
                <ul class="actions stacked">
                    <li><a href="#" class="button">Learn More</a></li>
                </ul>
            </div>
            <div class="image">
                <img src="/assets/images/spotlight01.jpg" alt=""/>
            </div>
        </section>

        <!-- Three -->
        <section
                class="spotlight style1 orient-left content-align-left image-position-center onscroll-image-fade-in onscroll-content-fade-right">
            <div class="content">
                <h2>... you don't ...</h2>
                <p>Photo by <a
                            href="https://unsplash.com/@joshuaearle?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Joshua
                        Earle</a> on <a
                            href="https://unsplash.com/s/photos/success?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a><br/>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id ante sed ex pharetra lacinia sit
                    amet vel massa. Donec facilisis laoreet nulla eu bibendum. Donec ut ex risus. Fusce lorem lectus,
                    pharetra pretium massa et, hendrerit vestibulum odio lorem ipsum dolor sit amet.</p>
                <ul class="actions stacked">
                    <li><a href="#" class="button">Learn More</a></li>
                </ul>
            </div>
            <div class="image">
                <img src="/assets/images/spotlight02.jpg" alt=""/>
            </div>
        </section>

        <!-- Four -->
        <section
                class="spotlight style1 orient-right content-align-left image-position-center onscroll-image-fade-in onscroll-content-fade-left">
            <div class="content">
                <h2>... need a framework.</h2>
                <p>Photo by <a
                            href="https://unsplash.com/@marcnajera?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Marc
                        Najera</a> on <a
                            href="https://unsplash.com/s/photos/success?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a><br/>Lorem
                    ipsum dolor sit amet, consectetur adipiscing elit. Morbi id ante sed ex pharetra lacinia sit amet
                    vel massa. Donec facilisis laoreet nulla eu bibendum. Donec ut ex risus. Fusce lorem lectus,
                    pharetra pretium massa et, hendrerit vestibulum odio lorem ipsum.</p>
                <ul class="actions stacked">
                    <li><a href="#" class="button">Learn More</a></li>
                </ul>
            </div>
            <div class="image">
                <img src="/assets/images/spotlight03.jpg" alt=""/>
            </div>
        </section>
        <!-- Five -->
        <section class="wrapper style1 align-center">
            <div class="inner">
                <h2>Massa sed condimentum</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id ante sed ex pharetra lacinia sit
                    amet vel massa. Donec facilisis laoreet nulla eu bibendum. Donec ut ex risus. Fusce lorem lectus,
                    pharetra pretium massa et, hendrerit vestibulum odio lorem ipsum.</p>
            </div>

            <!-- Gallery -->
            <div class="gallery style2 medium lightbox onscroll-fade-in">
                <article>
                    <a href="/assets/images/gallery/fulls/01.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/01.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>You</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/02.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/02.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>don't</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/03.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/03.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>need</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/04.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/04.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>a</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/05.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/05.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>framework.</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/06.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/06.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>Sed Tempus</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/07.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/07.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>Ipsum Lorem</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/08.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/08.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>Magna Risus</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/09.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/09.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>Tempus Dolor</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/10.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/10.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>Sed Etiam</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/11.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/11.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>Magna Lorem</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
                <article>
                    <a href="/assets/images/gallery/fulls/12.jpg" class="image">
                        <img src="/assets/images/gallery/thumbs/12.jpg" alt=""/>
                    </a>
                    <div class="caption">
                        <h3>Ipsum Dolor</h3>
                        <p>Lorem ipsum dolor amet, consectetur magna etiam elit. Etiam sed ultrices.</p>
                        <ul class="actions fixed">
                            <li><span class="button small">Details</span></li>
                        </ul>
                    </div>
                </article>
            </div>

        </section>

        <!-- Six -->
        <section class="wrapper style1 align-center">
            <div class="inner">
                <h2>Ipsum sed consequat</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi id ante sed ex pharetra lacinia sit
                    amet vel massa. Donec facilisis laoreet nulla eu bibendum. Donec ut ex risus. Fusce lorem lectus,
                    pharetra pretium massa et, hendrerit vestibulum odio lorem ipsum.</p>
                <div class="items style1 medium onscroll-fade-in">
                    <section>
                        <span class="icon style2 major fa-gem"></span>
                        <h3>Lorem</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-save"></span>
                        <h3>Ipsum</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-chart-bar"></span>
                        <h3>Dolor</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-wifi"></span>
                        <h3>Amet</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-cog"></span>
                        <h3>Magna</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon style2 major fa-paper-plane"></span>
                        <h3>Tempus</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-desktop"></span>
                        <h3>Aliquam</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-sync-alt"></span>
                        <h3>Elit</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-hashtag"></span>
                        <h3>Morbi</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-bolt"></span>
                        <h3>Turpis</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-envelope"></span>
                        <h3>Ultrices</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                    <section>
                        <span class="icon solid style2 major fa-leaf"></span>
                        <h3>Risus</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dui turpis, cursus eget orci
                            amet aliquam congue semper. Etiam eget ultrices risus nec tempor elit.</p>
                    </section>
                </div>
            </div>
        </section>

        <!-- Seven -->
        <section class="wrapper style1 align-center">
            <div class="inner medium">
                <h2>Get in touch</h2>
                <form method="post" action="/?action=contact">
                    <div class="fields">
                        <div class="field half">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" value=""/>
                        </div>
                        <div class="field half">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" value=""/>
                        </div>
                        <div class="field">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" rows="6"></textarea>
                        </div>
                    </div>
                    <ul class="actions special">
                        <li><input type="submit" name="submit" id="submit" value="Send Message"/></li>
                    </ul>
                </form>

            </div>
        </section>
        <?php
        $_content = ob_get_clean();
        break;
        ?>
    <?php
    case "contact":
        // @todo: Add CSRF & captcha, below is just to illustrate the point / flow
        // action / logic for the contact page
        $_title = "Contact";
        $contactFormError = null;
        if (isPostRequest()) {
            // validate the data, sanitize input, insert into the database, and perhaps send yourself an email notifying you of a message
            request('type_here_please') ? die('Bots not allowed.') : // bot honeypot
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
            $saved = insertMessage($name, $email, $message); // sample implemented see the functions section
            if ($name && $email && $message && $saved === true) {
                // sendNewMessageNotification(); // @todo, use something like AWS SES with DKIM set up to not end up in spam folders
                redirect('/?action=thank-you'); // redirect after the POST
            } else {
                $contactFormError = "Please try again.";
            }
        }
        ob_start();
        ?>
        <h1>Contact</h1>
        <p>Render your form here:</p>
        <?php
        if ($contactFormError) { ?>
            <p class="error"><?php echo $contactFormError; ?></p>
        <?php } ?>
        <form method="post">
            <div>
                <label for="name">Name</label>
                <div>
                    <input type="text" name="name" required/>
                </div>
            </div>
            <div>
                <label for="email">Email</label>
                <div>
                    <input type="email" name="email" required/>
                </div>
                <div>
                    <label for="message">Message</label>
                    <div>
                        <textarea name="message" rows="10" cols="30"></textarea>
                    </div>
                </div>
                <input type="hidden" name="type_here_please" aria-hidden="true"/>
                <div>
                    <input type="submit"/>
                </div>
        </form>
        <?php
        $_content = ob_get_clean();
        break;
        ?>
    <?php
    case "thank-you":
        // @todo: Logic not implemented, just to illustrate the point / flow
        // action / logic for the thank you page post-submission
        $_title = "Thank you!";
        ob_start();
        ?>
        <section class="wrapper style1 align-center onload-content-fade-up">
            <div class="inner">
                <h1>Thanks for reaching out.</h1>
                <p>I'll be in touch asap.</p>
                <p><a href="/">Go back to homepage</a></p>
            </div>
        </section>
        <?php
        $_content = ob_get_clean();
        break;
        ?>
    <?php
    case "about":
        // action / logic for the about page, if any
        $_title = "About";
        // $aboutPage = getPage('about'); // not implemented, could be part of a CMS, then echo $aboutPage in HTML below
        ob_start();
        ?>
        <h1>About Single PHP File</h1>
        <p>Visit <a target="_blank" href="https://singlephpfile.com">https://singlephpfile.com/</a></p>
        <?php
        $_content = ob_get_clean();
        break;
        ?>
    <?php
    default:
        $_title = "Ooops";
        http_response_code('404');
        ob_start();
        ?>
        <h1>Oh oh, 404.</h1>
        <p>
            <img alt="Sad kitty" src="https://media.giphy.com/media/CM1rHbKDMH2BW/giphy.gif"/>
        </p>
        <?php
        $_content = ob_get_clean();
}
//</editor-fold desc="actions">
?>
<?php
//<editor-fold desc="HTML layout">
// Optional: break out to a separate ../views/layout.php file)
ob_start();
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="/assets/css/app.css?<?php echo TIMESTAMP; ?>" rel="stylesheet">
        <title><?php echo isset($_title) ? $_title : "Build something amazing"; ?>
            · <?php echo SITE_NAME ?></title>
        <noscript>
            <link rel="stylesheet" href="assets/css/noscript.css"/>
        </noscript>
    </head>
    <body class="is-preload">
    <div id="wrapper" class="divided">
        <?php echo $_content; ?>
        <!-- Footer -->
        <footer class="wrapper style1 align-center">
            <div class="inner">
                <ul class="icons">
                    <li><a href="https://twitter.com/melvoio" class="icon brands style2 fa-twitter"><span class="label">Twitter</span></a>
                    </li>
                    <li><a target="_blank" href="https://github.com/melvoio/single-php-file"
                           class="icon brands style2 fa-github"><span
                                    class="label">GitHub</span></a>
                    </li>
                    <li><a href="#" class="icon brands style2 fa-facebook-f"><span class="label">Facebook</span></a>
                    </li>
                    <li><a href="#" class="icon brands style2 fa-instagram"><span class="label">Instagram</span></a>
                    </li>
                    <li><a href="#" class="icon brands style2 fa-linkedin"><span class="label">LinkedIn</span></a></li>
                    <li><a href="#" class="icon style2 fa-envelope"><span class="label">Email</span></a></li>
                </ul>
                <p>© Untitled. Powered by ⚡ Single PHP File. Design: <a href="https://html5up.net">HTML5 UP</a>.</p>
            </div>
        </footer>
    </div>
    <?php
    $_end = hrtime(true); // end performance timer
    $_exec_time = round(($_end - $_start) / 1000000, 2); // convert to ms
    echo '<div id="timer">' . $_exec_time . 'ms</div>';  // display time
    ?>
    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/app.js?<?php echo TIMESTAMP; ?>"></script>
    <script src="/assets/js/jquery.scrollex.min.js"></script>
    <script src="/assets/js/jquery.scrolly.min.js"></script>
    <script src="/assets/js/browser.min.js"></script>
    <script src="/assets/js/breakpoints.min.js"></script>
    <script src="/assets/js/util.js"></script>
    <script src="/assets/js/main.js"></script>
    </body>
    </html>
<?php
$_html = ob_get_clean();
echo response($_html);
//</editor-fold desc="HTML layout">
?>