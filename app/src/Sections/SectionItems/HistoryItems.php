<?php

namespace {

    use SilverStripe\ORM\DataObject;

    class HistoryItems extends DataObject
    {
        private static $default_sort = 'Sort';

        private static $db = [
            'Name'    => 'Varchar',
            'Content' => 'HTMLText'
        ];

        private static $has_one = [
            'Parent' => History::class
        ];
    }
}
