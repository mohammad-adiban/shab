<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => false, // set false to total remove
            'description'  => false, // set false to total remove
            'separator'    => ' - ',
            'keywords'     => false,
            'canonical'    => false, // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'       => 'اقامتگاه های شخصی مسافرتی - شب', // set false to total remove
            'description' => false, // set false to total remove
            'url'         => false,
            'type'        => false,
            'site_name'   => 'شب',
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          'card'        => 'summary',
          'site'        => '@www_shab_ir',
	  'title'	=> 'اجاره ویلا، سایت شب',
	  'description' => 'سایت شب | اجاره ویلا، اجاره ویلا در شمال ایران، اجاره سوئیت، اجاره ویلای استخردار، اجاره ویلای ساحلی، اجاره ویلای جنگلی، اجاره ویلا در کیش، اجاره ویلا در اطرف تهران، اجاره ویلا در شیراز، اجاره ویلا در کیش، اجاره ویلا در محمود آباد، اجاره ویلا در چالوس، اجاره روزانه ویلا در شمال ایران، اجاره ویلا با بهترین قیمت',
        ],
    ],
];
