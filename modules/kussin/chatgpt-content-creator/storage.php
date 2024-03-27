<?php
$aStorageDefaults = array(
    'version' => '0.0.1',

    'admin' => array(
        'chatgpt_bulk_approval' => array(
            'chatgpt_bulk_actions' => array(
                'page_limits' => array(
                    ['value' => 10, 'label' => '10', 'selected' => false],
                    ['value' => 20, 'label' => '20', 'selected' => false],
                    ['value' => 50, 'label' => '50', 'selected' => false],
                    ['value' => 100, 'label' => '100', 'selected' => false],
                    ['value' => 200, 'label' => '200', 'selected' => true],
                    ['value' => 500, 'label' => '500', 'selected' => false],
                    ['value' => 1000, 'label' => '1000', 'selected' => false],
                ),
            ),
        ),
    ),
);