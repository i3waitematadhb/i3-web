<?php

namespace {

    use SilverStripe\Forms\FieldList;
    use SwiftDevLabs\CodeEditorField\Forms\CodeEditorField;

    class CustomCode extends Section
    {
        private static $singular_name = 'Code Editor';

        private static $db = [
            'CodeEditor' => 'HTMLText'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', CodeEditorField::create('Content'));
        }
    }
}
