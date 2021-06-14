<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class QIFeedback extends Section
    {
        private static $singular_name = 'QI Feedback';

        private static $db = [
            'Content' => 'HTMLText',
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
        }
    }
}
