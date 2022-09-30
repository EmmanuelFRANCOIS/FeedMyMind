<?php

$config = [
  'companyName' => 'FeedMyMind',
  'siteName'    => 'FeedMyMind.com',
  'siteUrl'     => 'http://localhost/feedmymind/',
  'adminUrl'    => 'http://localhost/feedmymind/administration/',
  'siteIntro'   =>  '<p style="text-align: justify;">FeedMyMind prend soin de votre Esprit et '
                  . 'propose le plus large choix de produits culturels, '
                  . 'répartis dans les quatre univers :'
                  . '<span class="d-flex flex-wrap justify-content-center mt-3 text-uppercase text-success text-center fw-bold fs-5">'
                  . '  <span class="mx-3">Livre</span>'
                  . '  <span class="mx-3">Musique</span>'
                  . '  <span class="mx-3">Film</span>'
                  . '  <span class="mx-3">Documentaire</span>'
                  . '</span></p>'
                  . '<p style="text-align: justify;">Des milliers de références, les meilleurs contenus, à votre disposition, '
                  . 'au meilleur prix...</p>',
'siteFooter'    =>  '<p class="text-light" style="text-align: justify;">FeedMyMind prend soin de votre Esprit et '
                  . 'propose le plus large choix de produits culturels, '
                  . 'répartis dans les quatre univers :'
                  . '<span class="d-flex flex-wrap justify-content-between mt-3 text-uppercase text-center">'
                  . '  <a class="btn btn-success mt-2 me-1 px-1 py-0 fw-bold" href="../../../../classes/controller/site/universe/show.php?id=1">Livre</a>'
                  . '  <a class="btn btn-success mt-2 me-1 px-1 py-0 fw-bold" href="../../../../classes/controller/site/universe/show.php?id=2">Musique</a>'
                  . '  <a class="btn btn-success mt-2 me-1 px-1 py-0 fw-bold" href="../../../../classes/controller/site/universe/show.php?id=3">Film</a>'
                  . '  <a class="btn btn-success mt-2 me-1 px-1 py-0 fw-bold" href="../../../../classes/controller/site/universe/show.php?id=4">Documentaire</a>'
                  . '</span></p>'
                  . '<p class="text-light" style="text-align: justify;">Des milliers de références, les meilleurs contenus, à votre disposition, '
                  . 'au meilleur prix...</p>',
  'imagePath' => [
    'avatars'    => 'avatars/',
    'categories' => 'categories/',
    'universes'  => 'universes/',
    'brands'     => 'brands/',
    'carriers'   => 'carriers/',
    'design'     => 'design/',
    'icons'      => 'icons/',
    'logos'      => 'logos/',
    'products'   => 'products/',
    'customers'  => 'customers/'
  ],
  'products' => [
    'yearMin'    => 1800,
    'yearMax'    => 2050,
    'priceMin'   => 0,
    'priceMax'   => 100,
  ],
  'site' => [
    'quotes' => [
      "« L'homme sans culture est un arbre sans fruit. » (A. de Rivarol)",
      "« La culture ne s’hérite pas, elle se conquiert. » (André Malraux)",
      "« La culture de l’esprit est un autre soleil pour les gens instruits. » (Héraclite)",
      "« Un esprit cultivé ne nuit point au courage. » (Voltaire)",
      "« La véritable école du Commandement, c’est la culture générale. » (Charles de Gaulle)",
      "« La culture, c’est ce qui reste quand on a tout oublié. » (Edouart Herriot)",
      "« Une civilisation sans culture fait des sociétés sans pédagogie. » (Louis Pauwels)",
      "« La culture est l’âme de la démocratie. » (Lionel Jospin)",
      "« La culture, c est la lumière du passé dans les mains du présent pour éclairer le futur » (Leon Litchle)",
      "« La culture, c'est l'expression du vivant. » (Gaëtan Faucer)",
      "« La culture est l'espace et le temps rendus sensibles au coeur. » (Jean D'Ormesson)",
      "« La culture... ce qui a fait de l'homme autre chose qu'un accident de l'univers. » (André Malraux)",
      "« La culture, c'est comme la confiture, moins on en a, plus on l'étale. » (Françoise Sagan)",
      "« Tout ce qui dégrade la culture, raccourcit les chemins qui mènent à la servitude. » (Albert Camus)",
      "« La culture n'est pas un luxe, c'est une nécessité. » (Gao Xingjian)",
      "« La culture, c'est ce qui relie les savoirs et les féconde. » (Edgar Morin)",
      "« Une société sans culture est un corps sans âme. » (Mamadou Nabombo)",
      "« La culture est ce qui fait d'une journée de travail une journée de vie. » (Georges Duhamel)",
      "« Qui se refuse la culture de la lecture, s'abandonne à l'ignorance. » (Mrtb)",
      "« La culture est une victoire de l'ennui sur l'amour-propre. » (Emile Faguet)",
    ],
    'modules' => [
      'products' => [
        'tpl'        => 'mosaic',
        'nbDisplay'  => 4,
        'nbByRow'    => 4,
        'nbMaxByRow' => 6,
        'nbQuery'    => 8,
        'mosaic' => [
          'aosEffect'  => 'zoom-in',
          'aosDelay'   => 50,
          'aosOnce'    => true
        ],
        'list' => [
          'aosEffect'  => 'fade-up',
          'aosDelay'   => 50,
          'aosOnce'    => true
        ],
      ],
      'categories' => [
        'tpl'        => 'mosaic',
        'mosaic' => [
          'nbDisplay'  => 1000,
          'nbByRow'    => 6,
          'nbMaxByRow' => 6,
          'nbQuery'    => 1000,
          'aosEffect'  => 'flip-up',
          'aosDelay'   => 100,
          'aosOnce'    => true
        ],
        'list' => [
          'nbDisplay'  => 1000,
          'nbByRow'    => 5,
          'nbMaxByRow' => 6,
          'nbQuery'    => 1000,
          'aosEffect'  => 'fade-up',
          'aosDelay'   => 100,
          'aosOnce'    => true
        ],
      ]
    ],
    'productsList' => [
      'tpl'        => 'mosaic',
      'orderBy'    => 'title',
      'orderDir'   => 'ASC',
      'nbPerPage'  => 20,
      'mosaic' => [
        'aosEffect'  => 'zoom-in',
        'aosDelay'   => 100,
        'aosOnce'    => true
      ],
      'list' => [
        'aosEffect'  => 'fade-up',
        'aosDelay'   => 100,
        'aosOnce'    => true
      ],
    ],
    'categoriesList' => [
      'tpl'        => 'mosaic',
      'orderBy'    => 'created',
      'nbPerPage'  => 20,
      'mosaic' => [
        'aosEffect'  => 'zoom-in',
        'aosDelay'   => 100,
        'aosOnce'    => true
      ],
      'list' => [
        'aosEffect'  => 'fade-up',
        'aosDelay'   => 100,
        'aosOnce'    => true
      ],
    ],
    'searchbox' => [
      'minChars'     => 2,
      'nbProducts'   => 5,
      'nbCategories' => 3,
      'strLength'    => 35
    ],
    'advsearch' => [
      'title'        => true,
      'maker'        => true,
      'description'  => false,
    ]
  ],
  'admin' => [
  ],
  'locale' => 'fr-FR',
  'orders' => [
    'tva'         => 0.20,
    'delivery_cost_per_product' => 0.87,
    'statusList'  => [
      'saved'     => "Enregistrée / En attente de paiment.",
      'paid'      => "Payée et en attente de validation.",
      'validated' => "Validée et en attente d'expédition.",
      'sent'      => "Expédiée et en cours de livraison.",
      'delivered' => "Livrée et Close.",
      'returned'  => "Produits retournés.",
      'cancelled' => "Commande annulée par le client."
    ]
  ]
];


?>