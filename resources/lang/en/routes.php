<?php
// chiave: corrisponde al parametro della transRoute() nel file delle rotte web.php
// valore: corrisponde all'URI visualizzato nella barra indirizzi
// chiave => valore
return [
    'contacts' => 'contact-us',
    'thankyou' => 'thank-you',
    'blog' => 'blog',
    'article' => 'blog/{slug}',
    'category' => 'blog/category/{slug}',
    'tag' => 'blog/tag/{slug}'
];
