<?php

namespace {

    use SilverStripe\ORM\DataObject;

    class ImageItems extends DataObject
    {
        private static $db = [
            'Content' => 'HTMLText'
        ];
    }
}
