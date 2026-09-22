<?php

/*
|--------------------------------------------------------------------------
| Data menu 2DA Store (satu sumber data untuk katalog & detail produk)
|--------------------------------------------------------------------------
| Key array = slug produk, dipakai di URL: /produklogin?p={slug}
|
| Field wajib : name, img, rating, reviews, price, cats, desc
| Field opsional (dipakai halaman detail):
|   detail   : deskripsi panjang (boleh pakai <strong>). Kalau kosong -> pakai desc
|   sold     : teks jumlah terjual, mis. '1.200+'
|   puas     : persentase puas, mis. '99%'
|   options  : grup pilihan (radio / checkbox) beserta harga tambahan
|               (opsional per grup: 'hint' = teks kecil di bawah judul grup pada pop-up)
| Kalau field opsional tidak diisi, bagiannya otomatis tidak ditampilkan.
|
| CATATAN: pilihan saus/topping untuk produk selain Corndog di bawah ini
| adalah CONTOH. Silakan ubah nama & harga tambahannya sesuai menu asli.
*/

// ---------- Grup opsi yang dipakai bersama ----------

// Makanan gurih (sama seperti Corndog)
$sausGurih = [
    'title' => 'Pilihan Saus / Taburan',
    'name'  => 'saus',
    'type'  => 'radio',
    'note'  => 'Pilih 1 (Wajib)',
    'hint'  => 'Pilih salah satu saus atau taburan bumbu favorit Anda.',
    'items' => [
        ['name' => 'Saus Sambal & Mayones', 'desc' => 'Pedas manis creamy favorit', 'extra' => 0],
        ['name' => 'Saus Keju Lumer',       'desc' => 'Gurih asin double cheesy',  'extra' => 1000],
        ['name' => 'Bumbu Tabur Balado Pedas', 'desc' => 'Pedas manis nampol',        'extra' => 0],
        ['name' => 'Tabur Jagung Bakar Gurih', 'desc' => 'Aroma manis gurih nagih',   'extra' => 0],
    ],
];

$toppingGurih = [
    'title' => 'Tambahan Topping Spesial',
    'name'  => 'topping[]',
    'type'  => 'checkbox',
    'note'  => 'Bisa pilih lebih dari 1',
    'hint'  => 'Bisa pilih lebih dari satu untuk rasa lebih mantap.',
    'items' => [
        ['name' => 'Extra Mayones Gurih',   'extra' => 1000],
        ['name' => 'Bubuk Boncabe Level 5', 'extra' => 500],
    ],
];

return [

    'corndog-mini-mozzarella' => [
        'name' => 'Corndog Mini Mozzarella', 'img' => 'corndog.jpg',
        'rating' => '4.9', 'reviews' => '340+', 'price' => 5000, 'cats' => 'gurih',
        'desc' => 'Sensasi renyah di luar dengan keju mozzarella premium yang meleleh sempurna di dalam dan…',
        'detail' => 'Sensasi renyah di luar dengan balutan adonan renyah keemasan bertabur tepung roti panko impor, dipadu <strong>keju mozzarella premium</strong> yang meleleh sempurna dan bisa ditarik panjang! Disajikan hangat langsung dari penggorengan dengan racikan bumbu gurih favoritmu.',
        'sold' => '1.200+',
        'puas' => '99%',
        'options' => [$sausGurih, $toppingGurih],
    ],

    'cireng-isi-ayam-suwir' => [
        'name' => 'Cireng Isi Ayam Suwir', 'img' => 'cireng.jpg',
        'rating' => '4.8', 'reviews' => '280+', 'price' => 5000, 'cats' => 'gurih',
        'desc' => 'Cireng kenyal digoreng renyah di luar dengan isian ayam suwir pedas gurih yang melimpah.',
        'detail' => 'Cireng kenyal yang digoreng dadakan hingga <strong>renyah di luar</strong> dan lembut kenyal di dalam, dengan isian ayam suwir pedas gurih yang melimpah di setiap gigitan. Disajikan hangat, pas untuk camilan sore atau teman ngobrol bareng.',
        'options' => [
            [
                'title' => 'Pilihan Isian',
                'name'  => 'isian',
                'type'  => 'radio',
                'note'  => 'Pilih 1 (Wajib)',
                'items' => [
                    ['name' => 'Ayam Suwir Pedas',    'desc' => 'Pedas gurih meresap',   'extra' => 0],
                    ['name' => 'Ayam Suwir Original', 'desc' => 'Gurih tidak pedas',     'extra' => 0],
                    ['name' => 'Sosis Original',     'desc' => 'Gurih tidak pedas', 'extra' => 0],
                    ['name' => 'Keju',     'desc' => 'Gurih cheesy', 'extra' => 0],
                ],
            ],
        ],
    ],

    'pop-ice-coklat-blender' => [
        'name' => 'Pop Ice Coklat Blender', 'img' => 'coklat.jpg',
        'rating' => '4.7', 'reviews' => '190+', 'price' => 5000, 'cats' => 'minuman',
        'desc' => 'Minuman es blender coklat creamy dengan taburan choco chips manis dan segarnya es…',
        'detail' => 'Es blender coklat yang <strong>creamy dan dingin</strong>, dipadu taburan choco chips manis yang bikin setiap tegukan makin nikmat. Cocok jadi penawar haus di siang hari, dan bisa kamu tambah topping sesuai selera.',
        'options' => [
            [
                'title' => 'Tambahan Topping',
                'name'  => 'topping[]',
                'type'  => 'checkbox',
                'note'  => 'Bisa pilih lebih dari 1',
                'items' => [
                    ['name' => 'Extra Choco Chips',   'extra' => 1000],
                    ['name' => 'Susu Kental Manis',   'extra' => 1000],
                ],
            ],
        ],
    ],

    'roti-maryam-mini-coklat-keju' => [
        'name' => 'Roti Maryam Mini Coklat Keju', 'img' => 'maryam.jpg',
        'rating' => '4.8', 'reviews' => '210+', 'price' => 5000, 'cats' => 'manis',
        'desc' => 'Roti lapis khas Timur Tengah yang digoreng garing berlapis, disajikan hangat dengan taburan meses',
        'detail' => 'Roti maryam khas Timur Tengah yang digoreng hingga <strong>garing berlapis</strong> di luar dan tetap lembut di dalam, disajikan hangat dengan taburan meses coklat dan keju. Ukurannya mini, jadi pas untuk camilan manis kapan saja.',
        'options' => [
            [
                'title' => 'Pilihan Taburan',
                'name'  => 'taburan',
                'type'  => 'radio',
                'note'  => 'Pilih 1 (Wajib)',
                'items' => [
                    ['name' => 'Meses Coklat & Keju', 'desc' => 'Klasik manis gurih',  'extra' => 0],
                    ['name' => 'Susu Kental Manis',   'desc' => 'Manis legit lumer',   'extra' => 0],
                    ['name' => 'Selai Strawberry',    'desc' => 'Manis asam segar',    'extra' => 1000],
                ],
            ],
            [
                'title' => 'Tambahan Topping Spesial',
                'name'  => 'topping[]',
                'type'  => 'checkbox',
                'note'  => 'Bisa pilih lebih dari 1',
                'items' => [
                    ['name' => 'Extra Keju Parut', 'extra' => 1000],
                    ['name' => 'Extra Meses',      'extra' => 500],
                ],
            ],
        ],
    ],

    'tahu-crispy-gurih-pedas' => [
        'name' => 'Tahu Crispy Gurih Pedas', 'img' => 'tahu.jpg',
        'rating' => '4.7', 'reviews' => '145+', 'price' => 5000, 'cats' => 'gurih',
        'desc' => 'Tahu goreng dengan balutan tepung berbumbu renyah kriuk, ditabur bumbu bubuk barbeque…',
        'detail' => 'Tahu goreng dengan balutan tepung berbumbu yang <strong>renyah kriuk</strong> dan tetap lembut di dalam, lalu ditabur bumbu pilihan yang gurih dan pedas. Camilan sederhana yang bikin ketagihan, paling enak dimakan selagi hangat.',
        'options' => [$sausGurih, $toppingGurih],
    ],

    'tempura-jontor-pedas-manis' => [
        'name' => 'Tempura Jontor Pedas Manis', 'img' => 'tempura.jpg',
        'rating' => '4.8', 'reviews' => '312+', 'price' => 5000, 'cats' => 'gurih',
        'desc' => 'Potongan tempura ayam gurih kenyal, digoreng garing dan disiram saus pedas manis mantap.',
        'detail' => 'Potongan tempura ayam yang <strong>gurih dan kenyal</strong>, digoreng garing lalu disiram saus pedas manis yang mantap. Kamu bisa pilih level kepedasannya, dari yang tidak pedas sampai yang bikin berkeringat.',
        'options' => [
            [
                'title' => 'Level Kepedasan',
                'name'  => 'level',
                'type'  => 'radio',
                'note'  => 'Pilih 1 (Wajib)',
                'items' => [
                    ['name' => 'Tidak Pedas',          'desc' => 'Manis gurih saja',       'extra' => 0],
                    ['name' => 'Level 1 (Sedang)',     'desc' => 'Pedasnya pas',           'extra' => 0],
                    ['name' => 'Level 2 (Pedas)',      'desc' => 'Pedas menggigit',        'extra' => 0],
                    ['name' => 'Level 3 (Extra Pedas)','desc' => 'Untuk pecinta pedas',    'extra' => 0],
                ],
            ],
        ],
    ],

    'jamur-crispy' => [
        'name' => 'Jamur Crispy', 'img' => 'jamur.jpg',
        'rating' => '4.8', 'reviews' => '260+', 'price' => 6000, 'cats' => 'gurih',
        'desc' => 'Jamur tiram berbalut tepung berbumbu, digoreng garing kriuk di luar dan lembut gurih di dalam.',
        'detail' => 'Jamur tiram berbalut tepung berbumbu yang digoreng hingga <strong>garing kriuk</strong> di luar, sementara bagian dalamnya tetap lembut dan gurih. Tambahkan saus atau bumbu tabur favoritmu untuk rasa yang makin nagih.',
        'options' => [$sausGurih, $toppingGurih],
    ],

    'jus-buah-segar' => [
        'name' => 'Jus Buah Segar', 'img' => 'jus.jpg',
        'rating' => '4.8', 'reviews' => '230+', 'price' => 7000, 'cats' => 'minuman',
        'desc' => 'Jus buah segar pilihan yang diblender langsung, manis alami dan menyegarkan.',
        'detail' => 'Jus buah segar yang <strong>diblender langsung</strong> saat dipesan, manis alami dan menyegarkan. Pilih buah favoritmu, mulai dari jeruk, mangga, melon, sampai alpukat yang creamy.',
        'options' => [
            [
                'title' => 'Pilihan Buah',
                'name'  => 'buah',
                'type'  => 'radio',
                'note'  => 'Pilih 1 (Wajib)',
                'items' => [
                    ['name' => 'Jeruk',   'desc' => 'Segar asam manis',  'extra' => 0],
                    ['name' => 'Mangga',  'desc' => 'Manis harum',       'extra' => 0],
                    ['name' => 'Melon',   'desc' => 'Manis lembut',      'extra' => 0],
                    ['name' => 'Alpukat', 'desc' => 'Creamy dan legit',  'extra' => 2000],
                ],
            ],
        ],
    ],

    'kentang-goreng' => [
        'name' => 'Kentang Goreng', 'img' => 'kentang.jpg',
        'rating' => '4.7', 'reviews' => '175+', 'price' => 6000, 'cats' => 'gurih',
        'desc' => 'Kentang goreng renyah di luar dan lembut di dalam, ditabur bumbu pilihan yang gurih.',
        'detail' => 'Kentang goreng yang <strong>renyah di luar dan lembut di dalam</strong>, digoreng dadakan dan disajikan hangat. Taburkan bumbu atau saus pilihanmu untuk camilan gurih yang susah berhenti dimakan.',
        'options' => [$sausGurih, $toppingGurih],
    ],

    'mojito' => [
        'name' => 'Mojito', 'img' => 'mojito.jpg',
        'rating' => '4.9', 'reviews' => '510+', 'price' => 6000, 'cats' => 'minuman',
        'desc' => 'Minuman segar perpaduan jeruk nipis dan daun mint yang dingin dan menyegarkan.',
        'detail' => 'Minuman segar perpaduan <strong>jeruk nipis dan daun mint</strong> yang dingin dan menyegarkan, cocok untuk menemani camilan gurih. Pilih rasa original atau varian buah sesuai seleramu.',
        'options' => [
            [
                'title' => 'Pilihan Rasa',
                'name'  => 'rasa',
                'type'  => 'radio',
                'note'  => 'Pilih 1 (Wajib)',
                'items' => [
                    ['name' => 'Original',   'desc' => 'Jeruk nipis & mint',  'extra' => 0],
                    ['name' => 'Strawberry', 'desc' => 'Manis asam segar',    'extra' => 0],
                    ['name' => 'Blueberry',  'desc' => 'Manis fruity',        'extra' => 0],
                ],
            ],
        ],
    ],

    'roti-pao-mini' => [
        'name' => 'Roti Pao Mini', 'img' => 'pao.jpg',
        'rating' => '4.8', 'reviews' => '168+', 'price' => 5000, 'cats' => 'manis',
        'desc' => 'Roti pao mini yang lembut dan empuk, diisi pilihan isian manis dan disajikan hangat.',
        'detail' => 'Roti pao mini yang <strong>lembut dan empuk</strong>, diisi pilihan isian manis lalu disajikan hangat. Ukurannya kecil dan pas dinikmati sebagai camilan, sendiri maupun bareng teman.',
        'options' => [
            [
                'title' => 'Pilihan Isian',
                'name'  => 'isian',
                'type'  => 'radio',
                'note'  => 'Pilih 1 (Wajib)',
                'items' => [
                    ['name' => 'Coklat',       'desc' => 'Manis lumer',         'extra' => 0],
                    ['name' => 'Keju',         'desc' => 'Gurih creamy',        'extra' => 0],
                    ['name' => 'Coklat Keju',  'desc' => 'Manis gurih double',  'extra' => 1000],
                ],
            ],
        ],
    ],

    'chocolatos' => [
        'name' => 'Chocolatos', 'img' => 'chocolatos.jpg',
        'rating' => '4.9', 'reviews' => '480+', 'price' => 5000, 'cats' => 'minuman',
        'desc' => 'Minuman coklat creamy dengan rasa coklat yang pekat, disajikan dingin.',
        'detail' => 'Minuman coklat yang <strong>creamy</strong> dengan rasa coklat pekat, disajikan dingin dan menyegarkan. Tambahkan topping untuk rasa yang lebih kaya di setiap tegukan.',
        'options' => [
            [
                'title' => 'Tambahan Topping',
                'name'  => 'topping[]',
                'type'  => 'checkbox',
                'note'  => 'Bisa pilih lebih dari 1',
                'items' => [
                    ['name' => 'Susu Kental Manis',    'extra' => 1000],
                    ['name' => 'Taburan Choco Crunch', 'extra' => 1000],
                ],
            ],
        ],
    ],

];