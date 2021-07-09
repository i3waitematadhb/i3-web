<?php

namespace {

    class ImageContent extends Section
    {
        private static $singular_name = 'Image';

        private static $db = [
            'ImageHeight'    => 'Varchar',
            'ImageAnimation' => 'Varchar',
        ];

        private static $has_one = [
            'Image' => Image
        ];

        private static $owns = [
            'Image'
        ];

        private static $defaults = [
            'ImageHeight' => 'bh-large'
        ];
    }
}
