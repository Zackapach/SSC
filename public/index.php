<?php

use App\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};


// <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <link rel="stylesheet" href="style.css">
//     <title>Document</title>
// </head>
// <body>
// <section>

// <article>
// <li>MON PROFIL</li>
// {{ include('user_modif/_form.html.twig', {'button_label': 'Update'}) }}
// <a href="{{ path('app_user_modif_index') }}">back to list</a>
// {{ include('user_modif/_delete_form.html.twig') }}

// <li>MON PLANNING</li>



// <li>MON ABONNEMENTS</li>

// </article>

// </section>
    
// </body>
// </html>