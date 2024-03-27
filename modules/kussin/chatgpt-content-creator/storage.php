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
                'sorting' => array(
                    ['value' => 'id__asc', 'selected' => false],
                    ['value' => 'id__desc', 'selected' => true],
                    ['value' => 'object__asc', 'selected' => false],
                    ['value' => 'object__desc', 'selected' => false],
                    ['value' => 'field__asc', 'selected' => false],
                    ['value' => 'field__desc', 'selected' => false],
                    ['value' => 'status__asc', 'selected' => false],
                    ['value' => 'status__desc', 'selected' => false],
                    ['value' => 'created_at__asc', 'selected' => false],
                    ['value' => 'created_at__desc', 'selected' => false],
                    ['value' => 'updated_at__asc', 'selected' => false],
                    ['value' => 'updated_at__desc', 'selected' => false],
                ),
            ),
        ),
    ),
);