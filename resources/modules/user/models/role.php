<?php

return [
    'id' => '02',
    'name' => 'Article',
    'name_plural' => 'Articles',
    'table' => 'news_articles',
    'fields' => [
        'slug' => [
            'label' => 'Slug',
            'type' => 'string',
            'required' => true,
            'rules' => [
                //'unique',
            ],
            'filter' => true,
            'faker' => 'Str::slug($faker->text(40))',
        ],
        'is_active' => [
            'label' => 'Active',
            'required' => true,
            'type' => 'integer',
            'rules' => [
                'in:0,1',
            ],
            'filter' => true,
            'faker' => 'rand(0,1)',
        ],
        'note' => [
            'label' => 'Note',
            'required' => false,
            'type' => 'string',
            'rules' => [
                'max:255',
            ],
            'faker' => '$faker->text(120)',
        ],
    ],
    'translatable' => [
        'owner_id' => 'article_id',
        'fields' => [
            'title' => [
                'label' => 'Title',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],    
                'filter' => true,
                'faker' => '$faker->text(50)',
            ],
            'seo_title' => [
                'label' => 'Seo title',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'min:10',
                    'max:255',
                ],           
                'filter' => true,
                'faker' => '$faker->text(60)',
            ],
            'seo_description' => [
                'label' => 'Seo description',
                'type' => 'string',
                'required' => true,
                'rules' => [
                    'max:255',
                ],
                'filter' => false,    
                'faker' => '$faker->text(120)',
            ],
            'seo_h1' => [
                'label' => 'Seo H1',
                'required' => false,
                'type' => 'string',
                'rules' => [
                    'max: 255',
                ],
                'filter' => true,
                'faker' => '$faker->text(60)',
            ],
            'content' => [
                'label' => 'Content',
                'required' => true,
                'type' => 'string',
                'rules' => [
                    'max: 1024',
                ],
                'faker' => '$faker->text(250)',                
            ],
            
        ],
    ],    
    'routes' => [
        'path' => 'articles',
        //'update_verb' => 'PUT', //POST if image store
    ],
];