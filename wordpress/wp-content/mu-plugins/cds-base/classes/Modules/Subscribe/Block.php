<?php

namespace CDS\Modules\Subscribe;

use CDS\Modules\Subscribe\SubscriptionForm as SubscriptionForm;

class Block
{

    public function __construct()
    {
        add_action('plugins_loaded', [ $this, 'init' ]);
    }

    public function init(): void
    {
        add_action('init', [ $this, 'registerBlock' ]);
    }

    public function registerBlock()
    {
        register_block_type_from_metadata(
            __DIR__,
            [
                'render_callback' => [ $this, 'renderCallback' ],
                'attributes' => [
                    'placeholderValue' => [
                        'type' => 'string',
                        "default" => "preview@example.com"
                    ]
                ]
            ]
        );
    }

    public function renderCallback($attributes, $content, $block): string
    {
        $form = new SubscriptionForm();
        return $form->render($attributes);
    }
}