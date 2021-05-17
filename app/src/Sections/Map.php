<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\TextField;

    class Map extends Section
    {
        private static $singular_name = 'Map';

        private static $db = [
            'MapURL' => 'Text'
        ];

        private static $many_many  = [

        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', TextField::create('MapURL','Map'));
        }
    }
}
